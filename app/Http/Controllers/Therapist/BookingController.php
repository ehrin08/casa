<?php

namespace App\Http\Controllers\Therapist;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Service;
use App\Services\TherapistAvailabilityService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    protected $availabilityService;

    public function __construct(TherapistAvailabilityService $availabilityService)
    {
        $this->availabilityService = $availabilityService;
    }

    public function index()
    {
        $therapist = auth()->user()->therapist;
        
        if (!$therapist) {
            abort(403, 'No therapist profile found.');
        }

        $bookings = Booking::with(['service', 'customer'])
            ->where('therapist_id', $therapist->id)
            ->orderBy('appointment_date', 'desc')
            ->orderBy('start_time', 'desc')
            ->paginate(10);

        return view('therapist.bookings.index', compact('bookings'));
    }

    public function create()
    {
        $services = Service::where('status', 'available')->get();
        return view('therapist.bookings.create', compact('services'));
    }

    public function store(Request $request)
    {
        $therapist = auth()->user()->therapist;
        
        if (!$therapist) {
            abort(403);
        }

        if ($therapist->status !== 'active') {
            return back()->with('error', 'Your profile is currently inactive. You cannot create bookings.');
        }

        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'nullable|string|max:30',
            'notes' => 'nullable|string',
        ]);

        $service = Service::findOrFail($validated['service_id']);
        
        // Calculate end time
        $start = Carbon::parse($validated['start_time']);
        $end = $start->copy()->addMinutes($service->duration_minutes);
        $startTimeStr = $start->format('H:i:s');
        $endTimeStr = $end->format('H:i:s');
        
        if (!$this->availabilityService->isTherapistAvailable($therapist->id, $validated['appointment_date'], $startTimeStr, $endTimeStr)) {
            return back()->withErrors(['start_time' => 'You are not scheduled as available or are on break during this time.'])->withInput();
        }

        if ($this->availabilityService->hasConflict($therapist->id, $validated['appointment_date'], $startTimeStr, $endTimeStr)) {
            return back()->withErrors(['start_time' => 'You already have a booking at this time.'])->withInput();
        }

        // Create booking
        $booking = Booking::create([
            'booking_reference' => 'CPB-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -4)),
            'customer_id' => null, // Walk-in assumed guest
            'created_by_user_id' => auth()->id(),
            'service_id' => $service->id,
            'therapist_id' => $therapist->id,
            'appointment_date' => $validated['appointment_date'],
            'start_time' => $startTimeStr,
            'end_time' => $endTimeStr,
            'customer_name' => $validated['customer_name'],
            'customer_phone' => $validated['customer_phone'],
            'notes' => $validated['notes'],
            'status' => 'booked',
            'payment_method' => 'cash',
            'payment_status' => 'paid',
            'service_price' => $service->price,
            'amount_paid' => $service->price,
            'notification_status' => 'none',
        ]);

        return redirect()->route('therapist.bookings.index')
            ->with('success', 'Walk-in booking created successfully.');
    }

    public function show(Booking $booking)
    {
        $therapist = auth()->user()->therapist;
        
        if (!$therapist || $booking->therapist_id !== $therapist->id) {
            abort(403);
        }

        $booking->load(['service', 'customer']);
        return view('therapist.bookings.show', compact('booking'));
    }
}
