<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Our Services') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-8 text-center">
                <h3 class="text-3xl font-serif text-gray-800 mb-2">Spa Menu</h3>
                <p class="text-gray-500">Discover our range of relaxing and rejuvenating treatments.</p>
            </div>

            @forelse($servicesByCategory as $category => $services)
                <div class="mb-12">
                    <h4 class="text-xl font-medium text-[#2c3e38] mb-6 pb-2 border-b-2 border-[#e8dbce] inline-block">{{ $category }}</h4>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($services as $service)
                            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col h-full hover:shadow-md transition-shadow">
                                <div class="flex justify-between items-start mb-4">
                                    <h5 class="text-lg font-semibold text-gray-800">{{ $service->name }}</h5>
                                    <span class="text-[#2c3e38] font-bold">${{ number_format($service->price, 2) }}</span>
                                </div>
                                
                                <div class="text-sm text-gray-500 mb-4 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    {{ $service->duration_minutes }} mins
                                </div>

                                <div class="text-gray-600 text-sm mb-6 flex-grow">
                                    {{ $service->description ?? 'No description available.' }}
                                </div>

                                <div class="mt-auto">
                                    <button disabled class="w-full text-center px-4 py-2 bg-gray-100 text-gray-400 cursor-not-allowed rounded-md font-medium text-sm transition-colors uppercase tracking-wide">
                                        Book Soon
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @empty
                <div class="text-center py-12 bg-white rounded-2xl shadow-sm border border-gray-100">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No services available</h3>
                    <p class="mt-1 text-sm text-gray-500">Please check back later for our spa menu.</p>
                </div>
            @endforelse

        </div>
    </div>
</x-app-layout>
