<x-customer-layout>
    <x-slot name="header">
        {{ __('Leave a Review') }}
    </x-slot>

    <div class="max-w-3xl mx-auto py-10 sm:px-6 lg:px-8">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="border-b border-gray-100 bg-[#2c3e38] px-6 py-5 text-white">
                <h2 class="text-xl font-bold">How was your experience?</h2>
                <p class="text-sm text-[#e8dbce] mt-1">We value your feedback. Help us improve our services.</p>
            </div>
            
            <div class="p-6 bg-gray-50 border-b border-gray-100 flex items-center">
                <div class="flex-shrink-0 h-12 w-12 rounded-full bg-[#f0f4f2] flex items-center justify-center text-[#2c3e38]">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"></path></svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-bold text-gray-900">{{ $booking->service->name }}</h3>
                    <p class="text-xs text-gray-500">Therapist: {{ $booking->therapist->user->name ?? 'Unknown' }} • {{ $booking->appointment_date->format('M d, Y') }}</p>
                </div>
            </div>

            <form action="{{ route('customer.reviews.store', $booking) }}" method="POST" class="p-6">
                @csrf

                <!-- Rating -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Overall Rating <span class="text-red-500">*</span></label>
                    <div class="flex items-center space-x-2" x-data="{ rating: 0, hover: 0 }">
                        <input type="hidden" name="rating" x-model="rating" required>
                        @for($i = 1; $i <= 5; $i++)
                            <button type="button" 
                                @click="rating = {{ $i }}" 
                                @mouseenter="hover = {{ $i }}" 
                                @mouseleave="hover = 0"
                                class="focus:outline-none transition-colors duration-150"
                            >
                                <svg class="w-10 h-10" :class="(hover >= {{ $i }} || rating >= {{ $i }}) ? 'text-yellow-400' : 'text-gray-300'" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            </button>
                        @endfor
                        <span class="ml-3 text-sm font-medium text-gray-500" x-show="rating > 0" x-text="['Terrible', 'Poor', 'Average', 'Good', 'Excellent'][rating-1]"></span>
                    </div>
                    @error('rating')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tags -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">What stood out to you?</label>
                    <div class="flex flex-wrap gap-2">
                        @php
                            $tags = ['Clean Facility', 'Friendly Staff', 'Relaxing Service', 'On-Time', 'Good Value', 'Professional Therapist', 'Long Waiting Time', 'Uncomfortable Experience', 'Needs Improvement'];
                        @endphp
                        @foreach($tags as $tag)
                            <label class="relative flex items-center cursor-pointer">
                                <input type="checkbox" name="tags[]" value="{{ $tag }}" class="peer sr-only">
                                <span class="px-3 py-1.5 text-xs font-medium rounded-full border border-gray-200 text-gray-600 bg-white peer-checked:bg-[#2c3e38] peer-checked:text-white peer-checked:border-[#2c3e38] transition-colors hover:bg-gray-50">
                                    {{ $tag }}
                                </span>
                            </label>
                        @endforeach
                    </div>
                    @error('tags')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Comment -->
                <div class="mb-6">
                    <label for="comment" class="block text-sm font-medium text-gray-700 mb-2">Share details of your own experience <span class="text-red-500">*</span></label>
                    <textarea id="comment" name="comment" rows="4" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-[#2c3e38] focus:ring-[#2c3e38] sm:text-sm resize-none" placeholder="How was the massage? How was the facility?..." required>{{ old('comment') }}</textarea>
                    <p class="mt-1 text-xs text-gray-500">Your review will help others and allow us to improve our services.</p>
                    @error('comment')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end pt-4 border-t border-gray-100">
                    <a href="{{ route('customer.bookings.show', $booking) }}" class="mr-3 inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#2c3e38]">
                        Cancel
                    </a>
                    <x-ui.submit-button label="Submit Review" />
                </div>
            </form>
        </div>
    </div>
</x-customer-layout>
