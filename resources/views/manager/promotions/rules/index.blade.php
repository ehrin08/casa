<x-manager-layout>
    <x-slot name="header">
        Promotion Rules
    </x-slot>

    <div class="mb-6 flex justify-between items-center">
        <a href="{{ route('manager.promotions.index') }}" class="text-sm font-medium text-[#1f2d28] hover:underline">&larr; Back to Promotions</a>
        <a href="{{ route('manager.promotions.rules.create') }}" class="px-4 py-2 bg-[#2c3e38] text-white rounded-md font-medium text-sm hover:bg-[#1f2d28] transition-colors">
            + Create Rule
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-6 rounded-r-lg">
            <div class="flex items-center">
                <svg class="h-5 w-5 text-green-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rule Details</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Target Segment</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Discount</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Limits</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($rules as $rule)
                        <tr>
                            <td class="px-6 py-4">
                                <div class="text-sm font-bold text-gray-900">{{ $rule->name }}</div>
                                <div class="text-xs text-gray-500 mt-1 max-w-xs truncate">{{ $rule->description }}</div>
                                @if($rule->is_off_peak_only)
                                    <span class="inline-flex items-center px-2 py-0.5 mt-1 rounded text-[10px] font-medium bg-purple-100 text-purple-800">
                                        Off-Peak ({{ \Carbon\Carbon::parse($rule->off_peak_start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($rule->off_peak_end_time)->format('H:i') }})
                                    </span>
                                @endif
                                @if($rule->applicableService)
                                    <span class="inline-flex items-center px-2 py-0.5 mt-1 rounded text-[10px] font-medium bg-blue-100 text-blue-800">
                                        {{ $rule->applicableService->name }} Only
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($rule->segment)
                                    <span class="text-sm font-medium capitalize text-gray-700">{{ str_replace('_', ' ', $rule->segment) }}</span>
                                @else
                                    <span class="text-sm text-gray-500">All Customers</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-bold text-gray-900">
                                    @if($rule->discount_type === 'percentage')
                                        {{ $rule->discount_value }}%
                                    @elseif($rule->discount_type === 'fixed')
                                        ₱{{ number_format($rule->discount_value, 2) }}
                                    @else
                                        Free Service
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-xs text-gray-500">Global: {{ $rule->usage_limit ?? '∞' }}</div>
                                <div class="text-xs text-gray-500">Per Cust: {{ $rule->per_customer_limit ?? '∞' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($rule->status === 'active')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Inactive</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('manager.promotions.rules.edit', $rule) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                <form action="{{ route('manager.promotions.rules.destroy', $rule) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this rule? It will be soft deleted.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500 text-sm">
                                No promotion rules found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($rules->hasPages())
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $rules->links() }}
            </div>
        @endif
    </div>
</x-manager-layout>
