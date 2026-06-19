<input type="hidden" name="_modal_id" value="{{ $modalId ?? '' }}">

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- Name -->
    <div class="md:col-span-2">
        <x-input-label for="name" value="Full Name *" />
        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" value="{{ old('name', $therapist->user->name ?? '') }}" required autofocus />
        <x-input-error class="mt-2" :messages="$errors->get('name')" />
    </div>

    <!-- Email -->
    <div>
        <x-input-label for="email" value="Email Address *" />
        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" value="{{ old('email', $therapist->user->email ?? '') }}" required />
        <x-input-error class="mt-2" :messages="$errors->get('email')" />
        @if(!isset($therapist))
            <p class="text-xs text-spa-gray opacity-80 mt-1">Will be used for the therapist's login account.</p>
        @endif
    </div>

    <!-- Phone -->
    <div>
        <x-input-label for="phone" value="Phone Number" />
        <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" value="{{ old('phone', $therapist->user->phone ?? '') }}" />
        <x-input-error class="mt-2" :messages="$errors->get('phone')" />
    </div>

    <!-- Specialization -->
    <div>
        <x-input-label for="specialization" value="Specialization *" />
        <x-text-input id="specialization" name="specialization" type="text" class="mt-1 block w-full" value="{{ old('specialization', $therapist->specialization ?? '') }}" placeholder="e.g. Swedish Massage" required />
        <x-input-error class="mt-2" :messages="$errors->get('specialization')" />
    </div>

    <!-- Status -->
    <div>
        <x-input-label for="status" value="Status *" />
        <select id="status" name="status" class="mt-1 block w-full border-spa-wood focus:border-[#2c3e38] focus:ring-[#2c3e38] rounded-md shadow-sm" required>
            <option value="active" {{ old('status', $therapist->status ?? 'active') == 'active' ? 'selected' : '' }}>Active</option>
            <option value="inactive" {{ old('status', $therapist->status ?? '') == 'inactive' ? 'selected' : '' }}>Inactive</option>
            <option value="on_leave" {{ old('status', $therapist->status ?? '') == 'on_leave' ? 'selected' : '' }}>On Leave</option>
        </select>
        <x-input-error class="mt-2" :messages="$errors->get('status')" />
    </div>
</div>
