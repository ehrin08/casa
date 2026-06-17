<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Therapist;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class TherapistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Therapist::with('user');

        // Search by name, email, phone, specialization
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($q2) use ($search) {
                    $q2->where('name', 'like', "%{$search}%")
                       ->orWhere('email', 'like', "%{$search}%");
                })
                ->orWhere('phone', 'like', "%{$search}%")
                ->orWhere('specialization', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // Filter by specialization
        if ($request->filled('specialization')) {
            $query->where('specialization', $request->input('specialization'));
        }

        // Get unique specializations for the filter dropdown
        $specializations = Therapist::select('specialization')->distinct()->pluck('specialization');

        $therapists = $query->paginate(10)->withQueryString();

        return view('manager.therapists.index', compact('therapists', 'specializations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('manager.therapists.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:30',
            'specialization' => 'required|string|max:255',
            'status' => 'required|in:active,inactive,on_leave',
        ]);

        // Create the linked User
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make('password'),
            'role' => 'therapist',
        ]);

        // Create Therapist profile
        $user->therapist()->create([
            'phone' => $validated['phone'],
            'specialization' => $validated['specialization'],
            'status' => $validated['status'],
        ]);

        return redirect()->route('manager.therapists.index')
            ->with('success', 'Therapist account created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Therapist $therapist)
    {
        return view('manager.therapists.show', compact('therapist'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Therapist $therapist)
    {
        $therapist->load('user');
        return view('manager.therapists.edit', compact('therapist'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Therapist $therapist)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($therapist->user_id)],
            'phone' => 'nullable|string|max:30',
            'specialization' => 'required|string|max:255',
            'status' => 'required|in:active,inactive,on_leave',
        ]);

        // Update User
        $therapist->user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        // Update Therapist profile
        $therapist->update([
            'phone' => $validated['phone'],
            'specialization' => $validated['specialization'],
            'status' => $validated['status'],
        ]);

        return redirect()->route('manager.therapists.index')
            ->with('success', 'Therapist updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Therapist $therapist)
    {
        // Soft delete the therapist profile
        $therapist->delete();

        return redirect()->route('manager.therapists.index')
            ->with('success', 'Therapist deleted successfully.');
    }
}
