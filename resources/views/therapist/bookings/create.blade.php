<x-therapist-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Walk-in Booking') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-4">
                <a href="{{ route('therapist.bookings.index') }}" class="text-[#2c3e38] hover:text-[#1f2d28] font-medium text-sm">
                    &larr; Back to My Bookings
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <form action="{{ route('therapist.bookings.store') }}" method="POST" class="p-6 md:p-8">
                    @csrf

                    <h3 class="text-lg font-medium text-gray-900 mb-4 pb-2 border-b border-gray-100">Appointment Details</h3>
                    
                    <div class="space-y-5 mb-8">
                        <div>
                            <x-input-label for="service_id" value="Service *" />
                            <select id="service_id" name="service_id" class="mt-1 block w-full border-gray-300 focus:border-[#2c3e38] focus:ring-[#2c3e38] rounded-md shadow-sm" required autofocus>
                                <option value="">Select Service</option>
                                @foreach($services as $s)
                                    <option value="{{ $s->id }}" {{ old('service_id') == $s->id ? 'selected' : '' }}>{{ $s->name }} ({{ $s->duration_minutes }} mins) - ₱{{ number_format($s->price, 2) }}</option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('service_id')" />
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="appointment_date" value="Date *" />
                                <x-text-input id="appointment_date" name="appointment_date" type="date" class="mt-1 block w-full" :value="old('appointment_date')" required min="{{ date('Y-m-d') }}" />
                                <x-input-error class="mt-2" :messages="$errors->get('appointment_date')" />
                            </div>

                            <div>
                                <x-input-label for="start_time" value="Start Time *" />
                                <x-text-input id="start_time" name="start_time" type="time" class="mt-1 block w-full" :value="old('start_time')" required />
                                <x-input-error class="mt-2" :messages="$errors->get('start_time')" />
                            </div>
                        </div>
                        <p class="text-xs text-gray-500">Note: This booking will automatically be assigned to you. The system will check your schedule before saving.</p>
                    </div>

                    <h3 class="text-lg font-medium text-gray-900 mb-4 pb-2 border-b border-gray-100">Customer Details</h3>
                    
                    <div class="space-y-5">
                        <div>
                            <x-input-label for="customer_name" value="Customer Name *" />
                            <x-text-input id="customer_name" name="customer_name" type="text" class="mt-1 block w-full" :value="old('customer_name')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('customer_name')" />
                        </div>

                        <div>
                            <x-input-label for="customer_phone" value="Customer Phone" />
                            <x-text-input id="customer_phone" name="customer_phone" type="text" class="mt-1 block w-full" :value="old('customer_phone')" />
                            <x-input-error class="mt-2" :messages="$errors->get('customer_phone')" />
                        </div>

                        <div>
                            <x-input-label for="notes" value="Notes" />
                            <textarea id="notes" name="notes" rows="3" class="mt-1 block w-full border-gray-300 focus:border-[#2c3e38] focus:ring-[#2c3e38] rounded-md shadow-sm">{{ old('notes') }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('notes')" />
                        </div>
                    </div>

                    <div class="mt-8 pt-6 border-t border-gray-200 flex justify-end">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-[#2c3e38] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-[#1f2d28] transition ease-in-out duration-150 shadow-sm">
                            Create Walk-in Booking
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-therapist-layout>

