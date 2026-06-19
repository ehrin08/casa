<x-manager-layout>
    <x-slot name="header">
        Appointment Bookings
    </x-slot>

    <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h2 class="text-2xl font-bold text-spa-charcoal">Appointment Bookings</h2>
            <p class="text-sm text-spa-gray opacity-80 mt-1">Manage customer appointments, therapist assignment, and cash booking records.</p>
        </div>
        <button type="button" x-data="" x-on:click="$dispatch('open-modal', 'create-booking')" class="inline-flex items-center px-4 py-2 bg-[#2c3e38] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-[#1f2d28] focus:bg-[#1f2d28] active:bg-[#1f2d28] focus:outline-none focus:ring-2 focus:ring-[#2c3e38] focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            Add Booking
        </button>
    </div>



    <div class="bg-spa-white rounded-xl shadow-sm border border-spa-beige overflow-hidden mb-6">
        <div class="p-6 border-b border-spa-beige bg-gray-50/50">
            <form method="GET" action="{{ route('manager.bookings.index') }}" class="grid grid-cols-1 md:grid-cols-6 gap-4">
                <div class="md:col-span-2">
                    <label for="search" class="sr-only">Search</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-spa-gray opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <input type="text" name="search" id="search" value="{{ request('search') }}" class="block w-full pl-10 pr-3 py-2 border border-spa-wood rounded-md leading-5 bg-spa-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-[#2c3e38] focus:border-[#2c3e38] sm:text-sm transition duration-150 ease-in-out" placeholder="Search ref, customer, service...">
                    </div>
                </div>
                <div>
                    <label for="date" class="sr-only">Date</label>
                    <input type="date" name="date" id="date" value="{{ request('date') }}" class="block w-full py-2 px-3 border border-spa-wood rounded-md shadow-sm focus:outline-none focus:ring-[#2c3e38] focus:border-[#2c3e38] sm:text-sm text-spa-charcoal opacity-90">
                </div>
                <div>
                    <label for="therapist_id" class="sr-only">Therapist</label>
                    <select name="therapist_id" id="therapist_id" class="block w-full py-2 pl-3 pr-10 border border-spa-wood bg-spa-white rounded-md shadow-sm focus:outline-none focus:ring-[#2c3e38] focus:border-[#2c3e38] sm:text-sm">
                        <option value="">All Therapists</option>
                        @foreach($therapists as $t)
                            <option value="{{ $t->id }}" {{ request('therapist_id') == $t->id ? 'selected' : '' }}>{{ $t->user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="status" class="sr-only">Status</label>
                    <select name="status" id="status" class="block w-full py-2 pl-3 pr-10 border border-spa-wood bg-spa-white rounded-md shadow-sm focus:outline-none focus:ring-[#2c3e38] focus:border-[#2c3e38] sm:text-sm">
                        <option value="">All Statuses</option>
                        <option value="booked" {{ request('status') == 'booked' ? 'selected' : '' }}>Booked</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="flex-1 px-4 py-2 border border-spa-wood rounded-md shadow-sm text-sm font-medium text-spa-charcoal opacity-90 bg-spa-white hover:bg-spa-beige focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#2c3e38]">
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
                <thead class="bg-spa-cream">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-spa-gray opacity-80 uppercase tracking-wider">Reference / Customer</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-spa-gray opacity-80 uppercase tracking-wider">Date & Time</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-spa-gray opacity-80 uppercase tracking-wider">Service / Therapist</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-spa-gray opacity-80 uppercase tracking-wider">Status / Payment</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-spa-gray opacity-80 uppercase tracking-wider">Amount</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-spa-gray opacity-80 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-spa-white divide-y divide-gray-200">
                    @forelse ($bookings as $booking)
                        <tr class="hover:bg-spa-beige transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-xs font-mono text-spa-gray opacity-80 mb-1">{{ $booking->booking_reference }}</div>
                                <div class="text-sm font-medium text-spa-charcoal">{{ $booking->customer_name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-spa-charcoal">{{ $booking->appointment_date->format('M d, Y') }}</div>
                                <div class="text-sm text-spa-gray opacity-80">{{ \Carbon\Carbon::parse($booking->start_time)->format('g:i A') }} - {{ \Carbon\Carbon::parse($booking->end_time)->format('g:i A') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-spa-charcoal">{{ $booking->service->name }}</div>
                                <div class="text-sm text-spa-gray opacity-80">{{ $booking->therapist->user->name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="mb-1">
                                    <x-ui.status-badge :status="$booking->status" />
                                </div>
                                <div>
                                    <x-ui.status-badge :status="$booking->payment_status" />
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <div class="text-sm font-medium text-spa-charcoal">₱{{ number_format($booking->amount_paid, 2) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('manager.bookings.show', $booking) }}" class="text-spa-gold hover:text-[#9e8360] mr-3">View</a>
                                <button type="button" x-data="" x-on:click="$dispatch('open-modal', 'edit-booking-{{ $booking->id }}')" class="text-[#2c3e38] hover:text-[#1f2d28] mr-3">Edit</button>

                                <x-modal name="edit-booking-{{ $booking->id }}" :show="$errors->any() && old('_modal_id') === 'edit-booking-'.$booking->id" maxWidth="3xl">
                                    <x-ui.modal-form 
                                        title="Edit Booking: {{ $booking->booking_reference }}" 
                                        subtitle="Update appointment details or change booking status." 
                                        action="{{ route('manager.bookings.update', $booking) }}" 
                                        method="PUT"
                                    >
                                        @include('manager.bookings._form', ['modalId' => 'edit-booking-'.$booking->id, 'booking' => $booking])
                                        <x-slot name="actions">
                                            <x-ui.submit-button label="Save Changes" />
                                        </x-slot>
                                    </x-ui.modal-form>
                                </x-modal>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 whitespace-nowrap">
                                <x-ui.empty-state 
                                    icon="calendar" 
                                    title="No bookings found" 
                                    description="No appointments match your criteria." 
                                />
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($bookings->hasPages())
            <div class="px-6 py-4 border-t border-spa-beige">
                {{ $bookings->links() }}
            </div>
        @endif
    </div>

    <x-modal name="create-booking" :show="$errors->any() && old('_modal_id') === 'create-booking'" maxWidth="3xl">
        <x-ui.modal-form 
            title="Add Walk-in Booking" 
            subtitle="Create an appointment for a customer. Time and availability are verified upon submission." 
            action="{{ route('manager.bookings.store') }}" 
            method="POST"
        >
            @include('manager.bookings._form', ['modalId' => 'create-booking', 'booking' => new \App\Models\Booking()])
            <x-slot name="actions">
                <x-ui.submit-button label="Confirm Booking" />
            </x-slot>
        </x-ui.modal-form>
    </x-modal>
</x-manager-layout>
