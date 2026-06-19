<x-manager-layout>
    <x-slot name="header">
        Create Service
    </x-slot>

    <div class="mb-6 flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-spa-charcoal">Add New Service</h2>
            <p class="text-sm text-spa-gray opacity-80 mt-1">Create a new spa service with pricing and duration details.</p>
        </div>
        <a href="{{ route('manager.services.index') }}" class="text-[#2c3e38] hover:text-[#1f2d28] font-medium text-sm">
            &larr; Back to Services
        </a>
    </div>

    <div class="bg-spa-white rounded-xl shadow-sm border border-spa-beige overflow-hidden">
        <form action="{{ route('manager.services.store') }}" method="POST" class="p-6 md:p-8">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Name -->
                <div class="md:col-span-2">
                    <x-input-label for="name" value="Service Name *" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" required autofocus />
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>

                <!-- Category -->
                <div>
                    <x-input-label for="category" value="Category *" />
                    <select id="category" name="category" class="mt-1 block w-full border-spa-wood focus:border-[#2c3e38] focus:ring-[#2c3e38] rounded-md shadow-sm" required>
                        <option value="">Select Category</option>
                        <option value="Massage" {{ old('category') == 'Massage' ? 'selected' : '' }}>Massage</option>
                        <option value="Nails" {{ old('category') == 'Nails' ? 'selected' : '' }}>Nails</option>
                        <option value="Facial" {{ old('category') == 'Facial' ? 'selected' : '' }}>Facial</option>
                        <option value="Body Treatment" {{ old('category') == 'Body Treatment' ? 'selected' : '' }}>Body Treatment</option>
                        <option value="Package" {{ old('category') == 'Package' ? 'selected' : '' }}>Package</option>
                    </select>
                    <x-input-error class="mt-2" :messages="$errors->get('category')" />
                </div>

                <!-- Status -->
                <div>
                    <x-input-label for="status" value="Status *" />
                    <select id="status" name="status" class="mt-1 block w-full border-spa-wood focus:border-[#2c3e38] focus:ring-[#2c3e38] rounded-md shadow-sm" required>
                        <option value="available" {{ old('status', 'available') == 'available' ? 'selected' : '' }}>Available</option>
                        <option value="unavailable" {{ old('status') == 'unavailable' ? 'selected' : '' }}>Unavailable</option>
                    </select>
                    <x-input-error class="mt-2" :messages="$errors->get('status')" />
                </div>

                <!-- Price -->
                <div>
                    <x-input-label for="price" value="Price *" />
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-spa-gray opacity-80 sm:text-sm">$</span>
                        </div>
                        <input type="number" step="0.01" min="0" name="price" id="price" class="block w-full pl-7 border-spa-wood focus:border-[#2c3e38] focus:ring-[#2c3e38] rounded-md shadow-sm" value="{{ old('price') }}" required>
                    </div>
                    <x-input-error class="mt-2" :messages="$errors->get('price')" />
                </div>

                <!-- Duration -->
                <div>
                    <x-input-label for="duration_minutes" value="Duration (Minutes) *" />
                    <x-text-input id="duration_minutes" name="duration_minutes" type="number" min="1" class="mt-1 block w-full" :value="old('duration_minutes')" required />
                    <x-input-error class="mt-2" :messages="$errors->get('duration_minutes')" />
                </div>

                <!-- Commission Rate -->
                <div>
                    <x-input-label for="commission_rate" value="Commission Rate (%) *" />
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <input type="number" step="0.01" min="0" max="100" name="commission_rate" id="commission_rate" class="block w-full pr-8 border-spa-wood focus:border-[#2c3e38] focus:ring-[#2c3e38] rounded-md shadow-sm" value="{{ old('commission_rate', '22.00') }}" required>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <span class="text-spa-gray opacity-80 sm:text-sm">%</span>
                        </div>
                    </div>
                    <x-input-error class="mt-2" :messages="$errors->get('commission_rate')" />
                    <p class="text-xs text-spa-gray opacity-80 mt-1">Default is 22.00%.</p>
                </div>

                <!-- Empty space for grid alignment -->
                <div class="hidden md:block"></div>

                <!-- Description -->
                <div class="md:col-span-2">
                    <x-input-label for="description" value="Description" />
                    <textarea id="description" name="description" rows="4" class="mt-1 block w-full border-spa-wood focus:border-[#2c3e38] focus:ring-[#2c3e38] rounded-md shadow-sm">{{ old('description') }}</textarea>
                    <x-input-error class="mt-2" :messages="$errors->get('description')" />
                </div>
            </div>

            <div class="mt-8 flex justify-end">
                <a href="{{ route('manager.services.index') }}" class="px-4 py-2 bg-spa-white border border-spa-wood rounded-md font-semibold text-xs text-spa-charcoal opacity-90 uppercase tracking-widest shadow-sm hover:bg-spa-beige focus:outline-none focus:ring-2 focus:ring-[#2c3e38] focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150 mr-3">
                    Cancel
                </a>
                <x-ui.submit-button label="Create Service" />
            </div>
        </form>
    </div>
</x-manager-layout>
