<x-manager-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-spa-charcoal leading-tight">
            {{ __('Review Details') }}
        </h2>
    </x-slot>

    <div class="mb-4">
        <a href="{{ route('manager.reviews.index') }}" class="text-[#2c3e38] hover:text-[#1f2d28] font-medium text-sm">
            &larr; Back to Reviews
        </a>
    </div>



    <div class="bg-spa-white rounded-xl shadow-sm border border-spa-beige overflow-hidden max-w-4xl">
        <div class="p-6 border-b border-spa-beige flex justify-between items-start">
            <div>
                <h3 class="text-xl font-bold text-spa-charcoal">{{ $review->service->name }}</h3>
                <p class="text-sm text-spa-gray opacity-80 mt-1">Booking Ref: <a href="{{ route('manager.bookings.show', $review->booking_id) }}" class="text-[#2c3e38] hover:underline hover:text-[#1f2d28]">#CPB-{{ $review->booking_id }}</a></p>
            </div>
            <div class="text-right">
                <div class="flex items-center space-x-1 text-yellow-400 mb-2 justify-end">
                    @for($i=1; $i<=5; $i++)
                        <svg class="w-6 h-6 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-200' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    @endfor
                </div>
                @if($review->sentiment === 'positive')
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">Positive Feedback</span>
                @else
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">Negative Feedback</span>
                @endif
            </div>
        </div>

        <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="md:col-span-2 space-y-6">
                <div>
                    <h4 class="text-xs font-semibold text-spa-gray opacity-80 uppercase tracking-wider mb-2">Customer Comment</h4>
                    <div class="bg-spa-cream rounded-lg p-4 border border-spa-beige text-spa-charcoal text-sm whitespace-pre-line">
                        {{ $review->comment }}
                    </div>
                </div>

                <div>
                    <h4 class="text-xs font-semibold text-spa-gray opacity-80 uppercase tracking-wider mb-2">Key Snippet (Extracted)</h4>
                    <p class="text-sm italic text-spa-gray border-l-4 border-spa-beige pl-3 py-1">{{ $review->key_snippet ?: 'N/A' }}</p>
                </div>

                <div>
                    <h4 class="text-xs font-semibold text-spa-gray opacity-80 uppercase tracking-wider mb-2">Selected Tags</h4>
                    @if(!empty($review->tags) && count($review->tags) > 0)
                        <div class="flex flex-wrap gap-2">
                            @foreach($review->tags as $tag)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-[#f0f4f2] text-[#2c3e38]">
                                    {{ $tag }}
                                </span>
                            @endforeach
                        </div>
                    @else
                        <p class="text-sm text-spa-gray opacity-80">No tags selected.</p>
                    @endif
                </div>
            </div>

            <div class="space-y-6">
                <div class="bg-[#f9f8f6] p-4 rounded-lg border border-[#e8dbce]">
                    <h4 class="text-xs font-semibold text-[#7a6b5d] uppercase tracking-wider mb-3">Review Metadata</h4>
                    
                    <div class="space-y-3 text-sm">
                        <div>
                            <span class="block text-spa-gray opacity-80">Date Submitted:</span>
                            <span class="font-medium text-spa-charcoal">{{ $review->reviewed_at->format('M d, Y h:i A') }}</span>
                        </div>
                        <div>
                            <span class="block text-spa-gray opacity-80">Customer:</span>
                            <span class="font-medium text-spa-charcoal">{{ $review->customer->name }}</span>
                        </div>
                        <div>
                            <span class="block text-spa-gray opacity-80">Therapist:</span>
                            <span class="font-medium text-spa-charcoal">{{ $review->therapist->user->name ?? 'Unknown' }}</span>
                        </div>
                        <div>
                            <span class="block text-spa-gray opacity-80">Algorithm Score:</span>
                            <span class="font-medium {{ $review->sentiment_score >= 0 ? 'text-green-600' : 'text-red-600' }}">{{ $review->sentiment_score }}</span>
                        </div>
                        <div>
                            <span class="block text-spa-gray opacity-80">Visibility Status:</span>
                            @if($review->status === 'visible')
                                <span class="inline-flex items-center text-blue-600"><svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg> Visible</span>
                            @else
                                <span class="inline-flex items-center text-spa-gray opacity-80"><svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path></svg> Hidden</span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="border-t border-spa-beige pt-4">
                    <h4 class="text-xs font-semibold text-spa-gray opacity-80 uppercase tracking-wider mb-3">Moderation Actions</h4>
                    @if($review->status === 'visible')
                        <button type="button" x-data="" x-on:click="$dispatch('open-modal-confirm-hide')" class="w-full inline-flex justify-center items-center px-4 py-2 border border-spa-wood shadow-sm text-sm font-medium rounded-md text-spa-charcoal opacity-90 bg-spa-white hover:bg-spa-beige focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#2c3e38]">
                            Hide Review
                        </button>
                        
                        <x-ui.confirm-modal 
                            id="confirm-hide"
                            name="confirm-hide"
                            title="Hide Review"
                            message="Are you sure you want to hide this review from public view?"
                            action="{{ route('manager.reviews.hide', $review) }}"
                            method="PATCH"
                            confirmText="Hide Review"
                        />
                    @else
                        <button type="button" x-data="" x-on:click="$dispatch('open-modal-confirm-show')" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-[#2c3e38] hover:bg-[#1f2d28] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#2c3e38]">
                            Make Visible
                        </button>
                        
                        <x-ui.confirm-modal 
                            id="confirm-show"
                            name="confirm-show"
                            title="Make Review Visible"
                            message="Are you sure you want to make this review visible to the public?"
                            action="{{ route('manager.reviews.showReview', $review) }}"
                            method="PATCH"
                            confirmText="Make Visible"
                            type="info"
                        />
                    @endif
                    <p class="text-xs text-spa-gray opacity-60 mt-2 text-center">Reviews cannot be modified to preserve authenticity.</p>
                </div>
            </div>
        </div>
    </div>
</x-manager-layout>
