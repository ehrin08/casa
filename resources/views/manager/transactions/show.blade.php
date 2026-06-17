<x-manager-layout>
    <x-slot name="header">
        Transaction Details
    </x-slot>

    <div class="mb-6 flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Transaction: {{ $transaction->transaction_reference }}</h2>
            <p class="text-sm text-gray-500 mt-1">Created on {{ $transaction->created_at->format('M d, Y g:i A') }}</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('manager.transactions.receipt', $transaction) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-[#2c3e38] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-[#1f2d28] transition ease-in-out duration-150 shadow-sm">
                View PDF Receipt
            </a>
            <a href="{{ route('manager.transactions.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-50 transition ease-in-out duration-150 shadow-sm">
                Back to List
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Main Details -->
        <div class="md:col-span-2 space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Payment Summary</h3>
                    <div>
                        @if($transaction->payment_status === 'paid')
                            <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-green-100 text-green-800">Paid</span>
                        @elseif($transaction->payment_status === 'refunded')
                            <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">Refunded</span>
                        @elseif($transaction->payment_status === 'cancelled')
                            <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-red-100 text-red-800">Cancelled</span>
                        @else
                            <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Unpaid</span>
                        @endif
                    </div>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <div class="flex justify-between pb-4 border-b border-gray-100">
                            <span class="text-gray-600">Subtotal</span>
                            <span class="font-medium">₱{{ number_format($transaction->subtotal, 2) }}</span>
                        </div>
                        <div class="flex justify-between pb-4 border-b border-gray-100 text-red-600">
                            <span>Discount</span>
                            <span>- ₱{{ number_format($transaction->discount_amount, 2) }}</span>
                        </div>
                        <div class="flex justify-between pb-4 border-b border-gray-100 text-lg font-bold text-gray-900">
                            <span>Total Amount</span>
                            <span>₱{{ number_format($transaction->total_amount, 2) }}</span>
                        </div>
                        <div class="flex justify-between pt-2">
                            <span class="text-gray-600">Amount Paid ({{ ucfirst($transaction->payment_method) }})</span>
                            <span class="font-bold text-[#2c3e38]">₱{{ number_format($transaction->amount_paid, 2) }}</span>
                        </div>
                        <div class="flex justify-between pt-2 text-sm text-gray-500">
                            <span>Change</span>
                            <span>₱{{ number_format($transaction->change_amount, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Update Status -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Update Status</h3>
                </div>
                <div class="p-6">
                    <form action="{{ route('manager.transactions.updateStatus', $transaction) }}" method="POST" class="flex items-end gap-4">
                        @csrf
                        @method('PATCH')
                        <div class="flex-1">
                            <x-input-label for="payment_status" value="Payment Status" />
                            <select id="payment_status" name="payment_status" class="mt-1 block w-full border-gray-300 focus:border-[#2c3e38] focus:ring-[#2c3e38] rounded-md shadow-sm">
                                <option value="paid" {{ $transaction->payment_status === 'paid' ? 'selected' : '' }}>Paid</option>
                                <option value="unpaid" {{ $transaction->payment_status === 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                                <option value="refunded" {{ $transaction->payment_status === 'refunded' ? 'selected' : '' }}>Refunded</option>
                                <option value="cancelled" {{ $transaction->payment_status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>
                        <button type="submit" class="px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-50 transition ease-in-out duration-150 shadow-sm h-[42px]">
                            Update
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar Details -->
        <div class="space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Booking Information</h3>
                </div>
                <div class="p-6">
                    <dl class="space-y-4">
                        @if($transaction->booking)
                            <div>
                                <dt class="text-xs font-medium text-gray-500 uppercase">Booking Reference</dt>
                                <dd class="mt-1 text-sm font-medium text-[#2c3e38]">
                                    <a href="{{ route('manager.bookings.show', $transaction->booking) }}" class="hover:underline">{{ $transaction->booking->booking_reference }}</a>
                                </dd>
                            </div>
                            <div>
                                <dt class="text-xs font-medium text-gray-500 uppercase">Appointment Date</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $transaction->booking->appointment_date->format('M d, Y') }} at {{ \Carbon\Carbon::parse($transaction->booking->start_time)->format('g:i A') }}</dd>
                            </div>
                        @else
                            <div class="text-sm text-gray-500 italic">No linked booking.</div>
                        @endif
                    </dl>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Service & Personnel</h3>
                </div>
                <div class="p-6">
                    <dl class="space-y-4">
                        <div>
                            <dt class="text-xs font-medium text-gray-500 uppercase">Customer</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $transaction->customer ? $transaction->customer->name : ($transaction->booking ? $transaction->booking->customer_name : 'Walk-in Guest') }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium text-gray-500 uppercase">Service</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $transaction->service->name }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium text-gray-500 uppercase">Therapist</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $transaction->therapist->user->name }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
            
            @if($transaction->notes)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Notes</h3>
                </div>
                <div class="p-6">
                    <p class="text-sm text-gray-700 whitespace-pre-line">{{ $transaction->notes }}</p>
                </div>
            </div>
            @endif
        </div>
    </div>
</x-manager-layout>
