<x-manager-layout>
    <x-slot name="header">
        Add Therapist
    </x-slot>

    <div class="mb-6 flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-spa-charcoal">Add New Therapist</h2>
            <p class="text-sm text-spa-gray opacity-80 mt-1">Create a therapist profile. A user account will be automatically created with a default password.</p>
        </div>
        <a href="{{ route('manager.therapists.index') }}" class="text-[#2c3e38] hover:text-[#1f2d28] font-medium text-sm">
            &larr; Back to Therapists
        </a>
    </div>

    <div class="bg-spa-white rounded-xl shadow-sm border border-spa-beige overflow-hidden">
        <form action="{{ route('manager.therapists.store') }}" method="POST" class="p-6 md:p-8">
            @csrf

            @include('manager.therapists._form')

            <div class="mt-8 flex justify-end">
                <a href="{{ route('manager.therapists.index') }}" class="px-4 py-2 bg-spa-white border border-spa-wood rounded-md font-semibold text-xs text-spa-charcoal opacity-90 uppercase tracking-widest shadow-sm hover:bg-spa-beige focus:outline-none focus:ring-2 focus:ring-[#2c3e38] focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150 mr-3">
                    Cancel
                </a>
                <x-ui.submit-button label="Create Therapist" />
            </div>
        </form>
    </div>
</x-manager-layout>
