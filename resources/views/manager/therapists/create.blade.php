<x-manager-layout>
    <x-slot name="header">
        Add Therapist
    </x-slot>

    <div class="mb-6 flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Add New Therapist</h2>
            <p class="text-sm text-gray-500 mt-1">Create a therapist profile. A user account will be automatically created with a default password.</p>
        </div>
        <a href="{{ route('manager.therapists.index') }}" class="text-[#2c3e38] hover:text-[#1f2d28] font-medium text-sm">
            &larr; Back to Therapists
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <form action="{{ route('manager.therapists.store') }}" method="POST" class="p-6 md:p-8">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Name -->
                <div class="md:col-span-2">
                    <x-input-label for="name" value="Full Name *" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" required autofocus />
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>

                <!-- Email -->
                <div>
                    <x-input-label for="email" value="Email Address *" />
                    <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email')" required />
                    <x-input-error class="mt-2" :messages="$errors->get('email')" />
                    <p class="text-xs text-gray-500 mt-1">Will be used for the therapist's login account.</p>
                </div>

                <!-- Phone -->
                <div>
                    <x-input-label for="phone" value="Phone Number" />
                    <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone')" />
                    <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                </div>

                <!-- Specialization -->
                <div>
                    <x-input-label for="specialization" value="Specialization *" />
                    <x-text-input id="specialization" name="specialization" type="text" class="mt-1 block w-full" :value="old('specialization')" placeholder="e.g. Swedish Massage" required />
                    <x-input-error class="mt-2" :messages="$errors->get('specialization')" />
                </div>

                <!-- Status -->
                <div>
                    <x-input-label for="status" value="Status *" />
                    <select id="status" name="status" class="mt-1 block w-full border-gray-300 focus:border-[#2c3e38] focus:ring-[#2c3e38] rounded-md shadow-sm" required>
                        <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="on_leave" {{ old('status') == 'on_leave' ? 'selected' : '' }}>On Leave</option>
                    </select>
                    <x-input-error class="mt-2" :messages="$errors->get('status')" />
                </div>
            </div>

            <div class="mt-8 flex justify-end">
                <a href="{{ route('manager.therapists.index') }}" class="px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-[#2c3e38] focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150 mr-3">
                    Cancel
                </a>
                <x-ui.submit-button label="Create Therapist" />
            </div>
        </form>
    </div>
</x-manager-layout>
