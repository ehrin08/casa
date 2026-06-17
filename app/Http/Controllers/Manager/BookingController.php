<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Service;
use App\Models\Therapist;
use App\Models\User;
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

    public function index(Request $request)
    {
        $query = Booking::with(['customer', 'service', 'therapist.user']);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('booking_reference', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_email', 'like', "%{$search}%")
                  ->orWhere('customer_phone', 'like', "%{$search}%")
                  ->orWhereHas('service', function ($q2) use ($search) {
                      $q2->where('name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('therapist.user', function ($q3) use ($search) {
                      $q3->where('name', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->input('payment_status'));
        }

        if ($request->filled('service_id')) {
            $query->where('service_id', $request->input('service_id'));
        }

        if ($request->filled('therapist_id')) {
            $query->where('therapist_id', $request->input('therapist_id'));
        }

        if ($request->filled('date')) {
            $query->where('appointment_date', $request->input('date'));
        }

        $bookings = $query->orderBy('appointment_date', 'desc')
                          ->orderBy('start_time', 'desc')
                          ->paginate(10)
                          ->withQueryString();

        $services = Service::where('status', 'available')->get();
        $therapists = Therapist::with('user')->where('status', 'active')->get();

        return view('manager.bookings.index', compact('bookings', 'services', 'therapists'));
    }

    public function create()
    {
        $services = Service::where('status', 'available')->get();
        $therapists = Therapist::with('user')->where('status', 'active')->get();
        
        return view('manager.bookings.create', compact('services', 'therapists'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'therapist_id' => 'required', // can be 'any' or an ID
            'appointment_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'nullable|email|max:255',
            'customer_phone' => 'nullable|string|max:30',
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
                return back()->withErrors(['therapist_id' => 'No therapists are available at the requested date and time.'])->withInput();
            }
            $assignedTherapistId = $availableTherapist->id;
        } else {
            // Specific therapist chosen
            $assignedTherapistId = $validated['therapist_id'];
            $therapist = Therapist::findOrFail($assignedTherapistId);

            if ($therapist->status !== 'active') {
                return back()->withErrors(['therapist_id' => 'The selected therapist is not active.'])->withInput();
            }

            if (!$this->availabilityService->isTherapistAvailable($assignedTherapistId, $validated['appointment_date'], $startTimeStr, $endTimeStr)) {
                return back()->withErrors(['start_time' => 'The selected therapist is not available or is on break during this time.'])->withInput();
            }

            if ($this->availabilityService->hasConflict($assignedTherapistId, $validated['appointment_date'], $startTimeStr, $endTimeStr)) {
                return back()->withErrors(['start_time' => 'The selected therapist already has a booking at this time.'])->withInput();
            }
        }

        // Try to link customer account by email if provided
        $customerId = null;
        if (!empty($validated['customer_email'])) {
            $existingUser = User::where('email', $validated['customer_email'])->where('role', 'customer')->first();
            if ($existingUser) {
                $customerId = $existingUser->id;
            }
        }

        // Create booking
        $booking = Booking::create([
            'booking_reference' => 'CPB-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -4)),
            'customer_id' => $customerId,
            'created_by_user_id' => auth()->id(),
            'service_id' => $service->id,
            'therapist_id' => $assignedTherapistId,
            'appointment_date' => $validated['appointment_date'],
            'start_time' => $startTimeStr,
            'end_time' => $endTimeStr,
            'customer_name' => $validated['customer_name'],
            'customer_email' => $validated['customer_email'],
            'customer_phone' => $validated['customer_phone'],
            'notes' => $validated['notes'],
            'status' => 'booked',
            'payment_method' => 'cash',
            'payment_status' => 'paid',
            'service_price' => $service->price,
            'amount_paid' => $service->price, // Defaulting to full price paid
            'notification_status' => 'pending',
        ]);

        // Send Email
        if ($booking->customer_email) {
            try {
                Mail::to($booking->customer_email)->send(new BookingConfirmationEmail($booking));
                $booking->update(['notification_status' => 'email_sent']);
            } catch (\Exception $e) {
                \Log::error('Failed to send booking confirmation email: ' . $e->getMessage());
                $booking->update(['notification_status' => 'email_failed']);
            }
        }

        return redirect()->route('manager.bookings.index')
            ->with('success', 'Booking created successfully. Reference: ' . $booking->booking_reference);
    }

    public function show(Booking $booking)
    {
        $booking->load(['customer', 'service', 'therapist.user', 'creator']);
        return view('manager.bookings.show', compact('booking'));
    }

    public function edit(Booking $booking)
    {
        $services = Service::where('status', 'available')->get();
        $therapists = Therapist::with('user')->where('status', 'active')->get();
        return view('manager.bookings.edit', compact('booking', 'services', 'therapists'));
    }

    public function update(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'therapist_id' => 'required|exists:therapists,id',
            'appointment_date' => 'required|date',
            'start_time' => 'required|date_format:H:i:s,H:i',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'nullable|email|max:255',
            'customer_phone' => 'nullable|string|max:30',
            'notes' => 'nullable|string',
            'status' => 'required|in:booked,completed,cancelled',
        ]);

        // If status is cancelled or completed, we might not need strict time checks,
        // but if they are updating a booked appointment's time, we should check conflicts.
        if ($validated['status'] === 'booked') {
            $service = Service::findOrFail($validated['service_id']);
            $start = Carbon::parse($validated['start_time']);
            $end = $start->copy()->addMinutes($service->duration_minutes);
            $startTimeStr = $start->format('H:i:s');
            $endTimeStr = $end->format('H:i:s');

            $assignedTherapistId = $validated['therapist_id'];

            // Check if time or therapist changed
            if ($booking->therapist_id != $assignedTherapistId || 
                $booking->appointment_date->format('Y-m-d') !== $validated['appointment_date'] || 
                $booking->start_time !== $startTimeStr) {
                
                if (!$this->availabilityService->isTherapistAvailable($assignedTherapistId, $validated['appointment_date'], $startTimeStr, $endTimeStr)) {
                    return back()->withErrors(['start_time' => 'The selected therapist is not available or is on break during this time.'])->withInput();
                }

                if ($this->availabilityService->hasConflict($assignedTherapistId, $validated['appointment_date'], $startTimeStr, $endTimeStr, $booking->id)) {
                    return back()->withErrors(['start_time' => 'The selected therapist already has a booking at this time.'])->withInput();
                }
            }

            $validated['end_time'] = $endTimeStr;
            $validated['start_time'] = $startTimeStr;
        } else {
            // Keep existing end_time if we're just cancelling/completing, but use updated start_time if provided.
            $service = Service::findOrFail($validated['service_id']);
            $start = Carbon::parse($validated['start_time']);
            $end = $start->copy()->addMinutes($service->duration_minutes);
            $validated['start_time'] = $start->format('H:i:s');
            $validated['end_time'] = $end->format('H:i:s');
        }

        // Handle payment status implicitly for cancellations
        if ($validated['status'] === 'cancelled') {
            $validated['payment_status'] = 'cancelled';
        }

        $booking->update($validated);

        return redirect()->route('manager.bookings.index')
            ->with('success', 'Booking updated successfully.');
    }

    public function destroy(Booking $booking)
    {
        $booking->delete();
        return redirect()->route('manager.bookings.index')
            ->with('success', 'Booking deleted successfully.');
    }
}
