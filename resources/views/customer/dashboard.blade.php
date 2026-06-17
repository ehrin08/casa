<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Customer Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <!-- Placeholder Cards -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-500 text-sm font-medium">Book Appointment</div>
                    <div class="mt-2 text-xl font-bold text-indigo-600 cursor-pointer">Book Now &rarr;</div>
                </div>
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-500 text-sm font-medium">My Appointments</div>
                    <div class="mt-2 text-3xl font-bold text-gray-900">2 Upcoming</div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-500 text-sm font-medium">Available Promotions</div>
                    <div class="mt-2 text-3xl font-bold text-gray-900">1 Special Offer</div>
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
