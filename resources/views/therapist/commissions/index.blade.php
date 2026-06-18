<x-therapist-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Commissions') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-6">
                <p class="text-sm text-gray-500">Track your earnings and commission history from completed wellness sessions.</p>
            </div>

            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-yellow-400">
                    <div class="text-gray-500 text-xs font-medium uppercase tracking-wider">Unpaid Earnings</div>
                    <div class="mt-2 text-2xl font-bold text-gray-900">₱{{ number_format($totalUnpaid, 2) }}</div>
                    <div class="mt-1 text-xs text-gray-400">Pending disbursement</div>
                </div>
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-green-500">
                    <div class="text-gray-500 text-xs font-medium uppercase tracking-wider">Total Paid</div>
                    <div class="mt-2 text-2xl font-bold text-gray-900">₱{{ number_format($totalPaid, 2) }}</div>
                    <div class="mt-1 text-xs text-gray-400">Successfully settled</div>
                </div>
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-blue-500">
                    <div class="text-gray-500 text-xs font-medium uppercase tracking-wider">This Month</div>
                    <div class="mt-2 text-2xl font-bold text-gray-900">₱{{ number_format($thisMonthEarned, 2) }}</div>
                    <div class="mt-1 text-xs text-gray-400">Earned in {{ now()->format('F') }}</div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-[#2c3e38]">
                    <div class="text-gray-500 text-xs font-medium uppercase tracking-wider">Total Sessions</div>
                    <div class="mt-2 text-2xl font-bold text-gray-900">{{ $totalRecords }}</div>
                    <div class="mt-1 text-xs text-gray-400">Commissionable records</div>
                </div>
            </div>

            <!-- Filters -->
            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 mb-6">
                <form action="{{ route('therapist.commissions.index') }}" method="GET" class="flex flex-col md:flex-row gap-4 items-end">
                    <div class="w-full md:w-1/4">
                        <label for="status" class="block text-xs font-medium text-gray-700 mb-1">Status</label>
                        <select name="status" id="status" class="w-full rounded-md border-gray-300 shadow-sm focus:border-[#2c3e38] focus:ring focus:ring-[#2c3e38] focus:ring-opacity-50 text-sm">
                            <option value="">All Statuses</option>
                            <option value="unpaid" {{ request('status') === 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                            <option value="paid" {{ request('status') === 'paid' ? 'selected' : '' }}>Paid</option>
                        </select>
                    </div>

                    <div class="w-full md:w-1/4">
                        <label for="date_from" class="block text-xs font-medium text-gray-700 mb-1">Date From</label>
                        <input type="date" name="date_from" id="date_from" value="{{ request('date_from') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-[#2c3e38] focus:ring focus:ring-[#2c3e38] focus:ring-opacity-50 text-sm">
                    </div>

                    <div class="w-full md:w-1/4">
                        <label for="date_to" class="block text-xs font-medium text-gray-700 mb-1">Date To</label>
                        <input type="date" name="date_to" id="date_to" value="{{ request('date_to') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-[#2c3e38] focus:ring focus:ring-[#2c3e38] focus:ring-opacity-50 text-sm">
                    </div>
                    
                    <div class="flex gap-2 w-full md:w-auto">
                        <button type="submit" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 text-sm font-medium transition-colors border border-gray-200">
                            Filter
                        </button>
                        @if(request()->anyFilled(['status', 'date_from', 'date_to']))
                            <a href="{{ route('therapist.commissions.index') }}" class="px-4 py-2 bg-white text-gray-500 rounded-md hover:text-gray-700 text-sm font-medium transition-colors border border-gray-200">
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
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ref & Date</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Service Details</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gross</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-[#2c3e38] uppercase tracking-wider">Commission</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($commissions as $commission)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $commission->commission_reference }}</div>
                                        <div class="text-xs text-gray-500">{{ $commission->earned_at ? $commission->earned_at->format('M d, Y') : '-' }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">{{ $commission->service->name }}</div>
                                        <div class="text-xs text-gray-500">TX: {{ $commission->transaction->transaction_reference ?? 'N/A' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        ₱{{ number_format($commission->gross_amount, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-[#2c3e38]">
                                        ₱{{ number_format($commission->commission_amount, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($commission->status === 'unpaid')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Unpaid</span>
                                        @elseif($commission->status === 'paid')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Paid</span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">Voided</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('therapist.commissions.show', $commission) }}" class="text-[#2c3e38] hover:text-[#1f2d28]">Details</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-10 whitespace-nowrap text-sm text-gray-500 text-center">
                                        No commissions found matching your criteria.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                @if($commissions->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $commissions->links() }}
                    </div>
                @endif
            </div>
            
        </div>
    </div>
</x-therapist-layout>

