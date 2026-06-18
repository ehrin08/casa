@php
    use App\Models\Booking;
    use App\Models\Transaction;
    use App\Models\Service;
    use Carbon\Carbon;
@endphp

<x-manager-layout>
    <x-slot name="header">
        {{ __('Manager Dashboard') }}
    </x-slot>

    @php

        $today = Carbon::today();
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        // 1. Today's Revenue
        $todayRevenue = Transaction::where('payment_status', 'paid')
            ->whereDate('payment_date', $today)
            ->sum('total_amount');

        // 2. This Month's Sales
        $monthSales = Transaction::where('payment_status', 'paid')
            ->whereBetween('payment_date', [$startOfMonth, $endOfMonth])
            ->sum('total_amount');

        // 3. Paid Transactions (This Month)
        $paidTxCount = Transaction::where('payment_status', 'paid')
            ->whereBetween('payment_date', [$startOfMonth, $endOfMonth])
            ->count();

        // 4. Top Service (This Month)
        $topService = Transaction::where('payment_status', 'paid')
            ->whereBetween('payment_date', [$startOfMonth, $endOfMonth])
            ->join('services', 'transactions.service_id', '=', 'services.id')
            ->selectRaw('services.name, COUNT(transactions.id) as count')
            ->groupBy('services.id', 'services.name')
            ->orderByDesc('count')
            ->first();
        
        $topServiceName = $topService ? $topService->name : 'N/A';

        // 5. Recent Transactions
        $recentTransactions = Transaction::with(['service', 'customer'])
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();
            
        // 6. Today's Appointments (Pending/Booked)
        $pendingBookings = Booking::whereDate('appointment_date', $today)
            ->whereIn('status', ['booked', 'confirmed'])
            ->count();
            
        // 7. Sentiment Summary
        $reviewAvg = \App\Models\Review::avg('rating') ?? 0;
        $reviewPos = \App\Models\Review::where('sentiment', 'positive')->count();
        $reviewNeg = \App\Models\Review::where('sentiment', 'negative')->count();
    @endphp

    <div class="mb-8">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-medium text-gray-800">Analytics Summary</h2>
            <a href="{{ route('manager.analytics.index') }}" class="text-sm font-medium text-[#2c3e38] hover:text-[#1f2d28] flex items-center">
                View Full Analytics
                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <x-dashboard.stat-card 
                title="Today's Revenue" 
                value="₱{{ number_format($todayRevenue, 2) }}" 
                subtitle="From completed appointments"
                icon="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" 
                color="text-green-600" 
                bg="bg-green-100" />
            
            <x-dashboard.stat-card 
                title="This Month's Sales" 
                value="₱{{ number_format($monthSales, 2) }}" 
                subtitle="{{ $startOfMonth->format('M d') }} - {{ $endOfMonth->format('M d') }}"
                icon="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" 
            />

            <x-dashboard.stat-card 
                title="Monthly Transactions" 
                value="{{ $paidTxCount }}" 
                subtitle="Successfully paid this month"
                icon="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" 
            />

            <x-dashboard.stat-card 
                title="Top Service" 
                value="{{ $topServiceName }}" 
                subtitle="Most booked this month"
                icon="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" 
                color="text-yellow-600" 
                bg="bg-yellow-100" />
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-8">
            <!-- Today's Appointment Overview -->
            <x-dashboard.section-card title="Today's Appointments" action="View All Bookings" actionUrl="{{ route('manager.bookings.index') }}">
                @if($pendingBookings > 0)
                    <div class="flex items-center justify-between py-4 border-b border-gray-100">
                        <div class="flex items-center">
                            <div class="h-10 w-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold">
                                {{ $pendingBookings }}
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-900">Appointments scheduled for today</p>
                                <p class="text-xs text-gray-500">Go to Appointments module to manage them.</p>
                            </div>
                        </div>
                        <a href="{{ route('manager.bookings.index') }}" class="px-3 py-1 bg-white border border-gray-300 rounded-md text-xs font-medium text-gray-700 hover:bg-gray-50">Manage</a>
                    </div>
                @else
                    <div class="flex flex-col items-center justify-center py-10 text-gray-500 bg-gray-50 rounded-xl border border-dashed border-gray-200">
                        <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <p class="text-sm font-medium">No appointments remaining today.</p>
                    </div>
                @endif
            </x-dashboard.section-card>

            <!-- Recent Transactions -->
            <x-dashboard.section-card title="Recent Transactions" action="View All" actionUrl="{{ route('manager.transactions.index') }}">
                <div class="space-y-4">
                    @forelse($recentTransactions as $tx)
                        <div class="flex items-start">
                            <div class="flex-shrink-0 h-8 w-8 rounded-full bg-[#e8dbce] flex items-center justify-center text-[#7a6b5d]">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div class="ml-4 flex-1">
                                <p class="text-sm font-medium text-gray-800">₱{{ number_format($tx->total_amount, 2) }} - {{ $tx->customer ? $tx->customer->name : 'Walk-in' }}</p>
                                <p class="text-xs text-gray-500">{{ $tx->created_at->diffForHumans() }} ({{ $tx->payment_status }})</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500">No recent transactions.</p>
                    @endforelse
                </div>
            </x-dashboard.section-card>
        </div>

        <div class="space-y-8">
            <!-- Quick Actions Section -->
            <x-dashboard.section-card title="Quick Actions">
                <div class="grid grid-cols-1 gap-3">
                    <a href="{{ route('manager.bookings.index') }}" class="flex items-center p-3 text-sm font-medium text-[#2c3e38] bg-[#f0f4f2] rounded-lg hover:bg-[#e2ebe7] transition-colors border border-[#d5e0dc]">
                        <svg class="w-5 h-5 mr-3 text-[#40544c]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        Manage Appointments
                    </a>
                    <a href="{{ route('manager.analytics.index') }}" class="flex items-center p-3 text-sm font-medium text-[#4a3f35] bg-[#f9f8f6] rounded-lg hover:bg-[#f2ede9] transition-colors border border-[#e8dbce]">
                        <svg class="w-5 h-5 mr-3 text-[#7a6b5d]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                        View Full Reports
                    </a>
                    <a href="{{ route('manager.services.index') }}" class="flex items-center p-3 text-sm font-medium text-[#4a3f35] bg-[#f9f8f6] rounded-lg hover:bg-[#f2ede9] transition-colors border border-[#e8dbce]">
                        <svg class="w-5 h-5 mr-3 text-[#7a6b5d]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                        Manage Services
                    </a>
                    <a href="{{ route('manager.therapists.index') }}" class="flex items-center p-3 text-sm font-medium text-[#4a3f35] bg-[#f9f8f6] rounded-lg hover:bg-[#f2ede9] transition-colors border border-[#e8dbce]">
                        <svg class="w-5 h-5 mr-3 text-[#7a6b5d]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        Manage Therapists
                    </a>
                </div>
            </x-dashboard.section-card>

            <!-- Customer Sentiment Summary -->
            <x-dashboard.section-card title="Customer Sentiment" action="View Reviews" actionUrl="{{ route('manager.reviews.index') }}">
                <div class="grid grid-cols-3 gap-2 text-center mt-2 mb-4">
                    <div class="bg-yellow-50 rounded-lg p-2 border border-yellow-100">
                        <div class="text-xs font-semibold text-yellow-700 uppercase mb-1">Avg</div>
                        <div class="text-xl font-bold text-yellow-600">{{ number_format($reviewAvg, 1) }}</div>
                    </div>
                    <div class="bg-green-50 rounded-lg p-2 border border-green-100">
                        <div class="text-xs font-semibold text-green-700 uppercase mb-1">Positive</div>
                        <div class="text-xl font-bold text-green-600">{{ $reviewPos }}</div>
                    </div>
                    <div class="bg-red-50 rounded-lg p-2 border border-red-100">
                        <div class="text-xs font-semibold text-red-700 uppercase mb-1">Negative</div>
                        <div class="text-xl font-bold text-red-600">{{ $reviewNeg }}</div>
                    </div>
                </div>
            </x-dashboard.section-card>
        </div>
    </div>
</x-manager-layout>
