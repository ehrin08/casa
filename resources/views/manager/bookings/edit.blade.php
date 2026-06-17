<x-manager-layout>
    <x-slot name="header">
        Edit Booking
    </x-slot>

    <div class="mb-6 flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Edit Booking: {{ $booking->booking_reference }}</h2>
            <p class="text-sm text-gray-500 mt-1">Update appointment details or change booking status.</p>
        </div>
        <a href="{{ route('manager.bookings.show', $booking) }}" class="text-[#2c3e38] hover:text-[#1f2d28] font-medium text-sm">
            &larr; Back to Details
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <form action="{{ route('manager.bookings.update', $booking) }}" method="POST" class="p-6 md:p-8">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Appointment Details -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4 pb-2 border-b border-gray-100">Appointment Details</h3>
                    
                    <div class="space-y-5">
                        <!-- Status -->
                        <div>
                            <x-input-label for="status" value="Booking Status *" />
                            <select id="status" name="status" class="mt-1 block w-full border-gray-300 focus:border-[#2c3e38] focus:ring-[#2c3e38] rounded-md shadow-sm" required>
                                <option value="booked" {{ old('status', $booking->status) == 'booked' ? 'selected' : '' }}>Booked</option>
                                <option value="completed" {{ old('status', $booking->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ old('status', $booking->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('status')" />
                        </div>

                        <!-- Service Dropdown -->
                        <div>
                            <x-input-label for="service_id" value="Service *" />
                            <select id="service_id" name="service_id" class="mt-1 block w-full border-gray-300 focus:border-[#2c3e38] focus:ring-[#2c3e38] rounded-md shadow-sm" required>
                                @foreach($services as $s)
                                    <option value="{{ $s->id }}" {{ old('service_id', $booking->service_id) == $s->id ? 'selected' : '' }}>{{ $s->name }} ({{ $s->duration_minutes }} mins)</option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('service_id')" />
                        </div>

                        <!-- Therapist Dropdown -->
                        <div>
                            <x-input-label for="therapist_id" value="Therapist *" />
                            <select id="therapist_id" name="therapist_id" class="mt-1 block w-full border-gray-300 focus:border-[#2c3e38] focus:ring-[#2c3e38] rounded-md shadow-sm" required>
                                @foreach($therapists as $t)
                                    <option value="{{ $t->id }}" {{ old('therapist_id', $booking->therapist_id) == $t->id ? 'selected' : '' }}>{{ $t->user->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('therapist_id')" />
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <!-- Date -->
                            <div>
                                <x-input-label for="appointment_date" value="Date *" />
                                <x-text-input id="appointment_date" name="appointment_date" type="date" class="mt-1 block w-full" :value="old('appointment_date', $booking->appointment_date->format('Y-m-d'))" required />
                                <x-input-error class="mt-2" :messages="$errors->get('appointment_date')" />
                            </div>

                            <!-- Time -->
                            <div>
                                <x-input-label for="start_time" value="Start Time *" />
                                <x-text-input id="start_time" name="start_time" type="time" class="mt-1 block w-full" :value="old('start_time', \Carbon\Carbon::parse($booking->start_time)->format('H:i'))" required />
                                <x-input-error class="mt-2" :messages="$errors->get('start_time')" />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Customer Details -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4 pb-2 border-b border-gray-100">Customer Details</h3>
                    
                    <div class="space-y-5">
                        <!-- Name -->
                        <div>
                            <x-input-label for="customer_name" value="Customer Full Name *" />
                            <x-text-input id="customer_name" name="customer_name" type="text" class="mt-1 block w-full" :value="old('customer_name', $booking->customer_name)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('customer_name')" />
                        </div>

                        <!-- Email -->
                        <div>
                            <x-input-label for="customer_email" value="Customer Email" />
                            <x-text-input id="customer_email" name="customer_email" type="email" class="mt-1 block w-full" :value="old('customer_email', $booking->customer_email)" />
                            <x-input-error class="mt-2" :messages="$errors->get('customer_email')" />
                        </div>

                        <!-- Phone -->
                        <div>
                            <x-input-label for="customer_phone" value="Customer Phone" />
                            <x-text-input id="customer_phone" name="customer_phone" type="text" class="mt-1 block w-full" :value="old('customer_phone', $booking->customer_phone)" />
                            <x-input-error class="mt-2" :messages="$errors->get('customer_phone')" />
                        </div>

                        <!-- Notes -->
                        <div>
                            <x-input-label for="notes" value="Notes" />
                            <textarea id="notes" name="notes" rows="3" class="mt-1 block w-full border-gray-300 focus:border-[#2c3e38] focus:ring-[#2c3e38] rounded-md shadow-sm">{{ old('notes', $booking->notes) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('notes')" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-8 flex justify-end">
                <a href="{{ route('manager.bookings.show', $booking) }}" class="px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-[#2c3e38] focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150 mr-3">
                    Cancel
                </a>
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-[#2c3e38] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-[#1f2d28] focus:bg-[#1f2d28] active:bg-[#1f2d28] focus:outline-none focus:ring-2 focus:ring-[#2c3e38] focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</x-manager-layout>
