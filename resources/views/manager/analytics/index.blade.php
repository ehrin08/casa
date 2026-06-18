<x-manager-layout>
    <x-slot name="header">
        Analytics Dashboard
    </x-slot>

    <!-- Header & Date Filters -->
    <div class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Analytics & Reports</h2>
            <p class="text-sm text-gray-500 mt-1">Monitor sales performance, bookings, services, promotions, commissions, and customer segments.</p>
        </div>
        
        <div class="flex flex-col sm:flex-row items-center gap-3 bg-white p-2 rounded-lg shadow-sm border border-gray-100 w-full md:w-auto">
            <form method="GET" action="{{ route('manager.analytics.index') }}" class="flex flex-wrap items-center gap-2 w-full">
                <!-- Quick Filters -->
                <div class="flex bg-gray-50 rounded-md p-1 border border-gray-200">
                    <button type="submit" name="filter" value="today" class="px-3 py-1.5 text-xs font-medium rounded-md transition-colors {{ $filter === 'today' ? 'bg-white shadow-sm text-gray-900' : 'text-gray-500 hover:text-gray-700' }}">Today</button>
                    <button type="submit" name="filter" value="week" class="px-3 py-1.5 text-xs font-medium rounded-md transition-colors {{ $filter === 'week' ? 'bg-white shadow-sm text-gray-900' : 'text-gray-500 hover:text-gray-700' }}">This Week</button>
                    <button type="submit" name="filter" value="month" class="px-3 py-1.5 text-xs font-medium rounded-md transition-colors {{ $filter === 'month' ? 'bg-white shadow-sm text-gray-900' : 'text-gray-500 hover:text-gray-700' }}">This Month</button>
                </div>

                <!-- Custom Range -->
                <div class="flex items-center gap-2 ml-2">
                    <input type="date" name="date_from" value="{{ request('date_from') }}" class="text-xs border-gray-300 rounded-md shadow-sm focus:border-[#2c3e38] focus:ring focus:ring-[#2c3e38] focus:ring-opacity-50">
                    <span class="text-gray-500 text-xs">to</span>
                    <input type="date" name="date_to" value="{{ request('date_to') }}" class="text-xs border-gray-300 rounded-md shadow-sm focus:border-[#2c3e38] focus:ring focus:ring-[#2c3e38] focus:ring-opacity-50">
                    <button type="submit" name="filter" value="custom" class="px-3 py-1.5 bg-[#2c3e38] text-white text-xs font-medium rounded-md hover:bg-[#1f2d28] transition-colors">Apply</button>
                </div>
            </form>
            
            <div class="h-6 w-px bg-gray-200 hidden sm:block"></div>
            
            <a href="{{ route('manager.analytics.report', request()->all()) }}" target="_blank" class="flex items-center px-3 py-1.5 bg-gray-100 text-gray-700 hover:bg-gray-200 text-xs font-medium rounded-md transition-colors w-full sm:w-auto justify-center">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                PDF Report
            </a>
        </div>
    </div>

    <!-- Data Context Alert -->
    <div class="mb-6 bg-blue-50 border-l-4 border-blue-400 p-4">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm text-blue-700">
                    Currently viewing data for: <strong>{{ $dateRangeText }}</strong>. Most metrics and charts respect this date range.
                </p>
            </div>
        </div>
    </div>

    <!-- 1. KPI Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Revenue -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col hover:shadow-md transition-shadow">
            <dt class="text-sm font-medium text-gray-500 truncate flex justify-between items-center">
                Total Revenue
                <div class="p-2 bg-green-50 rounded-lg text-green-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </dt>
            <dd class="mt-2 text-3xl font-bold text-gray-900">₱{{ number_format($totalRevenue, 2) }}</dd>
            <p class="text-xs text-gray-500 mt-1">From {{ $paidTxCount }} paid transactions</p>
        </div>

        <!-- Bookings -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col hover:shadow-md transition-shadow">
            <dt class="text-sm font-medium text-gray-500 truncate flex justify-between items-center">
                Completed Bookings
                <div class="p-2 bg-blue-50 rounded-lg text-blue-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
            </dt>
            <dd class="mt-2 text-3xl font-bold text-gray-900">{{ $completedBookings }}</dd>
            <p class="text-xs text-gray-500 mt-1">Out of {{ $totalBookings }} total bookings</p>
        </div>

        <!-- ATV -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col hover:shadow-md transition-shadow">
            <dt class="text-sm font-medium text-gray-500 truncate flex justify-between items-center">
                Avg. Transaction Value
                <div class="p-2 bg-purple-50 rounded-lg text-purple-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
            </dt>
            <dd class="mt-2 text-3xl font-bold text-gray-900">₱{{ number_format($atv, 2) }}</dd>
            <p class="text-xs text-gray-500 mt-1">Per paid transaction</p>
        </div>

        <!-- Commissions -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col hover:shadow-md transition-shadow">
            <dt class="text-sm font-medium text-gray-500 truncate flex justify-between items-center">
                Commissions Payable
                <div class="p-2 bg-orange-50 rounded-lg text-orange-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
            </dt>
            <dd class="mt-2 text-3xl font-bold text-gray-900">₱{{ number_format($unpaidCommissions, 2) }}</dd>
            <p class="text-xs text-gray-500 mt-1">Currently unpaid</p>
        </div>
    </div>

    <!-- 2. Main Sales Charts (Chart.js) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Revenue Line Chart -->
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Revenue & Discounts over Time</h3>
            <div class="flex-1 w-full min-h-[300px] relative">
                @if(count($chartLabels) > 0)
                    <canvas id="revenueChart"></canvas>
                @else
                    <div class="absolute inset-0 flex items-center justify-center text-gray-400">No data available for this range.</div>
                @endif
            </div>
        </div>

        <!-- Status Breakdown -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Booking Status</h3>
            <div class="flex-1 w-full min-h-[300px] relative flex justify-center">
                @if(count($bookingStatusBreakdown) > 0)
                    <canvas id="bookingStatusChart"></canvas>
                @else
                    <div class="absolute inset-0 flex items-center justify-center text-gray-400">No data available.</div>
                @endif
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Top Services by Revenue -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Top Services by Revenue</h3>
            <div class="flex-1 w-full min-h-[300px] relative">
                @if(count($topServicesLabels) > 0)
                    <canvas id="servicesRevenueChart"></canvas>
                @else
                    <div class="absolute inset-0 flex items-center justify-center text-gray-400">No data available.</div>
                @endif
            </div>
        </div>

        <!-- Top Services by Count -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Top Services by Booking Count</h3>
            <div class="flex-1 w-full min-h-[300px] relative">
                @if(count($topServicesLabels) > 0)
                    <canvas id="servicesCountChart"></canvas>
                @else
                    <div class="absolute inset-0 flex items-center justify-center text-gray-400">No data available.</div>
                @endif
            </div>
        </div>
    </div>

    <!-- 3. RFM & Promotions Analytics -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- RFM Overview -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-bold text-gray-900">RFM Customer Segmentation</h3>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                    {{ $totalAnalyzed }} Analyzed
                </span>
            </div>

            @if($totalAnalyzed > 0)
                <div class="h-64 mb-6 relative flex justify-center">
                    <canvas id="rfmChart"></canvas>
                </div>
                
                <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Segment</th>
                                <th scope="col" class="px-3 py-3.5 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Count</th>
                                <th scope="col" class="px-3 py-3.5 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Avg Spent</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            @foreach($topSegmentsTable as $seg)
                                <tr>
                                    <td class="whitespace-nowrap py-3 pl-4 pr-3 text-sm font-medium text-gray-900 capitalize">{{ str_replace('_', ' ', $seg->segment) }}</td>
                                    <td class="whitespace-nowrap px-3 py-3 text-sm text-gray-500 text-center">{{ $seg->count }}</td>
                                    <td class="whitespace-nowrap px-3 py-3 text-sm text-gray-500 text-right">₱{{ number_format($seg->avg_monetary, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="py-12 text-center text-gray-500">
                    <svg class="mx-auto h-12 w-12 text-gray-400 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    No RFM data available yet.
                </div>
            @endif
        </div>

        <!-- Promotions & Commissions -->
        <div class="space-y-6">
            <!-- Promo Summary -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Promotion Engine Performance</h3>
                
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div class="bg-gray-50 p-4 rounded-lg text-center">
                        <div class="text-2xl font-bold text-[#2c3e38]">{{ $generatedPromotionsCount }}</div>
                        <div class="text-xs text-gray-500 uppercase tracking-wider mt-1">Codes Issued</div>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg text-center">
                        <div class="text-2xl font-bold text-green-600">{{ number_format($promoUsageRate, 1) }}%</div>
                        <div class="text-xs text-gray-500 uppercase tracking-wider mt-1">Usage Rate</div>
                    </div>
                </div>

                <div class="space-y-3">
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-500">Active Rules</span>
                        <span class="font-medium">{{ $activePromotions }}</span>
                    </div>
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-500">Available Codes</span>
                        <span class="font-medium text-blue-600">{{ $availablePromotionsCount }}</span>
                    </div>
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-500">Used Codes</span>
                        <span class="font-medium text-green-600">{{ $usedPromotionsCount }}</span>
                    </div>
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-500">Expired Codes</span>
                        <span class="font-medium text-red-600">{{ $expiredPromotionsCount }}</span>
                    </div>
                    <div class="flex justify-between items-center text-sm border-t border-gray-100 pt-2 mt-2">
                        <span class="text-gray-900 font-medium">Total Discounts Given</span>
                        <span class="font-bold text-red-600">₱{{ number_format($totalDiscounts, 2) }}</span>
                    </div>
                </div>
            </div>

            <!-- Commission Breakdowns -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Therapist Commissions (Date Range)</h3>
                
                <div class="overflow-y-auto max-h-[250px] pr-2">
                    <div class="space-y-4">
                        @forelse($commissionByTherapist as $comm)
                            <div class="flex items-center justify-between border-b border-gray-50 pb-2">
                                <div class="flex items-center">
                                    <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold text-xs mr-3">
                                        {{ substr($comm->therapist->user->name ?? 'T', 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ $comm->therapist->user->name ?? 'Unknown' }}</p>
                                        <p class="text-xs text-gray-500">{{ $comm->total_records }} services</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-bold text-gray-900">₱{{ number_format($comm->unpaid_total + $comm->paid_total, 2) }}</p>
                                    @if($comm->unpaid_total > 0)
                                        <p class="text-xs text-orange-600 font-medium">₱{{ number_format($comm->unpaid_total, 2) }} unpaid</p>
                                    @else
                                        <p class="text-xs text-green-600 font-medium">All paid</p>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500 text-center py-4">No commissions generated in this period.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 4. Customer Sentiment Placeholder -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-8">
        <div class="border-b border-gray-100 bg-gray-50/50 px-6 py-4 flex justify-between items-center">
            <div>
                <h3 class="text-lg font-bold text-gray-900">Customer Sentiment & Reviews</h3>
                <p class="text-xs text-gray-500 mt-1">AI-driven analysis of customer feedback</p>
            </div>
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium bg-gray-100 text-gray-800 border border-gray-200">
                Coming Soon
            </span>
        </div>
        <div class="p-8 text-center bg-gray-50">
            <svg class="mx-auto h-12 w-12 text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
            </svg>
            <h3 class="text-sm font-medium text-gray-900">Module Not Yet Active</h3>
            <p class="mt-1 text-sm text-gray-500 max-w-md mx-auto">
                Sentiment analytics and customer reviews will be enabled here after the Customer Reviews module is implemented in the upcoming phase.
            </p>
            <div class="mt-6 flex justify-center gap-4 opacity-40 grayscale pointer-events-none">
                <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200 w-32">
                    <div class="text-green-500 font-bold text-xl mb-1">98%</div>
                    <div class="text-xs text-gray-500 uppercase">Positive</div>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200 w-32">
                    <div class="text-yellow-500 font-bold text-xl mb-1">2%</div>
                    <div class="text-xs text-gray-500 uppercase">Neutral</div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <!-- Include Chart.js from CDN to keep build light -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Common Chart Setup
            Chart.defaults.font.family = "'Inter', 'system-ui', '-apple-system', 'sans-serif'";
            Chart.defaults.color = '#6b7280';
            Chart.defaults.scale.grid.color = '#f3f4f6';

            // 1. Revenue & Discounts Chart
            const revenueCtx = document.getElementById('revenueChart');
            if (revenueCtx) {
                new Chart(revenueCtx, {
                    type: 'line',
                    data: {
                        labels: @json($chartLabels),
                        datasets: [
                            {
                                label: 'Revenue',
                                data: @json($chartRevenue),
                                borderColor: '#2c3e38',
                                backgroundColor: 'rgba(44, 62, 56, 0.1)',
                                borderWidth: 2,
                                tension: 0.3,
                                fill: true
                            },
                            {
                                label: 'Discounts',
                                data: @json($chartDiscounts),
                                borderColor: '#ef4444',
                                backgroundColor: 'transparent',
                                borderWidth: 2,
                                borderDash: [5, 5],
                                tension: 0.3
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { position: 'top' },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return context.dataset.label + ': ₱' + context.parsed.y.toLocaleString();
                                    }
                                }
                            }
                        },
                        scales: {
                            y: { beginAtZero: true }
                        }
                    }
                });
            }

            // 2. Booking Status Chart
            const statusCtx = document.getElementById('bookingStatusChart');
            if (statusCtx) {
                const statusData = @json($bookingStatusBreakdown);
                new Chart(statusCtx, {
                    type: 'doughnut',
                    data: {
                        labels: Object.keys(statusData).map(s => s.charAt(0).toUpperCase() + s.slice(1)),
                        datasets: [{
                            data: Object.values(statusData),
                            backgroundColor: ['#2c3e38', '#10b981', '#ef4444', '#f59e0b', '#6b7280'],
                            borderWidth: 0,
                            cutout: '70%'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { position: 'bottom' }
                        }
                    }
                });
            }

            // 3. Top Services by Revenue
            const servRevCtx = document.getElementById('servicesRevenueChart');
            if (servRevCtx) {
                new Chart(servRevCtx, {
                    type: 'bar',
                    data: {
                        labels: @json($topServicesLabels),
                        datasets: [{
                            label: 'Revenue',
                            data: @json($topServicesRevenue),
                            backgroundColor: '#4f46e5',
                            borderRadius: 4
                        }]
                    },
                    options: {
                        indexAxis: 'y',
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false } }
                    }
                });
            }

            // 4. Top Services by Count
            const servCountCtx = document.getElementById('servicesCountChart');
            if (servCountCtx) {
                new Chart(servCountCtx, {
                    type: 'bar',
                    data: {
                        labels: @json($topServicesLabels),
                        datasets: [{
                            label: 'Bookings',
                            data: @json($topServicesCount),
                            backgroundColor: '#0ea5e9',
                            borderRadius: 4
                        }]
                    },
                    options: {
                        indexAxis: 'y',
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false } }
                    }
                });
            }

            // 5. RFM Distribution
            const rfmCtx = document.getElementById('rfmChart');
            if (rfmCtx) {
                const rfmData = @json($rfmSegmentDistribution);
                new Chart(rfmCtx, {
                    type: 'pie',
                    data: {
                        labels: Object.keys(rfmData),
                        datasets: [{
                            data: Object.values(rfmData),
                            backgroundColor: ['#10b981', '#3b82f6', '#f59e0b', '#8b5cf6', '#ef4444'],
                            borderWidth: 2,
                            borderColor: '#ffffff'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { position: 'right' } }
                    }
                });
            }
        });
    </script>
    @endpush
</x-manager-layout>
