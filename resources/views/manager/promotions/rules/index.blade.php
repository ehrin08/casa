<x-manager-layout>
    <x-slot name="header">
        Promotion Rules
    </x-slot>

    <div class="mb-6 flex justify-between items-center">
        <a href="{{ route('manager.promotions.index') }}" class="text-sm font-medium text-[#1f2d28] hover:underline">&larr; Back to Promotions</a>
        <button type="button" x-data="" x-on:click="$dispatch('open-modal', 'create-rule')" class="px-4 py-2 bg-[#2c3e38] text-white rounded-md font-medium text-sm hover:bg-[#1f2d28] transition-colors">
            + Create Rule
        </button>
    </div>


    <div class="bg-spa-white rounded-xl shadow-sm border border-spa-beige overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-spa-cream">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-spa-gray opacity-80 uppercase tracking-wider">Rule Details</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-spa-gray opacity-80 uppercase tracking-wider">Target Segment</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-spa-gray opacity-80 uppercase tracking-wider">Discount</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-spa-gray opacity-80 uppercase tracking-wider">Limits</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-spa-gray opacity-80 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-spa-gray opacity-80 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-spa-white divide-y divide-gray-200">
                    @forelse($rules as $rule)
                        <tr>
                            <td class="px-6 py-4">
                                <div class="text-sm font-bold text-spa-charcoal">{{ $rule->name }}</div>
                                <div class="text-xs text-spa-gray opacity-80 mt-1 max-w-xs truncate">{{ $rule->description }}</div>
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
                                    <span class="text-sm font-medium capitalize text-spa-charcoal opacity-90">{{ str_replace('_', ' ', $rule->segment) }}</span>
                                @else
                                    <span class="text-sm text-spa-gray opacity-80">All Customers</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-bold text-spa-charcoal">
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
                                <div class="text-xs text-spa-gray opacity-80">Global: {{ $rule->usage_limit ?? '∞' }}</div>
                                <div class="text-xs text-spa-gray opacity-80">Per Cust: {{ $rule->per_customer_limit ?? '∞' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <x-ui.status-badge :status="$rule->status" />
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button type="button" x-data="" x-on:click="$dispatch('open-modal', 'edit-rule-{{ $rule->id }}')" class="text-spa-gold hover:text-indigo-900 mr-3">Edit</button>
                                <button type="button" x-data="" x-on:click="$dispatch('open-modal', 'confirm-delete-{{ $rule->id }}')" class="text-red-600 hover:text-red-900">Delete</button>
                                
                                <x-ui.confirm-modal 
                                    id="confirm-delete-{{ $rule->id }}"
                                    name="confirm-delete-{{ $rule->id }}"
                                    title="Delete Rule"
                                    message="Are you sure you want to delete this rule? It will be soft deleted."
                                    action="{{ route('manager.promotions.rules.destroy', $rule) }}"
                                    method="DELETE"
                                    confirmText="Delete Rule"
                                />

                                <x-modal name="edit-rule-{{ $rule->id }}" :show="$errors->any() && old('_modal_id') === 'edit-rule-'.$rule->id" maxWidth="3xl">
                                    <x-ui.modal-form 
                                        title="Edit Promotion Rule" 
                                        action="{{ route('manager.promotions.rules.update', $rule) }}" 
                                        method="PUT"
                                    >
                                        @include('manager.promotions.rules._form', ['modalId' => 'edit-rule-'.$rule->id, 'rule' => $rule])
                                        <x-slot name="actions">
                                            <x-ui.submit-button label="Save Changes" />
                                        </x-slot>
                                    </x-ui.modal-form>
                                </x-modal>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8">
                                <x-ui.empty-state 
                                    icon="tag" 
                                    title="No promotion rules found" 
                                    description="Get started by creating a new promotion rule." 
                                />
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($rules->hasPages())
            <div class="px-6 py-4 border-t border-spa-beige">
                {{ $rules->links() }}
            </div>
        @endif
    </div>

    <x-modal name="create-rule" :show="$errors->any() && old('_modal_id') === 'create-rule'" maxWidth="3xl">
        <x-ui.modal-form 
            title="Create Promotion Rule" 
            action="{{ route('manager.promotions.rules.store') }}" 
            method="POST"
        >
            @include('manager.promotions.rules._form', ['modalId' => 'create-rule', 'rule' => new \App\Models\PromotionRule()])
            <x-slot name="actions">
                <x-ui.submit-button label="Create Rule" />
            </x-slot>
        </x-ui.modal-form>
    </x-modal>
</x-manager-layout>
