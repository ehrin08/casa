<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource for customers.
     */
    public function index()
    {
        // Customers can only see available services
        $services = Service::where('status', 'available')
                            ->orderBy('category')
                            ->orderBy('name')
                            ->get();

        // Group by category for nicer display
        $servicesByCategory = $services->groupBy('category');

        $user = auth()->user();
        $therapists = \App\Models\Therapist::with('user')->where('status', 'active')->get();
        $availablePromotions = \App\Models\CustomerPromotion::where('customer_id', $user->id)
            ->where('status', 'available')
            ->where(function($query) {
                $query->whereNull('expires_at')
                      ->orWhere('expires_at', '>', now());
            })->with('rule')->get();

        return view('customer.services.index', compact('services', 'servicesByCategory', 'therapists', 'availablePromotions'));
    }
}
