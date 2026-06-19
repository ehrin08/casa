<input type="hidden" name="_modal_id" value="{{ $modalId ?? '' }}">

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- Therapist Dropdown -->
    <div class="md:col-span-2">
        <x-input-label for="therapist_id" value="Therapist *" />
        <select id="therapist_id" name="therapist_id" class="mt-1 block w-full border-spa-wood focus:border-[#2c3e38] focus:ring-[#2c3e38] rounded-md shadow-sm" required autofocus>
            <option value="">Select Therapist</option>
            @foreach($therapists as $t)
                <option value="{{ $t->id }}" {{ old('therapist_id', $availability->therapist_id ?? '') == $t->id ? 'selected' : '' }}>{{ $t->user->name }} ({{ $t->specialization }})</option>
            @endforeach
        </select>
        <x-input-error class="mt-2" :messages="$errors->get('therapist_id')" />
    </div>

    <!-- Date -->
    <div>
        <x-input-label for="availability_date" value="Date *" />
        <x-text-input id="availability_date" name="availability_date" type="date" class="mt-1 block w-full" value="{{ old('availability_date', isset($availability) && $availability->availability_date ? $availability->availability_date->format('Y-m-d') : '') }}" required />
        <x-input-error class="mt-2" :messages="$errors->get('availability_date')" />
    </div>

    <!-- Status -->
    <div>
        <x-input-label for="status" value="Status *" />
        <select id="status" name="status" class="mt-1 block w-full border-spa-wood focus:border-[#2c3e38] focus:ring-[#2c3e38] rounded-md shadow-sm" required>
            <option value="available" {{ old('status', $availability->status ?? 'available') == 'available' ? 'selected' : '' }}>Available</option>
            <option value="unavailable" {{ old('status', $availability->status ?? '') == 'unavailable' ? 'selected' : '' }}>Unavailable</option>
            <option value="on_leave" {{ old('status', $availability->status ?? '') == 'on_leave' ? 'selected' : '' }}>On Leave</option>
        </select>
        <x-input-error class="mt-2" :messages="$errors->get('status')" />
        <p class="text-xs text-spa-gray opacity-80 mt-1">Use "Available" for working days. "Unavailable" for days off.</p>
    </div>

    <div class="md:col-span-2 mt-4 pt-4 border-t border-spa-beige">
        <h4 class="text-sm font-medium text-spa-charcoal mb-4">Working Hours (Required if Available)</h4>
    </div>

    <!-- Start Time -->
    <div>
        <x-input-label for="start_time" value="Start Time" />
        <x-text-input id="start_time" name="start_time" type="time" class="mt-1 block w-full" value="{{ old('start_time', isset($availability) && $availability->start_time ? Carbon\Carbon::parse($availability->start_time)->format('H:i') : '') }}" />
        <x-input-error class="mt-2" :messages="$errors->get('start_time')" />
    </div>

    <!-- End Time -->
    <div>
        <x-input-label for="end_time" value="End Time" />
        <x-text-input id="end_time" name="end_time" type="time" class="mt-1 block w-full" value="{{ old('end_time', isset($availability) && $availability->end_time ? Carbon\Carbon::parse($availability->end_time)->format('H:i') : '') }}" />
        <x-input-error class="mt-2" :messages="$errors->get('end_time')" />
    </div>

    <div class="md:col-span-2 mt-4 pt-4 border-t border-spa-beige">
        <h4 class="text-sm font-medium text-spa-charcoal mb-4">Break Hours (Optional)</h4>
    </div>

    <!-- Break Start -->
    <div>
        <x-input-label for="break_start_time" value="Break Start Time" />
        <x-text-input id="break_start_time" name="break_start_time" type="time" class="mt-1 block w-full" value="{{ old('break_start_time', isset($availability) && $availability->break_start_time ? Carbon\Carbon::parse($availability->break_start_time)->format('H:i') : '') }}" />
        <x-input-error class="mt-2" :messages="$errors->get('break_start_time')" />
    </div>

    <!-- Break End -->
    <div>
        <x-input-label for="break_end_time" value="Break End Time" />
        <x-text-input id="break_end_time" name="break_end_time" type="time" class="mt-1 block w-full" value="{{ old('break_end_time', isset($availability) && $availability->break_end_time ? Carbon\Carbon::parse($availability->break_end_time)->format('H:i') : '') }}" />
        <x-input-error class="mt-2" :messages="$errors->get('break_end_time')" />
    </div>

    <!-- Notes -->
    <div class="md:col-span-2 mt-4 pt-4 border-t border-spa-beige">
        <x-input-label for="notes" value="Notes" />
        <textarea id="notes" name="notes" rows="3" class="mt-1 block w-full border-spa-wood focus:border-[#2c3e38] focus:ring-[#2c3e38] rounded-md shadow-sm">{{ old('notes', $availability->notes ?? '') }}</textarea>
        <x-input-error class="mt-2" :messages="$errors->get('notes')" />
    </div>
</div>
