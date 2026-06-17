<x-manager-layout>
    <x-slot name="header">
        Appointment Bookings
    </x-slot>

    <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Appointment Bookings</h2>
            <p class="text-sm text-gray-500 mt-1">Manage customer appointments, therapist assignment, and cash booking records.</p>
        </div>
        <a href="{{ route('manager.bookings.create') }}" class="inline-flex items-center px-4 py-2 bg-[#2c3e38] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-[#1f2d28] focus:bg-[#1f2d28] active:bg-[#1f2d28] focus:outline-none focus:ring-2 focus:ring-[#2c3e38] focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            Add Booking
        </a>
    </div>

    @if (session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-6">
        <div class="p-6 border-b border-gray-100 bg-gray-50/50">
            <form method="GET" action="{{ route('manager.bookings.index') }}" class="grid grid-cols-1 md:grid-cols-6 gap-4">
                <div class="md:col-span-2">
                    <label for="search" class="sr-only">Search</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <input type="text" name="search" id="search" value="{{ request('search') }}" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-[#2c3e38] focus:border-[#2c3e38] sm:text-sm transition duration-150 ease-in-out" placeholder="Search ref, customer, service...">
                    </div>
                </div>
                <div>
                    <label for="date" class="sr-only">Date</label>
                    <input type="date" name="date" id="date" value="{{ request('date') }}" class="block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-[#2c3e38] focus:border-[#2c3e38] sm:text-sm text-gray-700">
                </div>
                <div>
                    <label for="therapist_id" class="sr-only">Therapist</label>
                    <select name="therapist_id" id="therapist_id" class="block w-full py-2 pl-3 pr-10 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-[#2c3e38] focus:border-[#2c3e38] sm:text-sm">
                        <option value="">All Therapists</option>
                        @foreach($therapists as $t)
                            <option value="{{ $t->id }}" {{ request('therapist_id') == $t->id ? 'selected' : '' }}>{{ $t->user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="status" class="sr-only">Status</label>
                    <select name="status" id="status" class="block w-full py-2 pl-3 pr-10 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-[#2c3e38] focus:border-[#2c3e38] sm:text-sm">
                        <option value="">All Statuses</option>
                        <option value="booked" {{ request('status') == 'booked' ? 'selected' : '' }}>Booked</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="flex-1 px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#2c3e38]">
                        Filter
                    </button>
                    @if(request()->hasAny(['search', 'therapist_id', 'status', 'date']))
                        <a href="{{ route('manager.bookings.index') }}" class="px-4 py-2 border border-transparent text-sm font-medium text-[#2c3e38] hover:text-[#1f2d28]">
                            Clear
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reference / Customer</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date & Time</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Service / Therapist</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status / Payment</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($bookings as $booking)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-xs font-mono text-gray-500 mb-1">{{ $booking->booking_reference }}</div>
                                <div class="text-sm font-medium text-gray-900">{{ $booking->customer_name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $booking->appointment_date->format('M d, Y') }}</div>
                                <div class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($booking->start_time)->format('g:i A') }} - {{ \Carbon\Carbon::parse($booking->end_time)->format('g:i A') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $booking->service->name }}</div>
                                <div class="text-sm text-gray-500">{{ $booking->therapist->user->name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="mb-1">
                                    @if($booking->status === 'booked')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Booked</span>
                                    @elseif($booking->status === 'completed')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Completed</span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Cancelled</span>
                                    @endif
                                </div>
                                <div>
                                    @if($booking->payment_status === 'paid')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-50 text-green-700 border border-green-200">Paid (Cash)</span>
                                    @elseif($booking->payment_status === 'cancelled')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-50 text-gray-600 border border-gray-200">Cancelled</span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-50 text-yellow-700 border border-yellow-200">Unpaid</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <div class="text-sm font-medium text-gray-900">₱{{ number_format($booking->amount_paid, 2) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('manager.bookings.show', $booking) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">View</a>
                                <a href="{{ route('manager.bookings.edit', $booking) }}" class="text-[#2c3e38] hover:text-[#1f2d28] mr-3">Edit</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 whitespace-nowrap text-sm text-gray-500 text-center">
                                No bookings found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($bookings->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $bookings->links() }}
            </div>
        @endif
    </div>
</x-manager-layout>
