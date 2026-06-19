<x-manager-layout>
    <x-slot name="header">
        Promotion Eligibility Simulator
    </x-slot>

    <div class="mb-6">
        <a href="{{ route('manager.promotions.index') }}" class="text-sm font-medium text-[#1f2d28] hover:underline">&larr; Back to Promotions</a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Simulator Form -->
        <div class="md:col-span-1">
            <div class="bg-spa-white rounded-xl shadow-sm border border-spa-beige p-6">
                <h3 class="text-lg font-bold text-spa-charcoal mb-4">Run Simulation</h3>
                <p class="text-xs text-spa-gray opacity-80 mb-6">Select a customer to evaluate which active promotion rules they are eligible for based on their current RFM snapshot.</p>

                <form action="{{ route('manager.promotions.simulate') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-spa-charcoal opacity-90 mb-1">Select Customer</label>
                        <select name="customer_id" class="w-full rounded-md border-spa-wood shadow-sm focus:border-spa-gold focus:ring-spa-gold text-sm" required>
                            <option value="">-- Choose Customer --</option>
                            @foreach($customers as $c)
                                <option value="{{ $c->id }}" {{ session('simulated_customer') && session('simulated_customer')->id == $c->id ? 'selected' : '' }}>
                                    {{ $c->name }} ({{ $c->email }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mt-6">
                        <button type="submit" class="w-full px-4 py-2 bg-[#2c3e38] text-white rounded-md font-medium text-sm hover:bg-[#1f2d28] transition-colors shadow-sm">
                            Evaluate RFM & Rules
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Results -->
        <div class="md:col-span-2">
            @if(session('error'))
                <div class="bg-red-50 border-l-4 border-red-400 p-4 rounded-r-lg mb-6">
                    <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                </div>
            @endif

            @if(session('simulation_results'))
                @php
                    $simulatedCustomer = session('simulated_customer');
                    $snapshot = session('snapshot');
                    $results = session('simulation_results');
                @endphp

                <!-- RFM Snapshot Details -->
                <div class="bg-spa-white rounded-xl shadow-sm border border-spa-beige p-6 mb-6">
                    <h3 class="text-lg font-bold text-spa-charcoal border-b pb-2 mb-4">RFM Profile: {{ $simulatedCustomer->name }}</h3>
                    
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
                        <div class="bg-spa-cream p-3 rounded-lg border border-spa-beige">
                            <div class="text-xs text-spa-gray opacity-80 uppercase tracking-wider mb-1">Segment</div>
                            <div class="font-bold text-spa-gold capitalize">{{ str_replace('_', ' ', $snapshot->segment) }}</div>
                        </div>
                        <div class="bg-spa-cream p-3 rounded-lg border border-spa-beige">
                            <div class="text-xs text-spa-gray opacity-80 uppercase tracking-wider mb-1">Recency</div>
                            <div class="font-bold text-spa-charcoal">{{ $snapshot->recency_days ?? 'N/A' }} days</div>
                        </div>
                        <div class="bg-spa-cream p-3 rounded-lg border border-spa-beige">
                            <div class="text-xs text-spa-gray opacity-80 uppercase tracking-wider mb-1">Frequency</div>
                            <div class="font-bold text-spa-charcoal">{{ $snapshot->frequency_count }} visits</div>
                        </div>
                        <div class="bg-spa-cream p-3 rounded-lg border border-spa-beige">
                            <div class="text-xs text-spa-gray opacity-80 uppercase tracking-wider mb-1">Monetary</div>
                            <div class="font-bold text-spa-charcoal">₱{{ number_format($snapshot->monetary_total, 2) }}</div>
                        </div>
                    </div>
                </div>

                <!-- Rule Evaluation -->
                <div class="bg-spa-white rounded-xl shadow-sm border border-spa-beige overflow-hidden">
                    <div class="px-6 py-4 border-b border-spa-beige">
                        <h3 class="text-lg font-bold text-spa-charcoal">Rule Eligibility Evaluation</h3>
                    </div>
                    <ul class="divide-y divide-gray-100">
                        @foreach($results as $result)
                            <li class="p-6 {{ $result['eligible'] ? 'bg-green-50/30' : '' }}">
                                <div class="flex items-start justify-between">
                                    <div>
                                        <h4 class="text-sm font-bold text-spa-charcoal">{{ $result['rule']->name }}</h4>
                                        <div class="text-xs text-spa-gray opacity-80 mt-1">
                                            Target Segment: {{ $result['rule']->segment ? str_replace('_', ' ', $result['rule']->segment) : 'All' }}
                                        </div>
                                        <div class="text-xs mt-2 {{ $result['eligible'] ? 'text-green-600 font-medium' : 'text-red-500' }}">
                                            Result: {{ $result['reason'] }}
                                        </div>
                                    </div>
                                    <div>
                                        @if($result['eligible'])
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Eligible
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                Not Eligible
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </li>
                        @endforeach
                        @if(empty($results))
                            <li class="p-6 text-center text-sm text-spa-gray opacity-80">No active rules to evaluate.</li>
                        @endif
                    </ul>
                </div>
            @else
                <div class="bg-spa-cream rounded-xl border border-spa-beige border-dashed p-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-spa-gray opacity-60 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    <p class="text-spa-gray opacity-80 text-sm">Select a customer and run the simulation to see their eligibility.</p>
                </div>
            @endif
        </div>
    </div>
</x-manager-layout>
