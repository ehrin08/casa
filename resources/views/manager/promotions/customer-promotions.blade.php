<x-manager-layout>
    <x-slot name="header">
        Generated Customer Promotions
    </x-slot>

    <div class="mb-6 flex justify-between items-center">
        <a href="{{ route('manager.promotions.index') }}" class="text-sm font-medium text-[#1f2d28] hover:underline">&larr; Back to Promotions</a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-6 p-4">
        <form action="{{ route('manager.promotions.customer-promotions') }}" method="GET" class="flex gap-4 items-end">
            <div>
                <label class="block text-xs font-medium text-gray-700 mb-1">Search</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Code or Customer..." class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-700 mb-1">Status</label>
                <select name="status" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                    <option value="">All Statuses</option>
                    <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Available</option>
                    <option value="used" {{ request('status') == 'used' ? 'selected' : '' }}>Used</option>
                    <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Expired</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>
            <div>
                <button type="submit" class="px-4 py-2 bg-indigo-50 text-indigo-700 rounded-md font-medium text-sm border border-indigo-200 hover:bg-indigo-100">Filter</button>
                @if(request('search') || request('status'))
                    <a href="{{ route('manager.promotions.customer-promotions') }}" class="ml-2 text-sm text-gray-500 hover:text-gray-700">Clear</a>
                @endif
            </div>
        </form>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Code</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rule</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Discount</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dates</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($promotions as $promo)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-mono bg-gray-100 text-gray-800 px-2 py-1 rounded">{{ $promo->code }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $promo->customer->name }}</div>
                                <div class="text-xs text-gray-500">{{ $promo->customer->email }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $promo->rule->name }}</div>
                                <div class="text-[10px] text-gray-400 capitalize">Seg: {{ str_replace('_', ' ', $promo->rule->segment ?? 'all') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-bold text-gray-900">
                                    @if($promo->discount_type === 'percentage')
                                        {{ $promo->discount_value }}% Off
                                    @elseif($promo->discount_type === 'fixed')
                                        ₱{{ number_format($promo->discount_value, 2) }} Off
                                    @else
                                        Free Service
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-xs text-gray-500">Gen: {{ $promo->generated_at ? $promo->generated_at->format('M d, Y') : '-' }}</div>
                                <div class="text-xs text-gray-500">Exp: {{ $promo->expires_at ? $promo->expires_at->format('M d, Y') : 'Never' }}</div>
                                @if($promo->status === 'used')
                                    <div class="text-xs font-semibold text-green-600 mt-1">Used: {{ $promo->used_at ? $promo->used_at->format('M d, Y') : '-' }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($promo->status === 'available')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Available</span>
                                @elseif($promo->status === 'used')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Used</span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800 capitalize">{{ $promo->status }}</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500 text-sm">
                                No customer promotions found matching criteria.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($promotions->hasPages())
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $promotions->links() }}
            </div>
        @endif
    </div>
</x-manager-layout>
