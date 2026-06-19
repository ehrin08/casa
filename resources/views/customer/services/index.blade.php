<x-customer-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-spa-charcoal leading-tight">
            {{ __('Our Services') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-8 text-center">
                <h3 class="text-3xl font-serif text-spa-charcoal mb-2">Spa Menu</h3>
                <p class="text-spa-gray opacity-80">Discover our range of relaxing and rejuvenating treatments.</p>
            </div>

            @forelse($servicesByCategory as $category => $services)
                <div class="mb-12">
                    <h4 class="text-xl font-medium text-[#2c3e38] mb-6 pb-2 border-b-2 border-[#e8dbce] inline-block">{{ $category }}</h4>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($services as $service)
                            <div class="bg-spa-white rounded-2xl shadow-sm border border-spa-beige p-6 flex flex-col h-full hover:shadow-md transition-shadow">
                                <div class="flex justify-between items-start mb-4">
                                    <h5 class="text-lg font-semibold text-spa-charcoal">{{ $service->name }}</h5>
                                    <span class="text-[#2c3e38] font-bold">${{ number_format($service->price, 2) }}</span>
                                </div>
                                
                                <div class="text-sm text-spa-gray opacity-80 mb-4 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    {{ $service->duration_minutes }} mins
                                </div>

                                <div class="text-spa-gray text-sm mb-6 flex-grow">
                                    {{ $service->description ?? 'No description available.' }}
                                </div>

                                <div class="mt-auto">
                                    <button disabled class="w-full text-center px-4 py-2 bg-spa-beige text-spa-gray opacity-60 cursor-not-allowed rounded-md font-medium text-sm transition-colors uppercase tracking-wide">
                                        Book Soon
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @empty
                <x-ui.empty-state 
                    icon="M20 12H4"
                    title="No services available"
                    description="Please check back later for our spa menu."
                />
            @endforelse

        </div>
    </div>
</x-customer-layout>

