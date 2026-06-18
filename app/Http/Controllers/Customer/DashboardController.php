<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Service;
use App\Models\Transaction;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // 1. Next upcoming appointment
        $nextAppointment = Booking::with(['service', 'therapist.user'])
            ->where('customer_id', $user->id)
            ->where('status', 'booked')
            ->where(function ($query) {
                $query->where('booking_date', '>', now()->toDateString())
                      ->orWhere(function ($q) {
                          $q->where('booking_date', now()->toDateString())
                            ->where('start_time', '>=', now()->toTimeString());
                      });
            })
            ->orderBy('booking_date')
            ->orderBy('start_time')
            ->first();

        // 2. Next 3 upcoming appointments
        $upcomingAppointments = Booking::with(['service', 'therapist.user'])
            ->where('customer_id', $user->id)
            ->where('status', 'booked')
            ->where(function ($query) {
                $query->where('booking_date', '>', now()->toDateString())
                      ->orWhere(function ($q) {
                          $q->where('booking_date', now()->toDateString())
                            ->where('start_time', '>=', now()->toTimeString());
                      });
            })
            ->orderBy('booking_date')
            ->orderBy('start_time')
            ->take(3)
            ->get();

        // 3. Recent Bookings (any status)
        $recentBookings = Booking::with(['service', 'therapist.user'])
            ->where('customer_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        // 4. Available Services
        $availableServicesCount = Service::where('status', 'active')->count();
        $availableServices = Service::where('status', 'active')
            ->inRandomOrder() // Or order by 'created_at' desc
            ->take(4)
            ->get();

        // 5. Payment History / Receipts
        $receiptsCount = Transaction::where('customer_id', $user->id)->count();
        $recentTransactions = Transaction::with(['service'])
            ->where('customer_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        // 6. Cancellable booking check
        // We'll reuse $nextAppointment, since if the closest appointment is cancellable, we can link to it.
        // A booking is cancellable if it's 'booked' and still in the future. We can check if $nextAppointment exists.
        $canCancel = $nextAppointment !== null;

        return view('customer.dashboard', compact(
            'nextAppointment',
            'upcomingAppointments',
            'recentBookings',
            'availableServicesCount',
            'availableServices',
            'receiptsCount',
            'recentTransactions',
            'canCancel'
        ));
    }
}
