<x-manager-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-spa-charcoal leading-tight">
            {{ __('Customer Reviews & Sentiment') }}
        </h2>
        <p class="text-sm text-spa-gray opacity-80 mt-1">Monitor customer feedback, service satisfaction, and therapist performance.</p>
    </x-slot>

    <div class="mb-8 grid grid-cols-1 md:grid-cols-4 gap-6">
        <x-dashboard.stat-card 
            title="Total Reviews" 
            value="{{ $totalReviews }}" 
            subtitle="All time feedback"
            icon="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />

        <x-dashboard.stat-card 
            title="Average Rating" 
            value="{{ number_format($averageRating, 1) }} / 5.0" 
            subtitle="Overall satisfaction"
            icon="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"
            color="text-yellow-600"
            bg="bg-yellow-100" />

        <x-dashboard.stat-card 
            title="Positive Sentiment" 
            value="{{ $positiveReviews }}" 
            subtitle="Happy customers"
            icon="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
            color="text-green-600"
            bg="bg-green-100" />

        <x-dashboard.stat-card 
            title="Negative Sentiment" 
            value="{{ $negativeReviews }}" 
            subtitle="Needs improvement"
            icon="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
            color="text-red-600"
            bg="bg-red-100" />
    </div>

    <div class="bg-spa-white p-6 rounded-xl shadow-sm border border-spa-beige mb-8 flex justify-between items-end">
        <form method="GET" action="{{ route('manager.reviews.index') }}" class="flex-1 grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-xs font-medium text-spa-gray opacity-80 mb-1">Search</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Customer, Service..." class="w-full text-sm border-spa-wood rounded-md shadow-sm focus:border-[#2c3e38] focus:ring-[#2c3e38]">
            </div>
            <div>
                <label class="block text-xs font-medium text-spa-gray opacity-80 mb-1">Sentiment</label>
                <select name="sentiment" class="w-full text-sm border-spa-wood rounded-md shadow-sm focus:border-[#2c3e38] focus:ring-[#2c3e38]">
                    <option value="">All</option>
                    <option value="positive" {{ request('sentiment') === 'positive' ? 'selected' : '' }}>Positive</option>
                    <option value="negative" {{ request('sentiment') === 'negative' ? 'selected' : '' }}>Negative</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium text-spa-gray opacity-80 mb-1">Status</label>
                <select name="status" class="w-full text-sm border-spa-wood rounded-md shadow-sm focus:border-[#2c3e38] focus:ring-[#2c3e38]">
                    <option value="">All</option>
                    <option value="visible" {{ request('status') === 'visible' ? 'selected' : '' }}>Visible</option>
                    <option value="hidden" {{ request('status') === 'hidden' ? 'selected' : '' }}>Hidden</option>
                </select>
            </div>
            <div class="flex items-end space-x-2">
                <button type="submit" class="bg-spa-beige hover:bg-gray-200 text-spa-charcoal px-4 py-2 rounded-md text-sm font-medium transition-colors">Filter</button>
                <a href="{{ route('manager.reviews.index') }}" class="text-sm text-spa-gray opacity-80 hover:text-gray-700 px-2 py-2">Clear</a>
            </div>
        </form>
        <div class="ml-4">
            <a href="{{ route('manager.reviews.report', request()->query()) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-[#2c3e38] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-[#1f2d28] focus:bg-[#1f2d28] active:bg-[#1f2d28] focus:outline-none focus:ring-2 focus:ring-[#2c3e38] focus:ring-offset-2 transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                PDF Report
            </a>
        </div>
    </div>



    <div class="bg-spa-white rounded-xl shadow-sm border border-spa-beige overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-spa-cream">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-spa-gray opacity-80 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-spa-gray opacity-80 uppercase tracking-wider">Customer</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-spa-gray opacity-80 uppercase tracking-wider">Service / Therapist</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-spa-gray opacity-80 uppercase tracking-wider">Rating & Sentiment</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-spa-gray opacity-80 uppercase tracking-wider">Snippet</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-spa-gray opacity-80 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-spa-gray opacity-80 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-spa-white divide-y divide-gray-200">
                    @forelse($reviews as $review)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-spa-charcoal">
                                {{ $review->reviewed_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-spa-charcoal">{{ $review->customer->name }}</div>
                                <div class="text-xs text-spa-gray opacity-80">{{ $review->customer->email }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-spa-charcoal">{{ $review->service->name }}</div>
                                <div class="text-xs text-spa-gray opacity-80">{{ $review->therapist->user->name ?? 'Unknown' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center space-x-1 text-yellow-400 mb-1">
                                    @for($i=1; $i<=5; $i++)
                                        <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-200' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    @endfor
                                </div>
                                <div class="mt-2">
                                    <x-ui.status-badge :status="$review->sentiment === 'positive' ? 'positive' : 'negative'" />
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-spa-gray opacity-80">
                                <div class="max-w-xs truncate italic">"{{ $review->key_snippet }}"</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <x-ui.status-badge :status="$review->status" />
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('manager.reviews.show', $review) }}" class="text-[#2c3e38] hover:text-[#1f2d28] mr-3">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8">
                                <x-ui.empty-state 
                                    icon="chat-bubble-bottom-center-text" 
                                    title="No reviews found" 
                                    description="No customer reviews match your criteria." 
                                />
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($reviews->hasPages())
            <div class="bg-spa-white px-4 py-3 border-t border-spa-beige sm:px-6">
                {{ $reviews->links() }}
            </div>
        @endif
    </div>
</x-manager-layout>
