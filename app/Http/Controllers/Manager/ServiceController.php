<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Service::query();

        // Search by name or description
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category', $request->input('category'));
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $services = $query->orderBy('name')->paginate(10)->withQueryString();

        return view('manager.services.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('manager.services.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:Massage,Nails,Facial,Body Treatment,Package',
            'price' => 'required|numeric|min:0',
            'duration_minutes' => 'required|integer|min:1',
            'commission_rate' => 'required|numeric|min:0|max:100',
            'description' => 'nullable|string',
            'status' => 'required|in:available,unavailable',
        ]);

        Service::create($validated);

        return redirect()->route('manager.services.index')
            ->with('success', 'Service created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service)
    {
        return view('manager.services.show', compact('service'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service)
    {
        return view('manager.services.edit', compact('service'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:Massage,Nails,Facial,Body Treatment,Package',
            'price' => 'required|numeric|min:0',
            'duration_minutes' => 'required|integer|min:1',
            'commission_rate' => 'required|numeric|min:0|max:100',
            'description' => 'nullable|string',
            'status' => 'required|in:available,unavailable',
        ]);

        $service->update($validated);

        return redirect()->route('manager.services.index')
            ->with('success', 'Service updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        $service->delete();

        return redirect()->route('manager.services.index')
            ->with('success', 'Service deleted successfully.');
    }
}
