<x-customer-layout>
    <x-slot name="header">
        {{ __('My Reviews') }}
    </x-slot>

    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <div class="mb-6 flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-900">My Reviews</h2>
            <p class="text-sm text-gray-500">History of your service feedback</p>
        </div>

        @if(session('success'))
            <div class="mb-4 bg-green-50 border-l-4 border-green-400 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-green-700">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif
        
        @if(session('error'))
            <div class="mb-4 bg-red-50 border-l-4 border-red-400 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm-1-9v-4a1 1 0 112 0v4a1 1 0 11-2 0zm0 4a1 1 0 112 0v1a1 1 0 11-2 0v-1z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-red-700">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
        @endif
        
        @if(session('info'))
            <div class="mb-4 bg-blue-50 border-l-4 border-blue-400 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-blue-700">{{ session('info') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <div class="space-y-6">
            @forelse($reviews as $review)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="border-b border-gray-100 bg-gray-50/50 px-6 py-4 flex justify-between items-center">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">{{ $review->service->name }}</h3>
                            <p class="text-xs text-gray-500 mt-1">with {{ $review->therapist->user->name ?? 'Therapist' }} • {{ $review->reviewed_at->format('M d, Y') }}</p>
                        </div>
                        <div class="flex items-center space-x-1 text-yellow-400">
                            @for($i = 1; $i <= 5; $i++)
                                <svg class="w-5 h-5 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endfor
                        </div>
                    </div>
                    
                    <div class="p-6">
                        @if($review->key_snippet)
                            <h4 class="text-md font-medium text-gray-900 mb-2">"{{ $review->key_snippet }}"</h4>
                        @endif
                        
                        <p class="text-sm text-gray-600 mb-4">{{ $review->comment }}</p>
                        
                        @if(!empty($review->tags) && count($review->tags) > 0)
                            <div class="flex flex-wrap gap-2 mt-4 pt-4 border-t border-gray-100">
                                @foreach($review->tags as $tag)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-[#f0f4f2] text-[#2c3e38]">
                                        {{ $tag }}
                                    </span>
                                @endforeach
                            </div>
                        @endif
                        
                        <div class="mt-4 text-xs text-gray-400 flex justify-between items-center">
                            <span>Booking Ref: <a href="{{ route('customer.bookings.show', $review->booking_id) }}" class="text-[#2c3e38] hover:underline hover:text-[#1f2d28]">#CPB-{{ $review->booking_id }}</a></span>
                            @if($review->sentiment === 'positive')
                                <span class="inline-flex items-center text-green-600">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                                    Positive Feedback
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-10 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                    <h3 class="text-lg font-medium text-gray-900">No Reviews Yet</h3>
                    <p class="mt-1 text-sm text-gray-500">You haven't submitted any reviews for your past appointments.</p>
                    <div class="mt-6">
                        <a href="{{ route('customer.bookings.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-[#2c3e38] hover:bg-[#1f2d28] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#2c3e38]">
                            View Completed Bookings
                        </a>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</x-customer-layout>
