<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Therapist Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        @php
            $therapist = auth()->user()->therapist;
            $upcomingBookings = 0;
            $unpaidCommission = 0;

            if ($therapist) {
                $upcomingBookings = App\Models\Booking::where('therapist_id', $therapist->id)
                                        ->where('status', 'booked')
                                        ->count();
                $unpaidCommission = App\Models\Commission::where('therapist_id', $therapist->id)
                                        ->where('status', 'unpaid')
                                        ->sum('commission_amount');
            }
        @endphp

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <!-- Dashboard Cards -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 flex flex-col justify-between">
                    <div>
                        <div class="text-gray-500 text-sm font-medium">My Appointments</div>
                        <div class="mt-2 text-3xl font-bold text-gray-900">{{ $upcomingBookings }} Upcoming</div>
                    </div>
                    <a href="{{ route('therapist.bookings.index') }}" class="mt-4 text-[#2c3e38] font-semibold hover:underline">View Schedule &rarr;</a>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 flex flex-col justify-between border-l-4 border-yellow-400">
                    <div>
                        <div class="text-gray-500 text-sm font-medium">Unpaid Earnings</div>
                        <div class="mt-2 text-3xl font-bold text-gray-900">₱{{ number_format($unpaidCommission, 2) }}</div>
                    </div>
                    <a href="{{ route('therapist.commissions.index') }}" class="mt-4 text-[#2c3e38] font-semibold hover:underline">View Commissions &rarr;</a>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 flex flex-col justify-between">
                    <div>
                        <div class="text-gray-500 text-sm font-medium">My Availability</div>
                        <div class="mt-2 text-xl font-bold text-gray-900 cursor-pointer">Manage Schedule</div>
                    </div>
                    <a href="{{ route('availability.index') }}" class="mt-4 text-[#2c3e38] font-semibold hover:underline">Update Now &rarr;</a>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("Welcome back, Therapist!") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
