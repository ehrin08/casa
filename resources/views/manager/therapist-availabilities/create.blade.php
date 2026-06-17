<x-manager-layout>
    <x-slot name="header">
        Add Availability
    </x-slot>

    <div class="mb-6 flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Add Therapist Availability</h2>
            <p class="text-sm text-gray-500 mt-1">Schedule date-specific availability, time off, or leave.</p>
        </div>
        <a href="{{ route('manager.therapist-availabilities.index') }}" class="text-[#2c3e38] hover:text-[#1f2d28] font-medium text-sm">
            &larr; Back to Availabilities
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <form action="{{ route('manager.therapist-availabilities.store') }}" method="POST" class="p-6 md:p-8">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Therapist Dropdown -->
                <div class="md:col-span-2">
                    <x-input-label for="therapist_id" value="Therapist *" />
                    <select id="therapist_id" name="therapist_id" class="mt-1 block w-full border-gray-300 focus:border-[#2c3e38] focus:ring-[#2c3e38] rounded-md shadow-sm" required autofocus>
                        <option value="">Select Therapist</option>
                        @foreach($therapists as $t)
                            <option value="{{ $t->id }}" {{ old('therapist_id') == $t->id ? 'selected' : '' }}>{{ $t->user->name }} ({{ $t->specialization }})</option>
                        @endforeach
                    </select>
                    <x-input-error class="mt-2" :messages="$errors->get('therapist_id')" />
                </div>

                <!-- Date -->
                <div>
                    <x-input-label for="availability_date" value="Date *" />
                    <x-text-input id="availability_date" name="availability_date" type="date" class="mt-1 block w-full" :value="old('availability_date')" required />
                    <x-input-error class="mt-2" :messages="$errors->get('availability_date')" />
                </div>

                <!-- Status -->
                <div>
                    <x-input-label for="status" value="Status *" />
                    <select id="status" name="status" class="mt-1 block w-full border-gray-300 focus:border-[#2c3e38] focus:ring-[#2c3e38] rounded-md shadow-sm" required>
                        <option value="available" {{ old('status', 'available') == 'available' ? 'selected' : '' }}>Available</option>
                        <option value="unavailable" {{ old('status') == 'unavailable' ? 'selected' : '' }}>Unavailable</option>
                        <option value="on_leave" {{ old('status') == 'on_leave' ? 'selected' : '' }}>On Leave</option>
                    </select>
                    <x-input-error class="mt-2" :messages="$errors->get('status')" />
                    <p class="text-xs text-gray-500 mt-1">Use "Available" for working days. "Unavailable" for days off.</p>
                </div>

                <div class="md:col-span-2 mt-4 pt-4 border-t border-gray-100">
                    <h4 class="text-sm font-medium text-gray-900 mb-4">Working Hours (Required if Available)</h4>
                </div>

                <!-- Start Time -->
                <div>
                    <x-input-label for="start_time" value="Start Time" />
                    <x-text-input id="start_time" name="start_time" type="time" class="mt-1 block w-full" :value="old('start_time')" />
                    <x-input-error class="mt-2" :messages="$errors->get('start_time')" />
                </div>

                <!-- End Time -->
                <div>
                    <x-input-label for="end_time" value="End Time" />
                    <x-text-input id="end_time" name="end_time" type="time" class="mt-1 block w-full" :value="old('end_time')" />
                    <x-input-error class="mt-2" :messages="$errors->get('end_time')" />
                </div>

                <div class="md:col-span-2 mt-4 pt-4 border-t border-gray-100">
                    <h4 class="text-sm font-medium text-gray-900 mb-4">Break Hours (Optional)</h4>
                </div>

                <!-- Break Start -->
                <div>
                    <x-input-label for="break_start_time" value="Break Start Time" />
                    <x-text-input id="break_start_time" name="break_start_time" type="time" class="mt-1 block w-full" :value="old('break_start_time')" />
                    <x-input-error class="mt-2" :messages="$errors->get('break_start_time')" />
                </div>

                <!-- Break End -->
                <div>
                    <x-input-label for="break_end_time" value="Break End Time" />
                    <x-text-input id="break_end_time" name="break_end_time" type="time" class="mt-1 block w-full" :value="old('break_end_time')" />
                    <x-input-error class="mt-2" :messages="$errors->get('break_end_time')" />
                </div>

                <!-- Notes -->
                <div class="md:col-span-2 mt-4 pt-4 border-t border-gray-100">
                    <x-input-label for="notes" value="Notes" />
                    <textarea id="notes" name="notes" rows="3" class="mt-1 block w-full border-gray-300 focus:border-[#2c3e38] focus:ring-[#2c3e38] rounded-md shadow-sm">{{ old('notes') }}</textarea>
                    <x-input-error class="mt-2" :messages="$errors->get('notes')" />
                </div>
            </div>

            <div class="mt-8 flex justify-end">
                <a href="{{ route('manager.therapist-availabilities.index') }}" class="px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-[#2c3e38] focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150 mr-3">
                    Cancel
                </a>
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-[#2c3e38] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-[#1f2d28] focus:bg-[#1f2d28] active:bg-[#1f2d28] focus:outline-none focus:ring-2 focus:ring-[#2c3e38] focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm">
                    Create Availability
                </button>
            </div>
        </form>
    </div>
</x-manager-layout>
