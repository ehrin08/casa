<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Customer Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 flex flex-col justify-between">
                    <div>
                        <div class="text-gray-500 text-sm font-medium">Book Appointment</div>
                        <div class="mt-2 text-xl font-bold text-gray-900">Schedule a Visit</div>
                    </div>
                    <a href="{{ route('customer.bookings.create') }}" class="mt-4 text-[#2c3e38] font-semibold hover:underline">Book Now &rarr;</a>
                </div>
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 flex flex-col justify-between">
                    <div>
                        <div class="text-gray-500 text-sm font-medium">My Appointments</div>
                        <div class="mt-2 text-3xl font-bold text-gray-900">{{ auth()->user()->bookings()->where('status', 'booked')->count() }} Upcoming</div>
                    </div>
                    <a href="{{ route('customer.bookings.index') }}" class="mt-4 text-[#2c3e38] font-semibold hover:underline">View All &rarr;</a>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 flex flex-col justify-between">
                    <div>
                        <div class="text-gray-500 text-sm font-medium">Payment History</div>
                        <div class="mt-2 text-3xl font-bold text-gray-900">{{ auth()->user()->transactions()->count() }} Receipts</div>
                    </div>
                    <a href="{{ route('transactions.index') }}" class="mt-4 text-[#2c3e38] font-semibold hover:underline">View History &rarr;</a>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("Welcome back, Customer!") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
