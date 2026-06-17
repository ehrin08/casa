<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Service;
use App\Models\Therapist;
use App\Services\TherapistAvailabilityService;
use App\Mail\BookingConfirmationEmail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class BookingController extends Controller
{
    protected $availabilityService;

    public function __construct(TherapistAvailabilityService $availabilityService)
    {
        $this->availabilityService = $availabilityService;
    }

    public function index()
    {
        $bookings = Booking::with(['service', 'therapist.user'])
            ->where('customer_id', auth()->id())
            ->orderBy('appointment_date', 'desc')
            ->orderBy('start_time', 'desc')
            ->paginate(10);

        return view('customer.bookings.index', compact('bookings'));
    }

    public function create()
    {
        $services = Service::where('status', 'available')->get();
        $therapists = Therapist::with('user')->where('status', 'active')->get();
        
        return view('customer.bookings.create', compact('services', 'therapists'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'therapist_id' => 'required', // 'any' or an ID
            'appointment_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'customer_phone' => 'required|string|max:30',
            'notes' => 'nullable|string',
        ]);

        $service = Service::findOrFail($validated['service_id']);
        
        // Calculate end time
        $start = Carbon::parse($validated['start_time']);
        $end = $start->copy()->addMinutes($service->duration_minutes);
        $startTimeStr = $start->format('H:i:s');
        $endTimeStr = $end->format('H:i:s');
        
        $assignedTherapistId = null;

        if ($validated['therapist_id'] === 'any') {
            $availableTherapist = $this->availabilityService->findAvailableTherapist(
                $service->id, 
                $validated['appointment_date'], 
                $startTimeStr, 
                $endTimeStr
            );

            if (!$availableTherapist) {
                return back()->withErrors(['therapist_id' => 'No therapists are available at the requested date and time. Please select another time.'])->withInput();
            }
            $assignedTherapistId = $availableTherapist->id;
        } else {
            // Specific therapist
            $assignedTherapistId = $validated['therapist_id'];
            $therapist = Therapist::findOrFail($assignedTherapistId);

            if ($therapist->status !== 'active') {
                return back()->withErrors(['therapist_id' => 'The selected therapist is currently not active.'])->withInput();
            }

            if (!$this->availabilityService->isTherapistAvailable($assignedTherapistId, $validated['appointment_date'], $startTimeStr, $endTimeStr)) {
                return back()->withErrors(['start_time' => 'The selected therapist is not available or is on break during this time.'])->withInput();
            }

            if ($this->availabilityService->hasConflict($assignedTherapistId, $validated['appointment_date'], $startTimeStr, $endTimeStr)) {
                return back()->withErrors(['start_time' => 'The selected therapist is already booked at this time.'])->withInput();
            }
        }

        $user = auth()->user();

        // Create booking
        $booking = Booking::create([
            'booking_reference' => 'CPB-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -4)),
            'customer_id' => $user->id,
            'created_by_user_id' => $user->id,
            'service_id' => $service->id,
            'therapist_id' => $assignedTherapistId,
            'appointment_date' => $validated['appointment_date'],
            'start_time' => $startTimeStr,
            'end_time' => $endTimeStr,
            'customer_name' => $user->name,
            'customer_email' => $user->email,
            'customer_phone' => $validated['customer_phone'],
            'notes' => $validated['notes'],
            'status' => 'booked',
            'payment_method' => 'cash',
            'payment_status' => 'paid',
            'service_price' => $service->price,
            'amount_paid' => $service->price, // Assumes paid in full via over-the-counter
            'notification_status' => 'pending',
        ]);

        // Send Email
        try {
            Mail::to($booking->customer_email)->send(new BookingConfirmationEmail($booking));
            $booking->update(['notification_status' => 'email_sent']);
        } catch (\Exception $e) {
            \Log::error('Failed to send customer booking confirmation email: ' . $e->getMessage());
            $booking->update(['notification_status' => 'email_failed']);
        }

        return redirect()->route('customer.bookings.show', $booking)
            ->with('success', 'Your appointment has been booked successfully! Please note your reference number: ' . $booking->booking_reference);
    }

    public function show(Booking $booking)
    {
        if ($booking->customer_id !== auth()->id()) {
            abort(403);
        }

        $booking->load(['service', 'therapist.user']);
        return view('customer.bookings.show', compact('booking'));
    }

    public function cancel(Booking $booking)
    {
        if ($booking->customer_id !== auth()->id()) {
            abort(403);
        }

        if ($booking->status !== 'booked') {
            return back()->with('error', 'Only active bookings can be cancelled.');
        }

        $booking->update([
            'status' => 'cancelled',
            'payment_status' => 'cancelled'
        ]);

        return redirect()->route('customer.bookings.index')
            ->with('success', 'Your booking has been cancelled.');
    }
}
