<x-manager-layout>
    <x-slot name="header">
        Promotion Engine
    </x-slot>

    <div class="mb-6 flex justify-between items-center">
        <p class="text-spa-gray opacity-80 text-sm">Manage RFM-driven discounts, targeted offers, and off-peak promotion rules.</p>
        <div class="flex gap-2">
            <a href="{{ route('manager.promotions.simulator') }}" class="px-4 py-2 bg-indigo-50 text-indigo-700 rounded-md font-medium text-sm hover:bg-indigo-100 transition-colors border border-indigo-200">
                Run Simulation
            </a>
            <a href="{{ route('manager.promotions.rules.create') }}" class="px-4 py-2 bg-[#2c3e38] text-white rounded-md font-medium text-sm hover:bg-[#1f2d28] transition-colors">
                + Create Rule
            </a>
            <button type="button" x-data="" x-on:click="$dispatch('open-modal', 'confirm-generate')" class="px-4 py-2 bg-blue-600 text-white rounded-md font-medium text-sm hover:bg-blue-700 transition-colors shadow-sm">
                Generate Promotions
            </button>
            <x-ui.confirm-modal 
                id="confirm-generate"
                name="confirm-generate"
                title="Generate Promotions"
                message="This will evaluate RFM for all customers and generate promotions based on active rules. Proceed?"
                action="{{ route('manager.promotions.generate') }}"
                method="POST"
                confirmText="Generate Promotions"
                type="info"
            />
        </div>
    </div>


    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <a href="{{ route('manager.promotions.rules') }}" class="bg-spa-white rounded-xl shadow-sm border border-spa-beige p-6 flex items-center hover:shadow-md transition-shadow group">
            <div class="p-3 rounded-full bg-blue-50 text-blue-600 mr-4 group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
            </div>
            <div>
                <p class="text-sm font-medium text-spa-gray opacity-80">Active Rules</p>
                <h3 class="text-2xl font-bold text-spa-charcoal">{{ $activeRulesCount }}</h3>
            </div>
        </a>

        <a href="{{ route('manager.promotions.customer-promotions') }}" class="bg-spa-white rounded-xl shadow-sm border border-spa-beige p-6 flex items-center hover:shadow-md transition-shadow group">
            <div class="p-3 rounded-full bg-indigo-50 text-spa-gold mr-4 group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <p class="text-sm font-medium text-spa-gray opacity-80">Generated Codes</p>
                <h3 class="text-2xl font-bold text-spa-charcoal">{{ $generatedCount }}</h3>
            </div>
        </a>

        <a href="{{ route('manager.promotions.customer-promotions', ['status' => 'used']) }}" class="bg-spa-white rounded-xl shadow-sm border border-spa-beige p-6 flex items-center hover:shadow-md transition-shadow group">
            <div class="p-3 rounded-full bg-green-50 text-green-600 mr-4 group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <p class="text-sm font-medium text-spa-gray opacity-80">Used Promotions</p>
                <h3 class="text-2xl font-bold text-spa-charcoal">{{ $usedCount }}</h3>
            </div>
        </a>

        <div class="bg-spa-white rounded-xl shadow-sm border border-spa-beige p-6 flex items-center">
            <div class="p-3 rounded-full bg-purple-50 text-purple-600 mr-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>
            <div>
                <p class="text-sm font-medium text-spa-gray opacity-80">RFM Profiles</p>
                <h3 class="text-2xl font-bold text-spa-charcoal">{{ $rfmAnalyzedCount }}</h3>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Recent Generated -->
        <div class="lg:col-span-2 bg-spa-white rounded-xl shadow-sm border border-spa-beige overflow-hidden">
            <div class="px-6 py-4 border-b border-spa-beige flex justify-between items-center">
                <h3 class="text-lg font-bold text-spa-charcoal">Recent Customer Promotions</h3>
                <a href="{{ route('manager.promotions.customer-promotions') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">View All &rarr;</a>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-spa-cream">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-spa-gray opacity-80 uppercase tracking-wider">Code</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-spa-gray opacity-80 uppercase tracking-wider">Customer</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-spa-gray opacity-80 uppercase tracking-wider">Rule</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-spa-gray opacity-80 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-spa-white divide-y divide-gray-200">
                        @forelse($recentPromotions as $promo)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm font-mono bg-spa-beige text-spa-charcoal px-2 py-1 rounded">{{ $promo->code }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-spa-charcoal">{{ $promo->customer->name }}</div>
                                    <div class="text-xs text-spa-gray opacity-80">{{ $promo->customer->email }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-spa-charcoal">{{ $promo->rule->name }}</div>
                                    <div class="text-xs text-spa-gray opacity-80">
                                        @if($promo->discount_type === 'percentage')
                                            {{ $promo->discount_value }}% Off
                                        @elseif($promo->discount_type === 'fixed')
                                            ₱{{ $promo->discount_value }} Off
                                        @else
                                            Free Service
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <x-ui.status-badge :status="$promo->status" />
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8">
                                    <x-ui.empty-state 
                                        icon="tag" 
                                        title="No promotions generated yet" 
                                        description="Click 'Generate Promotions' to start." 
                                    />
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- RFM Segments -->
        <div class="bg-spa-white rounded-xl shadow-sm border border-spa-beige overflow-hidden">
            <div class="px-6 py-4 border-b border-spa-beige">
                <h3 class="text-lg font-bold text-spa-charcoal">RFM Segment Distribution</h3>
            </div>
            <div class="p-6">
                @if($segmentDistribution->isEmpty())
                    <div class="text-center text-spa-gray opacity-80 text-sm py-8">
                        No RFM data available. Generate promotions to calculate segments.
                    </div>
                @else
                    <ul class="space-y-4">
                        @foreach($segmentDistribution as $dist)
                            <li class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-3 h-3 rounded-full 
                                        @if($dist->segment === 'champions') bg-yellow-400
                                        @elseif($dist->segment === 'loyal_customers') bg-green-500
                                        @elseif($dist->segment === 'new_customers') bg-blue-500
                                        @elseif($dist->segment === 'at_risk') bg-orange-500
                                        @else bg-gray-400 @endif">
                                    </div>
                                    <span class="text-sm font-medium text-spa-charcoal opacity-90 capitalize">{{ str_replace('_', ' ', $dist->segment) }}</span>
                                </div>
                                <span class="text-sm font-bold text-spa-charcoal">{{ $dist->total }}</span>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
</x-manager-layout>
