<x-therapist-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-spa-charcoal leading-tight">
            {{ __('Assigned Booking Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-4">
                <a href="{{ route('therapist.bookings.index') }}" class="text-[#2c3e38] hover:text-[#1f2d28] font-medium text-sm">
                    &larr; Back to My Bookings
                </a>
            </div>

            <div class="bg-spa-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8">
                    <div class="flex justify-between items-start border-b border-spa-beige pb-6 mb-6">
                        <div>
                            <h3 class="text-2xl font-bold text-spa-charcoal">{{ $booking->service->name }}</h3>
                            <p class="text-sm text-spa-gray opacity-80 mt-1">Ref: {{ $booking->booking_reference }}</p>
                        </div>
                        <div>
                            <x-ui.status-badge :status="$booking->status" />
                        </div>
                    </div>

                    <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-spa-gray opacity-80">Date & Time</dt>
                            <dd class="mt-1 text-sm text-spa-charcoal">
                                {{ $booking->appointment_date->format('l, F j, Y') }}<br>
                                {{ \Carbon\Carbon::parse($booking->start_time)->format('g:i A') }} to {{ \Carbon\Carbon::parse($booking->end_time)->format('g:i A') }}
                            </dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-spa-gray opacity-80">Customer Name</dt>
                            <dd class="mt-1 text-sm text-spa-charcoal">{{ $booking->customer_name }}</dd>
                        </div>

                        <div class="sm:col-span-2 border-t border-spa-beige pt-4">
                            <dt class="text-sm font-medium text-spa-gray opacity-80">Notes / Special Requests</dt>
                            <dd class="mt-1 text-sm text-spa-charcoal whitespace-pre-line">{{ $booking->notes ?: 'None' }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</x-therapist-layout>

