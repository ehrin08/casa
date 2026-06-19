<x-customer-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-spa-charcoal leading-tight">
                {{ __('My Appointments') }}
            </h2>
            <a href="{{ route('customer.bookings.create') }}" class="inline-flex items-center px-4 py-2 bg-[#2c3e38] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-[#1f2d28] focus:bg-[#1f2d28] active:bg-[#1f2d28] focus:outline-none focus:ring-2 focus:ring-[#2c3e38] focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm">
                Book New Appointment
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">


            <div class="bg-spa-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-spa-charcoal">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-spa-cream">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-spa-gray opacity-80 uppercase tracking-wider">Date & Time</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-spa-gray opacity-80 uppercase tracking-wider">Service</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-spa-gray opacity-80 uppercase tracking-wider">Therapist</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-spa-gray opacity-80 uppercase tracking-wider">Status</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-spa-gray opacity-80 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-spa-white divide-y divide-gray-200">
                                @forelse ($bookings as $booking)
                                    <tr class="hover:bg-spa-beige transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-spa-charcoal">{{ $booking->appointment_date->format('M d, Y') }}</div>
                                            <div class="text-xs text-spa-gray opacity-80">{{ \Carbon\Carbon::parse($booking->start_time)->format('g:i A') }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-spa-charcoal">{{ $booking->service->name }}</div>
                                            <div class="text-xs text-spa-gray opacity-80">{{ $booking->service->duration_minutes }} mins</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-spa-charcoal">{{ $booking->therapist->user->name }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <x-ui.status-badge :status="$booking->status" />
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('customer.bookings.show', $booking) }}" class="text-[#2c3e38] hover:text-[#1f2d28]">View Details</a>
                                        </td>
                                    </tr>
                                @empty
                                    <x-ui.empty-state 
                                        colspan="5"
                                        icon="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                                        title="No appointments yet"
                                        description="You have not booked any appointments. Ready to relax?"
                                        actionUrl="{{ route('customer.bookings.create') }}"
                                        actionText="Book your first session"
                                    />
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    @if($bookings->hasPages())
                        <div class="mt-4">
                            {{ $bookings->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-customer-layout>

