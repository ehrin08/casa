<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Therapist;
use App\Models\TherapistAvailability;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TherapistAvailabilityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = TherapistAvailability::with('therapist.user');

        // Search by therapist name or notes
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('notes', 'like', "%{$search}%")
                  ->orWhereHas('therapist.user', function ($q2) use ($search) {
                      $q2->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by therapist
        if ($request->filled('therapist_id')) {
            $query->where('therapist_id', $request->input('therapist_id'));
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // Filter by date
        if ($request->filled('date')) {
            $query->where('availability_date', $request->input('date'));
        }

        $availabilities = $query->orderBy('availability_date', 'desc')
                                ->orderBy('start_time')
                                ->paginate(10)
                                ->withQueryString();

        $therapists = Therapist::with('user')->where('status', 'active')->get();

        return view('manager.therapist-availabilities.index', compact('availabilities', 'therapists'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $therapists = Therapist::with('user')->where('status', 'active')->get();
        return view('manager.therapist-availabilities.create', compact('therapists'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'therapist_id' => 'required|exists:therapists,id',
            'availability_date' => [
                'required',
                'date',
                Rule::unique('therapist_availabilities')->where(function ($query) use ($request) {
                    return $query->where('therapist_id', $request->therapist_id)
                                 ->whereNull('deleted_at');
                })
            ],
            'status' => 'required|in:available,unavailable,on_leave',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after:start_time',
            'break_start_time' => 'nullable|date_format:H:i',
            'break_end_time' => 'nullable|date_format:H:i|after:break_start_time',
            'notes' => 'nullable|string',
        ]);

        if ($validated['status'] === 'available' && (empty($validated['start_time']) || empty($validated['end_time']))) {
            return back()->withErrors(['start_time' => 'Start and End time are required when status is Available.'])->withInput();
        }

        TherapistAvailability::create($validated);

        return redirect()->route('manager.therapist-availabilities.index')
            ->with('success', 'Therapist availability created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TherapistAvailability $therapistAvailability)
    {
        $therapists = Therapist::with('user')->where('status', 'active')->get();
        return view('manager.therapist-availabilities.edit', compact('therapistAvailability', 'therapists'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TherapistAvailability $therapistAvailability)
    {
        $validated = $request->validate([
            'therapist_id' => 'required|exists:therapists,id',
            'availability_date' => [
                'required',
                'date',
                Rule::unique('therapist_availabilities')->where(function ($query) use ($request, $therapistAvailability) {
                    return $query->where('therapist_id', $request->therapist_id)
                                 ->whereNull('deleted_at');
                })->ignore($therapistAvailability->id)
            ],
            'status' => 'required|in:available,unavailable,on_leave',
            'start_time' => 'nullable|date_format:H:i:s,H:i',
            'end_time' => 'nullable|date_format:H:i:s,H:i|after:start_time',
            'break_start_time' => 'nullable|date_format:H:i:s,H:i',
            'break_end_time' => 'nullable|date_format:H:i:s,H:i|after:break_start_time',
            'notes' => 'nullable|string',
        ]);

        if ($validated['status'] === 'available' && (empty($validated['start_time']) || empty($validated['end_time']))) {
            return back()->withErrors(['start_time' => 'Start and End time are required when status is Available.'])->withInput();
        }

        $therapistAvailability->update($validated);

        return redirect()->route('manager.therapist-availabilities.index')
            ->with('success', 'Therapist availability updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TherapistAvailability $therapistAvailability)
    {
        $therapistAvailability->delete();

        return redirect()->route('manager.therapist-availabilities.index')
            ->with('success', 'Therapist availability deleted successfully.');
    }
}
