<x-manager-layout>
    <x-slot name="header">
        Add Booking
    </x-slot>

    <div class="mb-6 flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-spa-charcoal">Add Walk-in Booking</h2>
            <p class="text-sm text-spa-gray opacity-80 mt-1">Create an appointment for a customer. Time and availability are verified upon submission.</p>
        </div>
        <a href="{{ route('manager.bookings.index') }}" class="text-[#2c3e38] hover:text-[#1f2d28] font-medium text-sm">
            &larr; Back to Bookings
        </a>
    </div>

    <div class="bg-spa-white rounded-xl shadow-sm border border-spa-beige overflow-hidden">
        <form action="{{ route('manager.bookings.store') }}" method="POST" class="p-6 md:p-8">
            @csrf

            @include('manager.bookings._form')

            <div class="mt-8 pt-6 border-t border-spa-beige flex items-center justify-between">
                <div class="text-sm text-spa-gray opacity-80">
                    <span class="font-medium text-spa-charcoal">Payment Notice:</span> Over-the-counter cash will be recorded instantly upon creation.
                </div>
                <div class="flex">
                    <a href="{{ route('manager.bookings.index') }}" class="px-4 py-2 bg-spa-white border border-spa-wood rounded-md font-semibold text-xs text-spa-charcoal opacity-90 uppercase tracking-widest shadow-sm hover:bg-spa-beige focus:outline-none focus:ring-2 focus:ring-[#2c3e38] focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150 mr-3">
                        Cancel
                    </a>
                    <x-ui.submit-button label="Confirm Booking" />
                </div>
            </div>
        </form>
    </div>
</x-manager-layout>
