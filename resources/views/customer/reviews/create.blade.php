<x-customer-layout>
    <x-slot name="header">
        {{ __('Leave a Review') }}
    </x-slot>

    <div class="max-w-3xl mx-auto py-10 sm:px-6 lg:px-8">
        <div class="bg-spa-white rounded-xl shadow-sm border border-spa-beige overflow-hidden">
            <div class="border-b border-spa-beige bg-[#2c3e38] px-6 py-5 text-white">
                <h2 class="text-xl font-bold">How was your experience?</h2>
                <p class="text-sm text-[#e8dbce] mt-1">We value your feedback. Help us improve our services.</p>
            </div>
            
                @include('customer.reviews._form', ['booking' => $booking])

                <div class="flex justify-end pt-4 border-t border-spa-beige">
                    <a href="{{ route('customer.bookings.show', $booking) }}" class="mr-3 inline-flex justify-center py-2 px-4 border border-spa-wood shadow-sm text-sm font-medium rounded-md text-spa-charcoal opacity-90 bg-spa-white hover:bg-spa-beige focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#2c3e38]">
                        Cancel
                    </a>
                    <x-ui.submit-button label="Submit Review" />
                </div>
            </form>
        </div>
    </div>
</x-customer-layout>
