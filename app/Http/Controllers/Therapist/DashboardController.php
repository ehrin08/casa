<?php

namespace App\Http\Controllers\Therapist;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Commission;
use App\Models\TherapistAvailability;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $therapist = $user->therapist;

        if (!$therapist) {
            return view('therapist.dashboard', ['therapist' => null]);
        }

        $today = Carbon::today()->toDateString();
        $now = Carbon::now()->toTimeString();

        // 1. Today's Schedule Count
        $todayAssignedBookingsCount = Booking::where('therapist_id', $therapist->id)
            ->where('booking_date', $today)
            ->where('status', 'booked')
            ->count();

        // 2. Upcoming Bookings Count
        $upcomingBookingsCount = Booking::where('therapist_id', $therapist->id)
            ->where('status', 'booked')
            ->where(function ($query) use ($today, $now) {
                $query->where('booking_date', '>', $today)
                      ->orWhere(function ($q) use ($today, $now) {
                          $q->where('booking_date', $today)
                            ->where('start_time', '>=', $now);
                      });
            })
            ->count();

        // 3. Unpaid Commission Total
        $unpaidCommissionTotal = Commission::where('therapist_id', $therapist->id)
            ->where('status', 'unpaid')
            ->sum('commission_amount');

        // 4. Paid Commission Total
        $paidCommissionTotal = Commission::where('therapist_id', $therapist->id)
            ->where('status', 'paid')
            ->sum('commission_amount');

        // 5. Completed Bookings Count
        $completedBookingsCount = Booking::where('therapist_id', $therapist->id)
            ->where('status', 'completed')
            ->count();

        // 6. Next Availability Count
        $upcomingAvailabilityCount = TherapistAvailability::where('therapist_id', $therapist->id)
            ->where('availability_date', '>=', $today)
            ->count();

        // Previews
        // Today's Bookings
        $todayBookings = Booking::with(['service', 'customer'])
            ->where('therapist_id', $therapist->id)
            ->where('booking_date', $today)
            ->orderBy('start_time')
            ->get();

        // Upcoming Bookings (Next 5)
        $upcomingBookings = Booking::with(['service', 'customer'])
            ->where('therapist_id', $therapist->id)
            ->where('status', 'booked')
            ->where(function ($query) use ($today, $now) {
                $query->where('booking_date', '>', $today)
                      ->orWhere(function ($q) use ($today, $now) {
                          $q->where('booking_date', $today)
                            ->where('start_time', '>=', $now);
                      });
            })
            ->orderBy('booking_date')
            ->orderBy('start_time')
            ->take(5)
            ->get();

        // Upcoming Availability (Next 5)
        $upcomingAvailability = TherapistAvailability::where('therapist_id', $therapist->id)
            ->where('availability_date', '>=', $today)
            ->orderBy('availability_date')
            ->orderBy('start_time')
            ->take(5)
            ->get();

        // Commission Preview (Recent 5)
        $recentCommissions = Commission::with(['service'])
            ->where('therapist_id', $therapist->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('therapist.dashboard', compact(
            'therapist',
            'todayAssignedBookingsCount',
            'upcomingBookingsCount',
            'unpaidCommissionTotal',
            'paidCommissionTotal',
            'completedBookingsCount',
            'upcomingAvailabilityCount',
            'todayBookings',
            'upcomingBookings',
            'upcomingAvailability',
            'recentCommissions'
        ));
    }
}
