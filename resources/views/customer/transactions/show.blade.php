<x-customer-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-spa-charcoal leading-tight">
            {{ __('Receipt Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-6 flex justify-between items-center px-4 sm:px-0">
                <a href="{{ route('customer.transactions.index') }}" class="text-[#2c3e38] hover:underline flex items-center text-sm font-medium">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back to History
                </a>
                <a href="{{ route('customer.transactions.receipt', $transaction) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-[#2c3e38] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-[#1f2d28] transition ease-in-out duration-150 shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    Download PDF
                </a>
            </div>

            <div class="bg-spa-white overflow-hidden shadow-sm sm:rounded-lg">
                <!-- Receipt Header -->
                <div class="border-b border-spa-beige p-8 text-center bg-[#f9f8f6]">
                    <h1 class="text-2xl font-bold text-[#2c3e38] uppercase tracking-wider mb-1">Casa Paraiso</h1>
                    <p class="text-sm text-spa-gray opacity-80 uppercase tracking-widest mb-6">Body and Wellness Spa</p>
                    
                    <div class="inline-block bg-spa-white px-6 py-3 rounded-lg shadow-sm border border-spa-beige">
                        <p class="text-xs text-spa-gray opacity-80 uppercase font-medium mb-1">Receipt Number</p>
                        <p class="text-lg font-bold text-spa-charcoal">{{ $transaction->transaction_reference }}</p>
                    </div>
                </div>

                <!-- Receipt Body -->
                <div class="p-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                        <div>
                            <p class="text-xs text-spa-gray opacity-80 uppercase font-medium mb-1">Date & Time</p>
                            <p class="text-sm text-spa-charcoal font-medium">{{ $transaction->created_at->format('F d, Y h:i A') }}</p>
                            
                            @if($transaction->booking)
                                <p class="text-xs text-spa-gray opacity-80 uppercase font-medium mt-4 mb-1">Booking Reference</p>
                                <p class="text-sm text-spa-charcoal font-medium">{{ $transaction->booking->booking_reference }}</p>
                            @endif
                        </div>
                        <div class="md:text-right">
                            <p class="text-xs text-spa-gray opacity-80 uppercase font-medium mb-1">Payment Status</p>
                            <p class="text-sm font-medium">
                                @if($transaction->payment_status === 'paid')
                                    <span class="text-green-600">Paid</span>
                                @elseif($transaction->payment_status === 'refunded')
                                    <span class="text-purple-600">Refunded</span>
                                @elseif($transaction->payment_status === 'cancelled')
                                    <span class="text-red-600">Cancelled</span>
                                @else
                                    <span class="text-yellow-600">Unpaid</span>
                                @endif
                            </p>

                            <p class="text-xs text-spa-gray opacity-80 uppercase font-medium mt-4 mb-1">Payment Method</p>
                            <p class="text-sm text-spa-charcoal font-medium">{{ ucfirst($transaction->payment_method) }}</p>
                        </div>
                    </div>

                    <div class="border-t border-b border-spa-beige py-4 mb-6">
                        <table class="min-w-full">
                            <thead>
                                <tr>
                                    <th class="text-left text-xs font-medium text-spa-gray opacity-80 uppercase pb-2">Description</th>
                                    <th class="text-right text-xs font-medium text-spa-gray opacity-80 uppercase pb-2">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="py-3">
                                        <div class="text-sm font-medium text-spa-charcoal">{{ $transaction->service->name }}</div>
                                        <div class="text-xs text-spa-gray opacity-80">{{ $transaction->service->duration_minutes }} min session with {{ $transaction->therapist->user->name }}</div>
                                    </td>
                                    <td class="py-3 text-right text-sm font-medium text-spa-charcoal">
                                        ₱{{ number_format($transaction->service->price, 2) }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="flex justify-end">
                        <div class="w-full md:w-1/2 space-y-3">
                            <div class="flex justify-between text-sm">
                                <span class="text-spa-gray">Subtotal</span>
                                <span class="font-medium text-spa-charcoal">₱{{ number_format($transaction->subtotal, 2) }}</span>
                            </div>
                            @if($transaction->discount_amount > 0)
                                <div class="flex justify-between text-sm text-red-600">
                                    <span>Discount</span>
                                    <span>- ₱{{ number_format($transaction->discount_amount, 2) }}</span>
                                </div>
                            @endif
                            <div class="flex justify-between text-base font-bold pt-3 border-t border-spa-beige">
                                <span class="text-spa-charcoal">Total Amount</span>
                                <span class="text-[#2c3e38]">₱{{ number_format($transaction->total_amount, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-sm pt-2">
                                <span class="text-spa-gray">Amount Paid</span>
                                <span class="font-medium text-spa-charcoal">₱{{ number_format($transaction->amount_paid, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-spa-gray opacity-80">Change</span>
                                <span class="text-spa-gray opacity-80">₱{{ number_format($transaction->change_amount, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</x-customer-layout>

