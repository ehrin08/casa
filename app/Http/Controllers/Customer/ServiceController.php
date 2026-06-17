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

        return view('customer.services.index', compact('servicesByCategory'));
    }
}
