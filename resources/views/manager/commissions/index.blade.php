<x-manager-layout>
    <x-slot name="header">
        Therapist Commissions
    </x-slot>

    <div class="mb-6">
        <p class="text-sm text-spa-gray opacity-80">Track earned, paid, and voided therapist commissions from paid transactions.</p>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <x-dashboard.stat-card 
            title="Total Unpaid" 
            value="₱{{ number_format($totalUnpaid, 2) }}" 
            icon="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" 
            color="text-yellow-600" 
            bg="bg-yellow-100" />
            
        <x-dashboard.stat-card 
            title="Total Paid" 
            value="₱{{ number_format($totalPaid, 2) }}" 
            icon="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" 
            color="text-green-600" 
            bg="bg-green-100" />
            
        <x-dashboard.stat-card 
            title="This Month Earned" 
            value="₱{{ number_format($thisMonthEarned, 2) }}" 
            icon="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" 
            color="text-blue-600" 
            bg="bg-blue-100" />

        <x-dashboard.stat-card 
            title="Total Voided" 
            value="₱{{ number_format($totalVoided, 2) }}" 
            icon="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" 
            color="text-red-600" 
            bg="bg-red-100" />
    </div>

    <!-- Filters and Search -->
    <div class="bg-spa-white p-4 rounded-xl shadow-sm border border-spa-beige mb-6">
        <form action="{{ route('manager.commissions.index') }}" method="GET" class="flex flex-col md:flex-row gap-4 items-end">
            <div class="w-full md:w-1/4">
                <label for="search" class="block text-xs font-medium text-spa-charcoal opacity-90 mb-1">Search</label>
                <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Ref, therapist, customer..." class="w-full rounded-md border-spa-wood shadow-sm focus:border-[#2c3e38] focus:ring focus:ring-[#2c3e38] focus:ring-opacity-50 text-sm">
            </div>
            
            <div class="w-full md:w-1/6">
                <label for="status" class="block text-xs font-medium text-spa-charcoal opacity-90 mb-1">Status</label>
                <select name="status" id="status" class="w-full rounded-md border-spa-wood shadow-sm focus:border-[#2c3e38] focus:ring focus:ring-[#2c3e38] focus:ring-opacity-50 text-sm">
                    <option value="">All Statuses</option>
                    <option value="unpaid" {{ request('status') === 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                    <option value="paid" {{ request('status') === 'paid' ? 'selected' : '' }}>Paid</option>
                    <option value="voided" {{ request('status') === 'voided' ? 'selected' : '' }}>Voided</option>
                </select>
            </div>

            <div class="w-full md:w-1/6">
                <label for="therapist_id" class="block text-xs font-medium text-spa-charcoal opacity-90 mb-1">Therapist</label>
                <select name="therapist_id" id="therapist_id" class="w-full rounded-md border-spa-wood shadow-sm focus:border-[#2c3e38] focus:ring focus:ring-[#2c3e38] focus:ring-opacity-50 text-sm">
                    <option value="">All Therapists</option>
                    @foreach($therapists as $t)
                        <option value="{{ $t->id }}" {{ request('therapist_id') == $t->id ? 'selected' : '' }}>{{ $t->user->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="w-full md:w-1/6">
                <label for="date_from" class="block text-xs font-medium text-spa-charcoal opacity-90 mb-1">Date From</label>
                <input type="date" name="date_from" id="date_from" value="{{ request('date_from') }}" class="w-full rounded-md border-spa-wood shadow-sm focus:border-[#2c3e38] focus:ring focus:ring-[#2c3e38] focus:ring-opacity-50 text-sm">
            </div>

            <div class="w-full md:w-1/6">
                <label for="date_to" class="block text-xs font-medium text-spa-charcoal opacity-90 mb-1">Date To</label>
                <input type="date" name="date_to" id="date_to" value="{{ request('date_to') }}" class="w-full rounded-md border-spa-wood shadow-sm focus:border-[#2c3e38] focus:ring focus:ring-[#2c3e38] focus:ring-opacity-50 text-sm">
            </div>
            
            <div class="flex gap-2 w-full md:w-auto">
                <button type="submit" class="px-4 py-2 bg-spa-beige text-spa-charcoal opacity-90 rounded-md hover:bg-gray-200 text-sm font-medium transition-colors border border-spa-beige">
                    Filter
                </button>
                @if(request()->anyFilled(['search', 'status', 'therapist_id', 'service_id', 'date_from', 'date_to']))
                    <a href="{{ route('manager.commissions.index') }}" class="px-4 py-2 bg-spa-white text-spa-gray opacity-80 rounded-md hover:text-gray-700 text-sm font-medium transition-colors border border-spa-beige">
                        Clear
                    </a>
                @endif
                <a href="{{ route('manager.commissions.report', request()->all()) }}" target="_blank" class="px-4 py-2 bg-[#2c3e38] text-white rounded-md hover:bg-[#1f2d28] text-sm font-medium transition-colors">
                    Report PDF
                </a>
            </div>
        </form>
    </div>

    <!-- Commissions Table -->
    <div class="bg-spa-white rounded-xl shadow-sm border border-spa-beige overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-spa-cream border-b border-spa-beige">
                        <th class="p-4 font-semibold text-sm text-spa-charcoal">Reference</th>
                        <th class="p-4 font-semibold text-sm text-spa-charcoal">Date Earned</th>
                        <th class="p-4 font-semibold text-sm text-spa-charcoal">Therapist</th>
                        <th class="p-4 font-semibold text-sm text-spa-charcoal">Gross</th>
                        <th class="p-4 font-semibold text-sm text-spa-charcoal">Comm ({{ config('app.commission_rate', '22') }}%)</th>
                        <th class="p-4 font-semibold text-sm text-spa-charcoal">Status</th>
                        <th class="p-4 font-semibold text-sm text-spa-charcoal text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($commissions as $commission)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="p-4">
                                <div class="font-medium text-sm text-spa-charcoal">{{ $commission->commission_reference }}</div>
                                <div class="text-xs text-spa-gray opacity-80">TX: {{ $commission->transaction->transaction_reference ?? 'N/A' }}</div>
                            </td>
                            <td class="p-4 text-sm text-spa-gray">
                                {{ $commission->earned_at ? $commission->earned_at->format('M d, Y') : 'N/A' }}
                            </td>
                            <td class="p-4 text-sm text-spa-gray">
                                {{ $commission->therapist->user->name }}
                                <div class="text-xs text-spa-gray opacity-80">{{ $commission->service->name }}</div>
                            </td>
                            <td class="p-4 text-sm text-spa-gray">
                                ₱{{ number_format($commission->gross_amount, 2) }}
                            </td>
                            <td class="p-4 text-sm font-bold text-[#2c3e38]">
                                ₱{{ number_format($commission->commission_amount, 2) }}
                            </td>
                            <td class="p-4">
                                <x-ui.status-badge :status="$commission->status" />
                            </td>
                            <td class="p-4 text-right space-x-3">
                                <a href="{{ route('manager.commissions.show', $commission) }}" class="text-sm font-medium text-[#7a6b5d] hover:text-[#5c4f43]">View</a>
                                
                                @if($commission->status === 'unpaid')
                                    <button type="button" x-data="" x-on:click="$dispatch('open-modal-confirm-pay-{{ $commission->id }}')" class="text-sm font-medium text-green-600 hover:text-green-800">Pay</button>
                                    
                                    <x-ui.confirm-modal 
                                        id="confirm-pay-{{ $commission->id }}"
                                        name="confirm-pay-{{ $commission->id }}"
                                        title="Pay Commission"
                                        message="Are you sure you want to mark this commission as paid?"
                                        action="{{ route('manager.commissions.markPaid', $commission) }}"
                                        method="PATCH"
                                        confirmText="Mark as Paid"
                                        type="info"
                                    />
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-8">
                                <x-ui.empty-state 
                                    icon="currency-dollar" 
                                    title="No commissions found" 
                                    description="No commission records match your criteria." 
                                />
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($commissions->hasPages())
            <div class="p-4 border-t border-spa-beige bg-spa-cream">
                {{ $commissions->links() }}
            </div>
        @endif
    </div>
</x-manager-layout>
