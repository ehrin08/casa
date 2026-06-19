<x-customer-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Booking Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-4">
                <a href="{{ route('customer.bookings.index') }}" class="text-[#2c3e38] hover:text-[#1f2d28] font-medium text-sm">
                    &larr; Back to My Appointments
                </a>
            </div>


            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8">
                    <div class="flex justify-between items-start border-b border-gray-100 pb-6 mb-6">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900">{{ $booking->service->name }}</h3>
                            <p class="text-sm text-gray-500 mt-1">Ref: {{ $booking->booking_reference }}</p>
                        </div>
                        <div>
                            <x-ui.status-badge :status="$booking->status" />
                        </div>
                    </div>

                    <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Date & Time</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $booking->appointment_date->format('l, F j, Y') }}<br>
                                {{ \Carbon\Carbon::parse($booking->start_time)->format('g:i A') }} to {{ \Carbon\Carbon::parse($booking->end_time)->format('g:i A') }}
                            </dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Therapist</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $booking->therapist->user->name }}</dd>
                        </div>

                        <div class="sm:col-span-1 border-t border-gray-100 pt-4">
                            <dt class="text-sm font-medium text-gray-500">Payment Method</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ ucfirst($booking->payment_method) }}</dd>
                        </div>
                        <div class="sm:col-span-1 border-t border-gray-100 pt-4">
                            <dt class="text-sm font-medium text-gray-500">Amount Paid</dt>
                            <dd class="mt-1 text-sm text-gray-900">₱{{ number_format($booking->amount_paid, 2) }}</dd>
                        </div>

                        <div class="sm:col-span-2 border-t border-gray-100 pt-4">
                            <dt class="text-sm font-medium text-gray-500">Notes / Special Requests</dt>
                            <dd class="mt-1 text-sm text-gray-900 whitespace-pre-line">{{ $booking->notes ?: 'None' }}</dd>
                        </div>
                    </dl>

                    @if($booking->status === 'booked')
                        <div class="mt-8 pt-6 border-t border-gray-200">
                            <button type="button" x-data="" x-on:click="$dispatch('open-modal-confirm-cancel-booking-{{ $booking->id }}')" class="text-red-600 hover:text-red-900 text-sm font-medium">
                                Cancel Appointment
                            </button>
                            <x-ui.confirm-modal 
                                id="confirm-cancel-booking-{{ $booking->id }}"
                                name="confirm-cancel-booking-{{ $booking->id }}"
                                title="Cancel Appointment"
                                message="Are you sure you want to cancel this appointment?"
                                action="{{ route('customer.bookings.cancel', $booking) }}"
                                method="PATCH"
                                confirmText="Cancel Appointment"
                                type="danger"
                            />
                        </div>
                    @elseif($booking->status === 'completed')
                        <div class="mt-8 pt-6 border-t border-gray-200 flex justify-between items-center">
                            <p class="text-sm text-gray-500">Thank you for visiting Casa Paraiso.</p>
                            @if($booking->review)
                                <a href="{{ route('customer.reviews.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#2c3e38]">
                                    View Your Review
                                </a>
                            @else
                                <a href="{{ route('customer.reviews.create', $booking) }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-[#2c3e38] hover:bg-[#1f2d28] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#2c3e38]">
                                    Leave a Review
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-customer-layout>

