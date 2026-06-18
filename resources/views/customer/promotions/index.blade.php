<x-customer-layout>
    <x-slot name="header">
        My Promotions
    </x-slot>

    <div class="mb-8">
        <h2 class="text-xl font-bold text-gray-900">Your Rewards Wallet</h2>
        <p class="text-sm text-gray-500 mt-1">You have <span class="font-bold text-indigo-600">{{ $availableCount }}</span> available promotions to use on your next visit.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($promotions as $promo)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex flex-col hover:shadow-md transition-shadow group {{ $promo->status !== 'available' ? 'opacity-75 grayscale-[50%]' : '' }}">
                
                <div class="p-6 flex-1 relative">
                    <!-- Status Badge -->
                    <div class="absolute top-4 right-4">
                        @if($promo->status === 'available')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Available</span>
                        @elseif($promo->status === 'used')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">Used</span>
                        @elseif($promo->status === 'expired')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Expired</span>
                        @endif
                    </div>

                    <div class="w-12 h-12 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path></svg>
                    </div>

                    <h3 class="text-lg font-bold text-gray-900 mb-1">{{ $promo->title }}</h3>
                    <p class="text-sm text-gray-500 mb-4">{{ $promo->description }}</p>

                    <div class="bg-gray-50 rounded-lg p-3 border border-gray-100 border-dashed text-center">
                        <span class="text-xs text-gray-500 uppercase tracking-wider block mb-1">Promo Code</span>
                        <span class="font-mono font-bold text-lg text-gray-900 tracking-widest select-all">{{ $promo->code }}</span>
                    </div>

                    <div class="mt-4 space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Discount:</span>
                            <span class="font-bold text-gray-900">
                                @if($promo->discount_type === 'percentage')
                                    {{ $promo->discount_value }}% Off
                                @elseif($promo->discount_type === 'fixed')
                                    ₱{{ number_format($promo->discount_value, 2) }} Off
                                @else
                                    Free Service
                                @endif
                            </span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Expires:</span>
                            <span class="font-medium text-gray-900">{{ $promo->expires_at ? $promo->expires_at->format('M d, Y') : 'No Expiry' }}</span>
                        </div>
                    </div>
                </div>

                @if($promo->status === 'available')
                    <div class="border-t border-gray-100 bg-gray-50 p-4">
                        <a href="{{ route('customer.bookings.create') }}" class="block w-full text-center px-4 py-2 bg-[#2c3e38] text-white rounded-md font-medium text-sm hover:bg-[#1f2d28] transition-colors">
                            Book Now
                        </a>
                    </div>
                @endif
            </div>
        @empty
            <div class="col-span-1 md:col-span-2 lg:col-span-3 bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7" />
                </svg>
                <h3 class="text-lg font-medium text-gray-900">No Promotions Yet</h3>
                <p class="mt-2 text-sm text-gray-500">Keep booking appointments and our system will automatically reward you with special promotions and discounts based on your loyalty.</p>
                <div class="mt-6">
                    <a href="{{ route('customer.bookings.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md shadow-sm text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none">
                        Book an Appointment
                    </a>
                </div>
            </div>
        @endforelse
    </div>

    @if($promotions->hasPages())
        <div class="mt-8">
            {{ $promotions->links() }}
        </div>
    @endif
</x-customer-layout>
