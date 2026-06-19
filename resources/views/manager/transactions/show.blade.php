<x-manager-layout>
    <x-slot name="header">
        Transaction Details
    </x-slot>

    <div class="mb-6 flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-spa-charcoal">Transaction: {{ $transaction->transaction_reference }}</h2>
            <p class="text-sm text-spa-gray opacity-80 mt-1">Created on {{ $transaction->created_at->format('M d, Y g:i A') }}</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('manager.transactions.receipt', $transaction) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-[#2c3e38] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-[#1f2d28] transition ease-in-out duration-150 shadow-sm">
                View PDF Receipt
            </a>
            <a href="{{ route('manager.transactions.index') }}" class="inline-flex items-center px-4 py-2 bg-spa-white border border-spa-wood rounded-md font-semibold text-xs text-spa-charcoal opacity-90 uppercase tracking-widest hover:bg-spa-beige transition ease-in-out duration-150 shadow-sm">
                Back to List
            </a>
        </div>
    </div>


    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Main Details -->
        <div class="md:col-span-2 space-y-6">
            <div class="bg-spa-white rounded-xl shadow-sm border border-spa-beige overflow-hidden">
                <div class="px-6 py-5 border-b border-spa-beige bg-gray-50/50 flex justify-between items-center">
                    <h3 class="text-lg font-medium leading-6 text-spa-charcoal">Payment Summary</h3>
                    <div>
                        <x-ui.status-badge :status="$transaction->payment_status" />
                    </div>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <div class="flex justify-between pb-4 border-b border-spa-beige">
                            <span class="text-spa-gray">Subtotal</span>
                            <span class="font-medium">₱{{ number_format($transaction->subtotal, 2) }}</span>
                        </div>
                        <div class="flex justify-between pb-4 border-b border-spa-beige text-red-600">
                            <span>Discount</span>
                            <span>- ₱{{ number_format($transaction->discount_amount, 2) }}</span>
                        </div>
                        <div class="flex justify-between pb-4 border-b border-spa-beige text-lg font-bold text-spa-charcoal">
                            <span>Total Amount</span>
                            <span>₱{{ number_format($transaction->total_amount, 2) }}</span>
                        </div>
                        <div class="flex justify-between pt-2">
                            <span class="text-spa-gray">Amount Paid ({{ ucfirst($transaction->payment_method) }})</span>
                            <span class="font-bold text-[#2c3e38]">₱{{ number_format($transaction->amount_paid, 2) }}</span>
                        </div>
                        <div class="flex justify-between pt-2 text-sm text-spa-gray opacity-80">
                            <span>Change</span>
                            <span>₱{{ number_format($transaction->change_amount, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Update Status -->
            <div class="bg-spa-white rounded-xl shadow-sm border border-spa-beige overflow-hidden">
                <div class="px-6 py-5 border-b border-spa-beige bg-gray-50/50 flex justify-between items-center">
                    <h3 class="text-lg font-medium leading-6 text-spa-charcoal">Payment Status</h3>
                    <button type="button" x-data="" x-on:click="$dispatch('open-modal', 'update-status-{{ $transaction->id }}')" class="inline-flex items-center px-3 py-1.5 bg-[#2c3e38] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-[#1f2d28] transition ease-in-out duration-150 shadow-sm">
                        Update Status
                    </button>
                </div>
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-spa-gray opacity-80">Current Status:</span>
                        <x-ui.status-badge :status="$transaction->payment_status" />
                    </div>
                </div>

                <x-modal name="update-status-{{ $transaction->id }}" :show="$errors->any() && old('_modal_id') === 'update-status-'.$transaction->id" maxWidth="sm">
                    <x-ui.modal-form 
                        title="Update Status" 
                        subtitle="Transaction: {{ $transaction->transaction_reference }}" 
                        action="{{ route('manager.transactions.updateStatus', $transaction) }}" 
                        method="PATCH"
                    >
                        <input type="hidden" name="_modal_id" value="update-status-{{ $transaction->id }}">
                        <div>
                            <x-input-label for="payment_status_{{ $transaction->id }}" value="Payment Status" />
                            <select id="payment_status_{{ $transaction->id }}" name="payment_status" class="mt-1 block w-full border-spa-wood focus:border-[#2c3e38] focus:ring-[#2c3e38] rounded-md shadow-sm">
                                <option value="paid" {{ $transaction->payment_status === 'paid' ? 'selected' : '' }}>Paid</option>
                                <option value="unpaid" {{ $transaction->payment_status === 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                                <option value="refunded" {{ $transaction->payment_status === 'refunded' ? 'selected' : '' }}>Refunded</option>
                                <option value="cancelled" {{ $transaction->payment_status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>
                        <x-slot name="actions">
                            <x-ui.submit-button label="Update Status" />
                        </x-slot>
                    </x-ui.modal-form>
                </x-modal>
            </div>
        </div>

        <!-- Sidebar Details -->
        <div class="space-y-6">
            <div class="bg-spa-white rounded-xl shadow-sm border border-spa-beige overflow-hidden">
                <div class="px-6 py-5 border-b border-spa-beige bg-gray-50/50">
                    <h3 class="text-lg font-medium leading-6 text-spa-charcoal">Booking Information</h3>
                </div>
                <div class="p-6">
                    <dl class="space-y-4">
                        @if($transaction->booking)
                            <div>
                                <dt class="text-xs font-medium text-spa-gray opacity-80 uppercase">Booking Reference</dt>
                                <dd class="mt-1 text-sm font-medium text-[#2c3e38]">
                                    <a href="{{ route('manager.bookings.show', $transaction->booking) }}" class="hover:underline">{{ $transaction->booking->booking_reference }}</a>
                                </dd>
                            </div>
                            <div>
                                <dt class="text-xs font-medium text-spa-gray opacity-80 uppercase">Appointment Date</dt>
                                <dd class="mt-1 text-sm text-spa-charcoal">{{ $transaction->booking->appointment_date->format('M d, Y') }} at {{ \Carbon\Carbon::parse($transaction->booking->start_time)->format('g:i A') }}</dd>
                            </div>
                        @else
                            <div class="text-sm text-spa-gray opacity-80 italic">No linked booking.</div>
                        @endif
                    </dl>
                </div>
            </div>

            <div class="bg-spa-white rounded-xl shadow-sm border border-spa-beige overflow-hidden">
                <div class="px-6 py-5 border-b border-spa-beige bg-gray-50/50">
                    <h3 class="text-lg font-medium leading-6 text-spa-charcoal">Service & Personnel</h3>
                </div>
                <div class="p-6">
                    <dl class="space-y-4">
                        <div>
                            <dt class="text-xs font-medium text-spa-gray opacity-80 uppercase">Customer</dt>
                            <dd class="mt-1 text-sm text-spa-charcoal">{{ $transaction->customer ? $transaction->customer->name : ($transaction->booking ? $transaction->booking->customer_name : 'Walk-in Guest') }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium text-spa-gray opacity-80 uppercase">Service</dt>
                            <dd class="mt-1 text-sm text-spa-charcoal">{{ $transaction->service->name }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium text-spa-gray opacity-80 uppercase">Therapist</dt>
                            <dd class="mt-1 text-sm text-spa-charcoal">{{ $transaction->therapist->user->name }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
            
            @if($transaction->notes)
            <div class="bg-spa-white rounded-xl shadow-sm border border-spa-beige overflow-hidden">
                <div class="px-6 py-5 border-b border-spa-beige bg-gray-50/50">
                    <h3 class="text-lg font-medium leading-6 text-spa-charcoal">Notes</h3>
                </div>
                <div class="p-6">
                    <p class="text-sm text-spa-charcoal opacity-90 whitespace-pre-line">{{ $transaction->notes }}</p>
                </div>
            </div>
            @endif
        </div>
    </div>
</x-manager-layout>
