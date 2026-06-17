<x-mail::message>
# Booking Confirmation

Hi {{ $booking->customer_name }},

Thank you for booking with Casa Paraiso – Body and Wellness Spa. Your appointment has been successfully recorded.

**Booking Reference:** {{ $booking->booking_reference }}  
**Status:** {{ ucfirst($booking->status) }}

## Appointment Details

**Service:** {{ $booking->service->name }}  
**Therapist:** {{ $booking->therapist->user->name }}  
**Date:** {{ $booking->appointment_date->format('l, F j, Y') }}  
**Time:** {{ \Carbon\Carbon::parse($booking->start_time)->format('g:i A') }} to {{ \Carbon\Carbon::parse($booking->end_time)->format('g:i A') }}  

## Payment Information

**Amount Paid:** ₱{{ number_format($booking->amount_paid, 2) }}  
**Payment Method:** {{ ucfirst($booking->payment_method) }}  
**Payment Status:** {{ ucfirst($booking->payment_status) }}  

*Payment is recorded as over-the-counter cash for capstone testing.*

If you need to make changes to your booking or cancel, please contact the manager or use your online dashboard.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
