<x-manager-layout>
    <x-slot name="header">
        Edit Therapist
    </x-slot>

    <div class="mb-6 flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-spa-charcoal">Edit Therapist</h2>
            <p class="text-sm text-spa-gray opacity-80 mt-1">Update profile and contact details for {{ $therapist->user->name }}.</p>
        </div>
        <a href="{{ route('manager.therapists.index') }}" class="text-[#2c3e38] hover:text-[#1f2d28] font-medium text-sm">
            &larr; Back to Therapists
        </a>
    </div>

    <div class="bg-spa-white rounded-xl shadow-sm border border-spa-beige overflow-hidden">
        <form action="{{ route('manager.therapists.update', $therapist) }}" method="POST" class="p-6 md:p-8">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Name -->
                <div class="md:col-span-2">
                    <x-input-label for="name" value="Full Name *" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $therapist->user->name)" required autofocus />
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>

                <!-- Email -->
                <div>
                    <x-input-label for="email" value="Email Address *" />
                    <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $therapist->user->email)" required />
                    <x-input-error class="mt-2" :messages="$errors->get('email')" />
                    <p class="text-xs text-spa-gray opacity-80 mt-1">Changing this will update their login email.</p>
                </div>

                <!-- Phone -->
                <div>
                    <x-input-label for="phone" value="Phone Number" />
                    <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone', $therapist->phone)" />
                    <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                </div>

                <!-- Specialization -->
                <div>
                    <x-input-label for="specialization" value="Specialization *" />
                    <x-text-input id="specialization" name="specialization" type="text" class="mt-1 block w-full" :value="old('specialization', $therapist->specialization)" placeholder="e.g. Swedish Massage" required />
                    <x-input-error class="mt-2" :messages="$errors->get('specialization')" />
                </div>

                <!-- Status -->
                <div>
                    <x-input-label for="status" value="Status *" />
                    <select id="status" name="status" class="mt-1 block w-full border-spa-wood focus:border-[#2c3e38] focus:ring-[#2c3e38] rounded-md shadow-sm" required>
                        <option value="active" {{ old('status', $therapist->status) == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status', $therapist->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="on_leave" {{ old('status', $therapist->status) == 'on_leave' ? 'selected' : '' }}>On Leave</option>
                    </select>
                    <x-input-error class="mt-2" :messages="$errors->get('status')" />
                </div>
            </div>

            <div class="mt-8 flex justify-end">
                <a href="{{ route('manager.therapists.index') }}" class="px-4 py-2 bg-spa-white border border-spa-wood rounded-md font-semibold text-xs text-spa-charcoal opacity-90 uppercase tracking-widest shadow-sm hover:bg-spa-beige focus:outline-none focus:ring-2 focus:ring-[#2c3e38] focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150 mr-3">
                    Cancel
                </a>
                <x-ui.submit-button label="Save Changes" />
            </div>
        </form>
    </div>
</x-manager-layout>
