<x-manager-layout>
    <x-slot name="header">
        Booking Details
    </x-slot>

    <div class="mb-6 flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Booking: {{ $booking->booking_reference }}</h2>
            <p class="text-sm text-gray-500 mt-1">Created on {{ $booking->created_at->format('M d, Y g:i A') }}</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('manager.bookings.edit', $booking) }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-[#2c3e38] focus:ring-offset-2 transition ease-in-out duration-150">
                Edit Booking
            </a>
            <a href="{{ route('manager.bookings.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-offset-2 transition ease-in-out duration-150">
                Back to List
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Main Details -->
        <div class="md:col-span-2 space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Appointment Information</h3>
                </div>
                <div class="p-6">
                    <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Date</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $booking->appointment_date->format('l, F j, Y') }}</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Time</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ \Carbon\Carbon::parse($booking->start_time)->format('g:i A') }} - {{ \Carbon\Carbon::parse($booking->end_time)->format('g:i A') }}</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Service</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $booking->service->name }} ({{ $booking->service->duration_minutes }} mins)</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Therapist</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $booking->therapist->user->name }}</dd>
                        </div>
                        <div class="sm:col-span-2">
                            <dt class="text-sm font-medium text-gray-500">Status</dt>
                            <dd class="mt-2">
                                @if($booking->status === 'booked')
                                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Booked</span>
                                @elseif($booking->status === 'completed')
                                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-green-100 text-green-800">Completed</span>
                                @else
                                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-red-100 text-red-800">Cancelled</span>
                                @endif
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Customer Details</h3>
                </div>
                <div class="p-6">
                    <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Name</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $booking->customer_name }}</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Registered Account</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                @if($booking->customer_id)
                                    <span class="text-green-600 font-medium">Yes</span>
                                @else
                                    <span class="text-gray-500 italic">No (Guest)</span>
                                @endif
                            </dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Email</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $booking->customer_email ?? '-' }}</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Phone</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $booking->customer_phone ?? '-' }}</dd>
                        </div>
                        <div class="sm:col-span-2 border-t border-gray-100 pt-4 mt-2">
                            <dt class="text-sm font-medium text-gray-500">Notes / Special Requests</dt>
                            <dd class="mt-1 text-sm text-gray-900 whitespace-pre-line">{{ $booking->notes ?: 'None' }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>

        <!-- Sidebar Details -->
        <div class="space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Payment & Billing</h3>
                </div>
                <div class="p-6">
                    <dl class="space-y-4">
                        <div class="flex justify-between">
                            <dt class="text-sm font-medium text-gray-500">Service Price</dt>
                            <dd class="text-sm font-medium text-gray-900">₱{{ number_format($booking->service_price, 2) }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm font-medium text-gray-500">Amount Paid</dt>
                            <dd class="text-sm font-bold text-gray-900">₱{{ number_format($booking->amount_paid, 2) }}</dd>
                        </div>
                        <div class="pt-4 border-t border-gray-100">
                            <dt class="text-sm font-medium text-gray-500 mb-2">Payment Method</dt>
                            <dd>
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">{{ ucfirst($booking->payment_method) }}</span>
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 mb-2">Payment Status</dt>
                            <dd>
                                @if($booking->payment_status === 'paid')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-50 text-green-700 border border-green-200">Paid</span>
                                @elseif($booking->payment_status === 'cancelled')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-50 text-gray-600 border border-gray-200">Cancelled</span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-50 text-yellow-700 border border-yellow-200">Unpaid</span>
                                @endif
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">System Logs</h3>
                </div>
                <div class="p-6">
                    <dl class="space-y-4">
                        <div>
                            <dt class="text-xs font-medium text-gray-500">Created By</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $booking->creator ? $booking->creator->name : 'System/Guest' }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium text-gray-500">Email Notification</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                @if($booking->notification_status === 'email_sent')
                                    <span class="text-green-600">Sent Successfully</span>
                                @elseif($booking->notification_status === 'email_failed')
                                    <span class="text-red-600">Failed to Send</span>
                                @else
                                    <span class="text-gray-500">Pending / None</span>
                                @endif
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</x-manager-layout>
