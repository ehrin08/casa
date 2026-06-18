<x-customer-layout>
    <x-slot name="header">
        Dashboard
    </x-slot>

    <!-- Welcome Section -->
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white p-6 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-32 h-32 bg-[#e8dbce] opacity-20 rounded-bl-full -mr-4 -mt-4 pointer-events-none"></div>
        <div class="absolute bottom-0 right-16 w-16 h-16 bg-[#2c3e38] opacity-5 rounded-t-full pointer-events-none"></div>
        
        <div class="relative z-10">
            <h2 class="text-2xl font-bold text-gray-800">Welcome back, {{ auth()->user()->name }}!</h2>
            <p class="text-gray-500 mt-1">Ready to book your next wellness session?</p>
        </div>
        
        <div class="relative z-10">
            <a href="{{ route('customer.bookings.create') }}" class="inline-flex items-center px-6 py-3 bg-[#2c3e38] text-white font-medium rounded-full hover:bg-[#1f2d28] transition-colors shadow-md shadow-[#2c3e38]/20">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                Book Appointment
            </a>
        </div>
    </div>

    <!-- Main Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        
        <!-- Upcoming Appointment Card -->
        <div class="bg-gradient-to-br from-[#2c3e38] to-[#1f2d28] rounded-2xl shadow-md p-6 text-white relative overflow-hidden flex flex-col justify-between">
            <div class="absolute top-0 right-0 p-4 opacity-20">
                <svg class="w-24 h-24 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            </div>
            
            <div class="relative z-10">
                <div class="text-[#a0afaa] text-xs font-semibold uppercase tracking-wider mb-4">Next Appointment</div>
                
                @if($nextAppointment)
                    <div class="mb-1 text-xl font-bold">{{ \Carbon\Carbon::parse($nextAppointment->booking_date)->format('M d, Y') }}</div>
                    <div class="text-[#e8dbce] font-medium">{{ \Carbon\Carbon::parse($nextAppointment->start_time)->format('g:i A') }}</div>
                    <div class="mt-4 text-sm">{{ $nextAppointment->service->name }}</div>
                    <div class="text-xs text-[#a0afaa] mt-1">with {{ $nextAppointment->therapist->user->name }}</div>
                @else
                    <div class="text-xl font-medium text-gray-300 mt-2">No upcoming appointment</div>
                    <a href="{{ route('customer.bookings.create') }}" class="inline-block mt-4 text-sm text-[#e8dbce] hover:text-white underline">Schedule one now</a>
                @endif
            </div>
            
            @if($canCancel)
                <div class="mt-6 pt-4 border-t border-[#3d524a] relative z-10 flex justify-end">
                    <form action="{{ route('customer.bookings.cancel', $nextAppointment) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to cancel this appointment?');">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="text-xs text-red-300 hover:text-red-100 transition-colors">
                            Cancel Appointment
                        </button>
                    </form>
                </div>
            @endif
        </div>

        <!-- Available Services Card -->
        <a href="{{ route('customer.services.index') }}" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col justify-between hover:shadow-md transition-shadow group">
            <div>
                <div class="flex justify-between items-start mb-4">
                    <div class="w-12 h-12 rounded-full bg-[#f0f4f2] text-[#2c3e38] flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <span class="text-xs font-medium bg-green-100 text-green-800 px-2 py-1 rounded-full">{{ $availableServicesCount }} Available</span>
                </div>
                <div class="text-gray-500 text-xs font-semibold uppercase tracking-wider">Available Services</div>
                <div class="mt-1 text-2xl font-bold text-gray-900">Explore Spa</div>
            </div>
            <div class="mt-4 text-sm text-[#2c3e38] font-medium group-hover:underline flex items-center">
                Browse Menu <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </div>
        </a>

        <!-- Receipts Card -->
        <a href="{{ route('customer.transactions.index') }}" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col justify-between hover:shadow-md transition-shadow group">
            <div>
                <div class="flex justify-between items-start mb-4">
                    <div class="w-12 h-12 rounded-full bg-[#f9f8f6] text-[#7a6b5d] flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <span class="text-xs font-medium bg-gray-100 text-gray-800 px-2 py-1 rounded-full">{{ $receiptsCount }} Records</span>
                </div>
                <div class="text-gray-500 text-xs font-semibold uppercase tracking-wider">Payment History</div>
                <div class="mt-1 text-2xl font-bold text-gray-900">Receipts</div>
            </div>
            <div class="mt-4 text-sm text-[#7a6b5d] font-medium group-hover:underline flex items-center">
                View History <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </div>
        </a>
        
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        <!-- Recent Bookings Section -->
        <div>
            <div class="flex justify-between items-end mb-4">
                <h3 class="text-lg font-bold text-gray-900">Recent Appointments</h3>
                <a href="{{ route('customer.bookings.index') }}" class="text-sm font-medium text-[#2c3e38] hover:underline">View All</a>
            </div>
            
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <ul class="divide-y divide-gray-100">
                    @forelse($recentBookings as $booking)
                        <li class="p-4 hover:bg-gray-50 transition-colors">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-4">
                                    <div class="hidden sm:flex w-12 h-12 rounded-lg bg-[#f0f4f2] text-[#2c3e38] flex-col items-center justify-center">
                                        <span class="text-xs font-bold uppercase">{{ \Carbon\Carbon::parse($booking->booking_date)->format('M') }}</span>
                                        <span class="text-lg font-bold leading-none">{{ \Carbon\Carbon::parse($booking->booking_date)->format('d') }}</span>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900">{{ $booking->service->name }}</p>
                                        <p class="text-xs text-gray-500 mt-0.5">
                                            {{ \Carbon\Carbon::parse($booking->booking_date)->format('M d, Y') }} • {{ \Carbon\Carbon::parse($booking->start_time)->format('g:i A') }}
                                        </p>
                                        <p class="text-xs text-gray-500 mt-0.5">Therapist: {{ $booking->therapist->user->name }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    @if($booking->status === 'booked')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Upcoming</span>
                                    @elseif($booking->status === 'completed')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Completed</span>
                                    @elseif($booking->status === 'cancelled')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Cancelled</span>
                                    @endif
                                </div>
                            </div>
                        </li>
                    @empty
                        <li class="p-8 text-center">
                            <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-gray-100 text-gray-400 mb-3">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            <p class="text-gray-500 text-sm">No recent bookings found.</p>
                            <a href="{{ route('customer.bookings.create') }}" class="text-[#2c3e38] font-medium text-sm hover:underline mt-2 inline-block">Book your first session</a>
                        </li>
                    @endforelse
                </ul>
            </div>
        </div>

        <!-- Featured Services Preview -->
        <div>
            <div class="flex justify-between items-end mb-4">
                <h3 class="text-lg font-bold text-gray-900">Featured Services</h3>
                <a href="{{ route('customer.services.index') }}" class="text-sm font-medium text-[#2c3e38] hover:underline">View Menu</a>
            </div>
            
            <div class="grid gap-4">
                @forelse($availableServices as $service)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 flex items-center justify-between hover:border-[#2c3e38] transition-colors group">
                        <div>
                            <h4 class="text-sm font-bold text-gray-900">{{ $service->name }}</h4>
                            <div class="flex items-center text-xs text-gray-500 mt-1">
                                <span class="capitalize">{{ $service->category }}</span>
                                <span class="mx-2">•</span>
                                <span>{{ $service->duration_minutes }} mins</span>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-sm font-bold text-[#2c3e38]">₱{{ number_format($service->price, 2) }}</div>
                            <a href="{{ route('customer.bookings.create', ['service_id' => $service->id]) }}" class="text-xs font-medium text-gray-400 group-hover:text-[#2c3e38] transition-colors mt-1 block">Book Now</a>
                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 text-center text-gray-500 text-sm">
                        No services available right now.
                    </div>
                @endforelse
            </div>
        </div>

    </div>
</x-customer-layout>

