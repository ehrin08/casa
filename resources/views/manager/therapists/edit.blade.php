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

            @include('manager.therapists._form')

            <div class="mt-8 flex justify-end">
                <a href="{{ route('manager.therapists.index') }}" class="px-4 py-2 bg-spa-white border border-spa-wood rounded-md font-semibold text-xs text-spa-charcoal opacity-90 uppercase tracking-widest shadow-sm hover:bg-spa-beige focus:outline-none focus:ring-2 focus:ring-[#2c3e38] focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150 mr-3">
                    Cancel
                </a>
                <x-ui.submit-button label="Save Changes" />
            </div>
        </form>
    </div>
</x-manager-layout>
