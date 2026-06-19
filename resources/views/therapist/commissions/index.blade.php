<x-therapist-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-spa-charcoal leading-tight">
            {{ __('My Commissions') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-6">
                <p class="text-sm text-spa-gray opacity-80">Track your earnings and commission history from completed wellness sessions.</p>
            </div>

            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-spa-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-yellow-400">
                    <div class="text-spa-gray opacity-80 text-xs font-medium uppercase tracking-wider">Unpaid Earnings</div>
                    <div class="mt-2 text-2xl font-bold text-spa-charcoal">₱{{ number_format($totalUnpaid, 2) }}</div>
                    <div class="mt-1 text-xs text-spa-gray opacity-60">Pending disbursement</div>
                </div>
                
                <div class="bg-spa-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-green-500">
                    <div class="text-spa-gray opacity-80 text-xs font-medium uppercase tracking-wider">Total Paid</div>
                    <div class="mt-2 text-2xl font-bold text-spa-charcoal">₱{{ number_format($totalPaid, 2) }}</div>
                    <div class="mt-1 text-xs text-spa-gray opacity-60">Successfully settled</div>
                </div>
                
                <div class="bg-spa-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-blue-500">
                    <div class="text-spa-gray opacity-80 text-xs font-medium uppercase tracking-wider">This Month</div>
                    <div class="mt-2 text-2xl font-bold text-spa-charcoal">₱{{ number_format($thisMonthEarned, 2) }}</div>
                    <div class="mt-1 text-xs text-spa-gray opacity-60">Earned in {{ now()->format('F') }}</div>
                </div>

                <div class="bg-spa-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-[#2c3e38]">
                    <div class="text-spa-gray opacity-80 text-xs font-medium uppercase tracking-wider">Total Sessions</div>
                    <div class="mt-2 text-2xl font-bold text-spa-charcoal">{{ $totalRecords }}</div>
                    <div class="mt-1 text-xs text-spa-gray opacity-60">Commissionable records</div>
                </div>
            </div>

            <!-- Filters -->
            <div class="bg-spa-white p-4 rounded-xl shadow-sm border border-spa-beige mb-6">
                <form action="{{ route('therapist.commissions.index') }}" method="GET" class="flex flex-col md:flex-row gap-4 items-end">
                    <div class="w-full md:w-1/4">
                        <label for="status" class="block text-xs font-medium text-spa-charcoal opacity-90 mb-1">Status</label>
                        <select name="status" id="status" class="w-full rounded-md border-spa-wood shadow-sm focus:border-[#2c3e38] focus:ring focus:ring-[#2c3e38] focus:ring-opacity-50 text-sm">
                            <option value="">All Statuses</option>
                            <option value="unpaid" {{ request('status') === 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                            <option value="paid" {{ request('status') === 'paid' ? 'selected' : '' }}>Paid</option>
                        </select>
                    </div>

                    <div class="w-full md:w-1/4">
                        <label for="date_from" class="block text-xs font-medium text-spa-charcoal opacity-90 mb-1">Date From</label>
                        <input type="date" name="date_from" id="date_from" value="{{ request('date_from') }}" class="w-full rounded-md border-spa-wood shadow-sm focus:border-[#2c3e38] focus:ring focus:ring-[#2c3e38] focus:ring-opacity-50 text-sm">
                    </div>

                    <div class="w-full md:w-1/4">
                        <label for="date_to" class="block text-xs font-medium text-spa-charcoal opacity-90 mb-1">Date To</label>
                        <input type="date" name="date_to" id="date_to" value="{{ request('date_to') }}" class="w-full rounded-md border-spa-wood shadow-sm focus:border-[#2c3e38] focus:ring focus:ring-[#2c3e38] focus:ring-opacity-50 text-sm">
                    </div>
                    
                    <div class="flex gap-2 w-full md:w-auto">
                        <button type="submit" class="px-4 py-2 bg-spa-beige text-spa-charcoal opacity-90 rounded-md hover:bg-gray-200 text-sm font-medium transition-colors border border-spa-beige">
                            Filter
                        </button>
                        @if(request()->anyFilled(['status', 'date_from', 'date_to']))
                            <a href="{{ route('therapist.commissions.index') }}" class="px-4 py-2 bg-spa-white text-spa-gray opacity-80 rounded-md hover:text-gray-700 text-sm font-medium transition-colors border border-spa-beige">
                                Clear
                            </a>
                        @endif
                        <a href="{{ route('therapist.commissions.report', request()->all()) }}" target="_blank" class="px-4 py-2 bg-[#2c3e38] text-white rounded-md hover:bg-[#1f2d28] text-sm font-medium transition-colors shadow-sm">
                            Generate Report PDF
                        </a>
                    </div>
                </form>
            </div>

            <!-- Commissions Table -->
            <div class="bg-spa-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-spa-cream">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-spa-gray opacity-80 uppercase tracking-wider">Ref & Date</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-spa-gray opacity-80 uppercase tracking-wider">Service Details</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-spa-gray opacity-80 uppercase tracking-wider">Gross</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-[#2c3e38] uppercase tracking-wider">Commission</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-spa-gray opacity-80 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-spa-gray opacity-80 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-spa-white divide-y divide-gray-200">
                            @forelse($commissions as $commission)
                                <tr class="hover:bg-spa-beige transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-spa-charcoal">{{ $commission->commission_reference }}</div>
                                        <div class="text-xs text-spa-gray opacity-80">{{ $commission->earned_at ? $commission->earned_at->format('M d, Y') : '-' }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-spa-charcoal">{{ $commission->service->name }}</div>
                                        <div class="text-xs text-spa-gray opacity-80">TX: {{ $commission->transaction->transaction_reference ?? 'N/A' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-spa-gray opacity-80">
                                        ₱{{ number_format($commission->gross_amount, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-[#2c3e38]">
                                        ₱{{ number_format($commission->commission_amount, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <x-ui.status-badge :status="$commission->status" />
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('therapist.commissions.show', $commission) }}" class="text-[#2c3e38] hover:text-[#1f2d28]">Details</a>
                                    </td>
                                </tr>
                            @empty
                                <x-ui.empty-state 
                                    colspan="6"
                                    icon="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                                    title="No commissions found"
                                    description="No commissions found matching your criteria."
                                />
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                @if($commissions->hasPages())
                    <div class="px-6 py-4 border-t border-spa-beige">
                        {{ $commissions->links() }}
                    </div>
                @endif
            </div>
            
        </div>
    </div>
</x-therapist-layout>

