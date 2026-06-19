<x-therapist-layout>
    <x-slot name="header">
        Therapist Dashboard
    </x-slot>

    @if(!$therapist)
        <!-- No Profile Warning -->
        <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6 rounded-r-lg">
            <div class="flex items-center">
                <svg class="h-6 w-6 text-red-400 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <div>
                    <h3 class="text-sm font-medium text-red-800">Profile Not Linked</h3>
                    <p class="mt-1 text-sm text-red-700">Your therapist profile is not yet linked. Please contact the manager.</p>
                </div>
            </div>
        </div>
    @else
        <!-- Welcome Section -->
        <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white p-6 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-[#e8dbce] opacity-20 rounded-bl-full -mr-4 -mt-4 pointer-events-none"></div>
            <div class="absolute bottom-0 right-16 w-16 h-16 bg-[#1f2d28] opacity-5 rounded-t-full pointer-events-none"></div>
            
            <div class="relative z-10">
                <h2 class="text-2xl font-bold text-gray-800">Welcome back, {{ $therapist->user->name }}!</h2>
                <div class="flex items-center gap-2 mt-1">
                    <p class="text-gray-500">{{ $therapist->specialization ?? 'General Therapist' }}</p>
                    <span class="mx-2 text-gray-300">•</span>
                    <x-ui.status-badge :status="$therapist->status" />
                </div>
            </div>
            
            <div class="relative z-10 flex gap-2">
                <a href="{{ route('availability.index') }}" class="inline-flex items-center px-4 py-2 bg-white text-[#1f2d28] border border-[#1f2d28] font-medium rounded-full hover:bg-gray-50 transition-colors shadow-sm text-sm">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Manage Availability
                </a>
            </div>
        </div>

        <!-- Main Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            
            <!-- Today's Schedule -->
            <div class="bg-gradient-to-br from-[#1f2d28] to-[#141f1b] rounded-2xl shadow-md p-6 text-white relative overflow-hidden flex flex-col justify-between">
                <div class="absolute top-0 right-0 p-4 opacity-20">
                    <svg class="w-24 h-24 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
                
                <div class="relative z-10">
                    <div class="text-[#a0afaa] text-xs font-semibold uppercase tracking-wider mb-2">Today's Schedule</div>
                    <div class="text-4xl font-bold mb-1">{{ $todayAssignedBookingsCount }}</div>
                    <div class="text-[#e8dbce] text-sm font-medium">Assigned Sessions</div>
                </div>
                
                <div class="mt-6 pt-4 border-t border-[#2c3e38] relative z-10">
                    <a href="{{ route('therapist.bookings.index') }}" class="text-xs text-[#a0afaa] hover:text-white transition-colors flex items-center">
                        View Schedule <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                </div>
            </div>

            <!-- Upcoming Bookings -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col justify-between hover:shadow-md transition-shadow group">
                <div>
                    <div class="flex justify-between items-start mb-4">
                        <div class="w-10 h-10 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </div>
                    <div class="text-gray-500 text-xs font-semibold uppercase tracking-wider">Upcoming Bookings</div>
                    <div class="mt-1 text-3xl font-bold text-gray-900">{{ $upcomingBookingsCount }}</div>
                </div>
                <div class="mt-4 flex gap-4">
                    <a href="{{ route('therapist.bookings.index') }}" class="text-sm text-blue-600 font-medium hover:underline">View All</a>
                </div>
            </div>

            <!-- Unpaid Commission -->
            <div class="bg-white rounded-2xl shadow-sm border-l-4 border-yellow-400 p-6 flex flex-col justify-between hover:shadow-md transition-shadow group">
                <div>
                    <div class="flex justify-between items-start mb-4">
                        <div class="w-10 h-10 rounded-full bg-yellow-50 text-yellow-600 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </div>
                    <div class="text-gray-500 text-xs font-semibold uppercase tracking-wider">Unpaid Commission</div>
                    <div class="mt-1 text-3xl font-bold text-gray-900">₱{{ number_format($unpaidCommissionTotal, 2) }}</div>
                </div>
                <div class="mt-4 flex gap-4">
                    <a href="{{ route('therapist.commissions.index') }}" class="text-sm text-yellow-600 font-medium hover:underline">View Ledger</a>
                </div>
            </div>

            <!-- Paid Commission -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col justify-between hover:shadow-md transition-shadow group hidden lg:flex">
                <div>
                    <div class="flex justify-between items-start mb-4">
                        <div class="w-10 h-10 rounded-full bg-green-50 text-green-600 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </div>
                    <div class="text-gray-500 text-xs font-semibold uppercase tracking-wider">Paid Commission</div>
                    <div class="mt-1 text-3xl font-bold text-gray-900">₱{{ number_format($paidCommissionTotal, 2) }}</div>
                </div>
            </div>

            <!-- Completed Bookings -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col justify-between hover:shadow-md transition-shadow group hidden lg:flex">
                <div>
                    <div class="flex justify-between items-start mb-4">
                        <div class="w-10 h-10 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                    </div>
                    <div class="text-gray-500 text-xs font-semibold uppercase tracking-wider">Completed Sessions</div>
                    <div class="mt-1 text-3xl font-bold text-gray-900">{{ $completedBookingsCount }}</div>
                </div>
            </div>

            <!-- My Availability -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col justify-between hover:shadow-md transition-shadow group">
                <div>
                    <div class="flex justify-between items-start mb-4">
                        <div class="w-10 h-10 rounded-full bg-purple-50 text-purple-600 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <span class="text-xs font-medium bg-purple-100 text-purple-800 px-2 py-1 rounded-full">{{ $upcomingAvailabilityCount }} Upcoming</span>
                    </div>
                    <div class="text-gray-500 text-xs font-semibold uppercase tracking-wider">My Availability</div>
                    <div class="mt-1 text-xl font-bold text-gray-900">Schedule</div>
                </div>
                <div class="mt-4 flex gap-4">
                    <a href="{{ route('availability.index') }}" class="text-sm text-purple-600 font-medium hover:underline">Update Now</a>
                </div>
            </div>

        </div>

        <div class="grid grid-cols-1 xl:grid-cols-2 gap-8">
            
            <!-- Bookings Left Column -->
            <div class="space-y-8">
                <!-- Today's Bookings Preview -->
                <div>
                    <div class="flex justify-between items-end mb-4">
                        <h3 class="text-lg font-bold text-gray-900">Today's Sessions</h3>
                        <span class="text-sm text-gray-500">{{ \Carbon\Carbon::today()->format('M d, Y') }}</span>
                    </div>
                    
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <ul class="divide-y divide-gray-100">
                            @forelse($todayBookings as $booking)
                                <li class="p-4 hover:bg-gray-50 transition-colors">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-4">
                                            <div class="w-16 text-center">
                                                <div class="text-sm font-bold text-gray-900">{{ \Carbon\Carbon::parse($booking->start_time)->format('g:i A') }}</div>
                                            </div>
                                            <div class="w-px h-10 bg-gray-200"></div>
                                            <div>
                                                <p class="text-sm font-semibold text-gray-900">{{ $booking->service->name }}</p>
                                                <p class="text-xs text-gray-500 mt-0.5">Client: {{ $booking->customer->name }}</p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <x-ui.status-badge :status="$booking->status" />
                                        </div>
                                    </div>
                                </li>
                            @empty
                                <li class="p-8 text-center text-gray-500 text-sm">
                                    No sessions assigned for today.
                                </li>
                            @endforelse
                        </ul>
                    </div>
                </div>

                <!-- Upcoming Bookings Preview -->
                <div>
                    <div class="flex justify-between items-end mb-4">
                        <h3 class="text-lg font-bold text-gray-900">Upcoming Sessions</h3>
                        <a href="{{ route('therapist.bookings.index') }}" class="text-sm font-medium text-[#1f2d28] hover:underline">View All</a>
                    </div>
                    
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <ul class="divide-y divide-gray-100">
                            @forelse($upcomingBookings as $booking)
                                <li class="p-4 hover:bg-gray-50 transition-colors">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-4">
                                            <div class="hidden sm:flex w-12 h-12 rounded-lg bg-gray-50 text-gray-700 flex-col items-center justify-center border border-gray-100">
                                                <span class="text-xs font-bold uppercase">{{ \Carbon\Carbon::parse($booking->booking_date)->format('M') }}</span>
                                                <span class="text-lg font-bold leading-none">{{ \Carbon\Carbon::parse($booking->booking_date)->format('d') }}</span>
                                            </div>
                                            <div>
                                                <p class="text-sm font-semibold text-gray-900">{{ $booking->service->name }}</p>
                                                <p class="text-xs text-gray-500 mt-0.5">
                                                    {{ \Carbon\Carbon::parse($booking->booking_date)->format('M d, Y') }} • {{ \Carbon\Carbon::parse($booking->start_time)->format('g:i A') }}
                                                </p>
                                                <p class="text-xs text-gray-500 mt-0.5">Client: {{ $booking->customer->name }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @empty
                                <li class="p-8 text-center text-gray-500 text-sm">
                                    No upcoming sessions found.
                                </li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Availability & Commission Right Column -->
            <div class="space-y-8">
                <!-- Upcoming Availability Preview -->
                <div>
                    <div class="flex justify-between items-end mb-4">
                        <h3 class="text-lg font-bold text-gray-900">Upcoming Availability</h3>
                        <a href="{{ route('availability.index') }}" class="text-sm font-medium text-[#1f2d28] hover:underline">Manage</a>
                    </div>
                    
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <ul class="divide-y divide-gray-100">
                            @forelse($upcomingAvailability as $avail)
                                <li class="p-4 hover:bg-gray-50 transition-colors">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-full bg-purple-50 text-purple-600 flex items-center justify-center">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            </div>
                                            <div>
                                                <p class="text-sm font-semibold text-gray-900">{{ \Carbon\Carbon::parse($avail->availability_date)->format('M d, Y') }}</p>
                                                <p class="text-xs text-gray-500 mt-0.5">
                                                    {{ \Carbon\Carbon::parse($avail->start_time)->format('g:i A') }} - {{ \Carbon\Carbon::parse($avail->end_time)->format('g:i A') }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <x-ui.status-badge :status="$avail->status" />
                                        </div>
                                    </div>
                                </li>
                            @empty
                                <li class="p-8 text-center text-gray-500 text-sm">
                                    No upcoming availability records.
                                </li>
                            @endforelse
                        </ul>
                    </div>
                </div>

                <!-- Recent Commission Preview -->
                <div>
                    <div class="flex justify-between items-end mb-4">
                        <h3 class="text-lg font-bold text-gray-900">Recent Commission</h3>
                        <a href="{{ route('therapist.commissions.index') }}" class="text-sm font-medium text-[#1f2d28] hover:underline">View All</a>
                    </div>
                    
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <ul class="divide-y divide-gray-100">
                            @forelse($recentCommissions as $commission)
                                <li class="p-4 hover:bg-gray-50 transition-colors">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-sm font-semibold text-gray-900">{{ $commission->service->name }}</p>
                                            <p class="text-xs text-gray-500 mt-0.5">{{ $commission->commission_reference }} • {{ $commission->created_at->format('M d, Y') }}</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-sm font-bold text-gray-900">₱{{ number_format($commission->commission_amount, 2) }}</p>
                                            <div class="mt-0.5">
                                                <x-ui.status-badge :status="$commission->status" />
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @empty
                                <li class="p-8 text-center text-gray-500 text-sm">
                                    No commission records found.
                                </li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
            
        </div>
    @endif
</x-therapist-layout>

