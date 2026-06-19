<x-manager-layout>
    <x-slot name="header">
        Booking Details
    </x-slot>

    <div class="mb-6 flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-spa-charcoal">Booking: {{ $booking->booking_reference }}</h2>
            <p class="text-sm text-spa-gray opacity-80 mt-1">Created on {{ $booking->created_at->format('M d, Y g:i A') }}</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('manager.bookings.edit', $booking) }}" class="inline-flex items-center px-4 py-2 bg-spa-white border border-spa-wood rounded-md font-semibold text-xs text-spa-charcoal opacity-90 uppercase tracking-widest shadow-sm hover:bg-spa-beige focus:outline-none focus:ring-2 focus:ring-[#2c3e38] focus:ring-offset-2 transition ease-in-out duration-150">
                Edit Booking
            </a>
            <a href="{{ route('manager.bookings.index') }}" class="inline-flex items-center px-4 py-2 bg-spa-beige border border-transparent rounded-md font-semibold text-xs text-spa-charcoal opacity-90 uppercase tracking-widest hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-offset-2 transition ease-in-out duration-150">
                Back to List
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Main Details -->
        <div class="md:col-span-2 space-y-6">
            <div class="bg-spa-white rounded-xl shadow-sm border border-spa-beige overflow-hidden">
                <div class="px-6 py-5 border-b border-spa-beige bg-gray-50/50">
                    <h3 class="text-lg font-medium leading-6 text-spa-charcoal">Appointment Information</h3>
                </div>
                <div class="p-6">
                    <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-spa-gray opacity-80">Date</dt>
                            <dd class="mt-1 text-sm text-spa-charcoal">{{ $booking->appointment_date->format('l, F j, Y') }}</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-spa-gray opacity-80">Time</dt>
                            <dd class="mt-1 text-sm text-spa-charcoal">{{ \Carbon\Carbon::parse($booking->start_time)->format('g:i A') }} - {{ \Carbon\Carbon::parse($booking->end_time)->format('g:i A') }}</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-spa-gray opacity-80">Service</dt>
                            <dd class="mt-1 text-sm text-spa-charcoal">{{ $booking->service->name }} ({{ $booking->service->duration_minutes }} mins)</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-spa-gray opacity-80">Therapist</dt>
                            <dd class="mt-1 text-sm text-spa-charcoal">{{ $booking->therapist->user->name }}</dd>
                        </div>
                        <div class="sm:col-span-2">
                            <dt class="text-sm font-medium text-spa-gray opacity-80">Status</dt>
                            <dd class="mt-2">
                                <x-ui.status-badge :status="$booking->status" />
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>

            <div class="bg-spa-white rounded-xl shadow-sm border border-spa-beige overflow-hidden">
                <div class="px-6 py-5 border-b border-spa-beige bg-gray-50/50">
                    <h3 class="text-lg font-medium leading-6 text-spa-charcoal">Customer Details</h3>
                </div>
                <div class="p-6">
                    <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-spa-gray opacity-80">Name</dt>
                            <dd class="mt-1 text-sm text-spa-charcoal">{{ $booking->customer_name }}</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-spa-gray opacity-80">Registered Account</dt>
                            <dd class="mt-1 text-sm text-spa-charcoal">
                                @if($booking->customer_id)
                                    <span class="text-green-600 font-medium">Yes</span>
                                @else
                                    <span class="text-spa-gray opacity-80 italic">No (Guest)</span>
                                @endif
                            </dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-spa-gray opacity-80">Email</dt>
                            <dd class="mt-1 text-sm text-spa-charcoal">{{ $booking->customer_email ?? '-' }}</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-spa-gray opacity-80">Phone</dt>
                            <dd class="mt-1 text-sm text-spa-charcoal">{{ $booking->customer_phone ?? '-' }}</dd>
                        </div>
                        <div class="sm:col-span-2 border-t border-spa-beige pt-4 mt-2">
                            <dt class="text-sm font-medium text-spa-gray opacity-80">Notes / Special Requests</dt>
                            <dd class="mt-1 text-sm text-spa-charcoal whitespace-pre-line">{{ $booking->notes ?: 'None' }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>

        <!-- Sidebar Details -->
        <div class="space-y-6">
            <div class="bg-spa-white rounded-xl shadow-sm border border-spa-beige overflow-hidden">
                <div class="px-6 py-5 border-b border-spa-beige bg-gray-50/50">
                    <h3 class="text-lg font-medium leading-6 text-spa-charcoal">Payment & Billing</h3>
                </div>
                <div class="p-6">
                    <dl class="space-y-4">
                        <div class="flex justify-between">
                            <dt class="text-sm font-medium text-spa-gray opacity-80">Service Price</dt>
                            <dd class="text-sm font-medium text-spa-charcoal">₱{{ number_format($booking->service_price, 2) }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm font-medium text-spa-gray opacity-80">Amount Paid</dt>
                            <dd class="text-sm font-bold text-spa-charcoal">₱{{ number_format($booking->amount_paid, 2) }}</dd>
                        </div>
                        <div class="pt-4 border-t border-spa-beige">
                            <dt class="text-sm font-medium text-spa-gray opacity-80 mb-2">Payment Method</dt>
                            <dd>
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-spa-beige text-spa-charcoal">{{ ucfirst($booking->payment_method) }}</span>
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-spa-gray opacity-80 mb-2">Payment Status</dt>
                            <dd>
                                <x-ui.status-badge :status="$booking->payment_status" />
                            </dd>
                        </div>
                        
                        <div class="pt-4 border-t border-spa-beige">
                            @if($booking->transaction)
                                <a href="{{ route('manager.transactions.show', $booking->transaction) }}" class="w-full inline-flex justify-center items-center px-4 py-2 bg-[#2c3e38] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-[#1f2d28] transition ease-in-out duration-150 shadow-sm">
                                    View Linked Transaction
                                </a>
                            @else
                                <button type="button" x-data="" x-on:click="$dispatch('open-modal-confirm-create-tx-{{ $booking->id }}')" class="w-full inline-flex justify-center items-center px-4 py-2 bg-spa-white border border-[#2c3e38] rounded-md font-semibold text-xs text-[#2c3e38] uppercase tracking-widest hover:bg-spa-beige transition ease-in-out duration-150 shadow-sm">
                                    Create Transaction
                                </button>
                                
                                <x-ui.confirm-modal 
                                    id="confirm-create-tx-{{ $booking->id }}"
                                    name="confirm-create-tx-{{ $booking->id }}"
                                    title="Create Transaction"
                                    message="Are you sure you want to generate a transaction record for this booking? This will prepare it for payment collection."
                                    action="{{ route('manager.transactions.createFromBooking', $booking) }}"
                                    method="POST"
                                    confirmText="Create Transaction"
                                    type="info"
                                />
                            @endif
                        </div>
                    </dl>
                </div>
            </div>

            <div class="bg-spa-white rounded-xl shadow-sm border border-spa-beige overflow-hidden">
                <div class="px-6 py-5 border-b border-spa-beige bg-gray-50/50">
                    <h3 class="text-lg font-medium leading-6 text-spa-charcoal">System Logs</h3>
                </div>
                <div class="p-6">
                    <dl class="space-y-4">
                        <div>
                            <dt class="text-xs font-medium text-spa-gray opacity-80">Created By</dt>
                            <dd class="mt-1 text-sm text-spa-charcoal">{{ $booking->creator ? $booking->creator->name : 'System/Guest' }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium text-spa-gray opacity-80">Email Notification</dt>
                            <dd class="mt-1 text-sm text-spa-charcoal">
                                @if($booking->notification_status === 'email_sent')
                                    <span class="text-green-600">Sent Successfully</span>
                                @elseif($booking->notification_status === 'email_failed')
                                    <span class="text-red-600">Failed to Send</span>
                                @else
                                    <span class="text-spa-gray opacity-80">Pending / None</span>
                                @endif
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</x-manager-layout>
