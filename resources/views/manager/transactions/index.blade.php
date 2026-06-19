<x-manager-layout>
    <x-slot name="header">
        Transactions
    </x-slot>

    <div class="mb-6">
        <h2 class="text-2xl font-bold text-spa-charcoal">Transactions</h2>
        <p class="text-sm text-spa-gray opacity-80 mt-1">Track cash payments, receipts, and completed booking payment records.</p>
    </div>

    <!-- Filters & Search -->
    <div class="bg-spa-white p-4 rounded-xl shadow-sm border border-spa-beige mb-6">
        <form method="GET" action="{{ route('manager.transactions.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="md:col-span-2">
                <x-text-input name="search" value="{{ request('search') }}" placeholder="Search by reference, customer name, email, or phone..." class="w-full text-sm" />
            </div>
            
            <div>
                <select name="payment_status" class="w-full border-spa-wood focus:border-[#2c3e38] focus:ring-[#2c3e38] rounded-md shadow-sm text-sm">
                    <option value="">All Statuses</option>
                    <option value="paid" {{ request('payment_status') === 'paid' ? 'selected' : '' }}>Paid</option>
                    <option value="unpaid" {{ request('payment_status') === 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                    <option value="refunded" {{ request('payment_status') === 'refunded' ? 'selected' : '' }}>Refunded</option>
                    <option value="cancelled" {{ request('payment_status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>

            <div>
                <select name="service_id" class="w-full border-spa-wood focus:border-[#2c3e38] focus:ring-[#2c3e38] rounded-md shadow-sm text-sm">
                    <option value="">All Services</option>
                    @foreach($services as $service)
                        <option value="{{ $service->id }}" {{ request('service_id') == $service->id ? 'selected' : '' }}>{{ $service->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="md:col-span-4 flex justify-end gap-2">
                <a href="{{ route('manager.transactions.index') }}" class="inline-flex items-center px-4 py-2 bg-spa-white border border-spa-wood rounded-md font-semibold text-xs text-spa-charcoal opacity-90 uppercase tracking-widest shadow-sm hover:bg-spa-beige transition ease-in-out duration-150">
                    Clear
                </a>
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-[#2c3e38] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-[#1f2d28] transition ease-in-out duration-150 shadow-sm">
                    Filter
                </button>
            </div>
        </form>
    </div>



    <!-- Transactions Table -->
    <div class="bg-spa-white rounded-xl shadow-sm border border-spa-beige overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50/50">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-spa-gray opacity-80 uppercase tracking-wider">Transaction Ref</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-spa-gray opacity-80 uppercase tracking-wider">Date</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-spa-gray opacity-80 uppercase tracking-wider">Customer / Service</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-spa-gray opacity-80 uppercase tracking-wider">Amount / Status</th>
                        <th scope="col" class="px-6 py-4 text-right text-xs font-semibold text-spa-gray opacity-80 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-spa-white divide-y divide-gray-200">
                    @forelse ($transactions as $transaction)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-spa-charcoal">{{ $transaction->transaction_reference }}</div>
                                @if($transaction->booking)
                                    <div class="text-xs text-spa-gray opacity-80 mt-1" title="Booking Ref">
                                        <a href="{{ route('manager.bookings.show', $transaction->booking) }}" class="text-[#2c3e38] hover:underline">{{ $transaction->booking->booking_reference }}</a>
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-spa-gray opacity-80">
                                {{ $transaction->created_at->format('M d, Y') }}<br>
                                <span class="text-xs">{{ $transaction->created_at->format('g:i A') }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-spa-charcoal">{{ $transaction->customer ? $transaction->customer->name : ($transaction->booking ? $transaction->booking->customer_name : 'Walk-in') }}</div>
                                <div class="text-xs text-spa-gray opacity-80 mt-1">{{ $transaction->service->name }} (by {{ $transaction->therapist->user->name }})</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-bold text-spa-charcoal mb-1">₱{{ number_format($transaction->amount_paid, 2) }}</div>
                                <x-ui.status-badge :status="$transaction->payment_status" />
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('manager.transactions.show', $transaction) }}" class="text-[#2c3e38] hover:text-[#1f2d28] mr-3">View</a>
                                <a href="{{ route('manager.transactions.receipt', $transaction) }}" target="_blank" class="text-spa-gray opacity-80 hover:text-spa-charcoal">Receipt</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 whitespace-nowrap">
                                <x-ui.empty-state 
                                    icon="clipboard-document-list" 
                                    title="No transactions found" 
                                    description="No transaction records match your criteria." 
                                />
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($transactions->hasPages())
            <div class="px-6 py-4 border-t border-spa-beige bg-gray-50/50">
                {{ $transactions->links() }}
            </div>
        @endif
    </div>
</x-manager-layout>
