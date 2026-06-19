<x-manager-layout>
    <x-slot name="header">
        Edit Promotion Rule
    </x-slot>

    <div class="mb-6">
        <a href="{{ route('manager.promotions.rules') }}" class="text-sm font-medium text-[#1f2d28] hover:underline">&larr; Back to Rules</a>
    </div>

    <div class="bg-spa-white rounded-xl shadow-sm border border-spa-beige overflow-hidden">
        <form action="{{ route('manager.promotions.rules.update', $promotionRule) }}" method="POST" class="p-6">
            @csrf
            @method('PATCH')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Basic Info -->
                <div class="space-y-6">
                    <h3 class="text-lg font-bold text-spa-charcoal border-b pb-2">Basic Details</h3>
                    
                    <div>
                        <label class="block text-sm font-medium text-spa-charcoal opacity-90">Rule Name</label>
                        <input type="text" name="name" value="{{ old('name', $promotionRule->name) }}" class="mt-1 block w-full rounded-md border-spa-wood shadow-sm focus:border-spa-gold focus:ring-spa-gold" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-spa-charcoal opacity-90">Description</label>
                        <textarea name="description" rows="3" class="mt-1 block w-full rounded-md border-spa-wood shadow-sm focus:border-spa-gold focus:ring-spa-gold">{{ old('description', $promotionRule->description) }}</textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-spa-charcoal opacity-90">Discount Type</label>
                            <select name="discount_type" class="mt-1 block w-full rounded-md border-spa-wood shadow-sm focus:border-spa-gold focus:ring-spa-gold">
                                <option value="percentage" {{ old('discount_type', $promotionRule->discount_type) == 'percentage' ? 'selected' : '' }}>Percentage (%)</option>
                                <option value="fixed" {{ old('discount_type', $promotionRule->discount_type) == 'fixed' ? 'selected' : '' }}>Fixed Amount (₱)</option>
                                <option value="free_service" {{ old('discount_type', $promotionRule->discount_type) == 'free_service' ? 'selected' : '' }}>Free Service</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-spa-charcoal opacity-90">Discount Value</label>
                            <input type="number" step="0.01" name="discount_value" value="{{ old('discount_value', $promotionRule->discount_value) }}" class="mt-1 block w-full rounded-md border-spa-wood shadow-sm focus:border-spa-gold focus:ring-spa-gold" required>
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-spa-charcoal opacity-90">Target Segment</label>
                        <select name="segment" class="mt-1 block w-full rounded-md border-spa-wood shadow-sm focus:border-spa-gold focus:ring-spa-gold">
                            <option value="all" {{ old('segment', $promotionRule->segment) == 'all' ? 'selected' : '' }}>All Customers</option>
                            <option value="champions" {{ old('segment', $promotionRule->segment) == 'champions' ? 'selected' : '' }}>Champions</option>
                            <option value="loyal_customers" {{ old('segment', $promotionRule->segment) == 'loyal_customers' ? 'selected' : '' }}>Loyal Customers</option>
                            <option value="at_risk" {{ old('segment', $promotionRule->segment) == 'at_risk' ? 'selected' : '' }}>At Risk</option>
                            <option value="new_customers" {{ old('segment', $promotionRule->segment) == 'new_customers' ? 'selected' : '' }}>New Customers</option>
                            <option value="dormant" {{ old('segment', $promotionRule->segment) == 'dormant' ? 'selected' : '' }}>Dormant</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-spa-charcoal opacity-90">Status</label>
                        <select name="status" class="mt-1 block w-full rounded-md border-spa-wood shadow-sm focus:border-spa-gold focus:ring-spa-gold">
                            <option value="active" {{ old('status', $promotionRule->status) == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status', $promotionRule->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                </div>

                <!-- Eligibility & Limits -->
                <div class="space-y-6">
                    <h3 class="text-lg font-bold text-spa-charcoal border-b pb-2">Eligibility & Limits</h3>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-spa-charcoal opacity-90">Min Total Spent (₱)</label>
                            <input type="number" step="0.01" name="minimum_total_spent" value="{{ old('minimum_total_spent', $promotionRule->minimum_total_spent) }}" class="mt-1 block w-full rounded-md border-spa-wood shadow-sm focus:border-spa-gold focus:ring-spa-gold">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-spa-charcoal opacity-90">Min Visit Count</label>
                            <input type="number" name="minimum_visit_count" value="{{ old('minimum_visit_count', $promotionRule->minimum_visit_count) }}" class="mt-1 block w-full rounded-md border-spa-wood shadow-sm focus:border-spa-gold focus:ring-spa-gold">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-spa-charcoal opacity-90">Max Recency Days</label>
                            <input type="number" name="maximum_days_since_last_visit" value="{{ old('maximum_days_since_last_visit', $promotionRule->maximum_days_since_last_visit) }}" class="mt-1 block w-full rounded-md border-spa-wood shadow-sm focus:border-spa-gold focus:ring-spa-gold">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-spa-charcoal opacity-90">Min Recency Days</label>
                            <input type="number" name="minimum_days_since_last_visit" value="{{ old('minimum_days_since_last_visit', $promotionRule->minimum_days_since_last_visit) }}" class="mt-1 block w-full rounded-md border-spa-wood shadow-sm focus:border-spa-gold focus:ring-spa-gold">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-spa-charcoal opacity-90">Specific Service Only</label>
                        <select name="applicable_service_id" class="mt-1 block w-full rounded-md border-spa-wood shadow-sm focus:border-spa-gold focus:ring-spa-gold">
                            <option value="">Any Service</option>
                            @foreach($services as $service)
                                <option value="{{ $service->id }}" {{ old('applicable_service_id', $promotionRule->applicable_service_id) == $service->id ? 'selected' : '' }}>{{ $service->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="border p-4 rounded-md bg-spa-cream">
                        <div class="flex items-center mb-4">
                            <input type="checkbox" name="is_off_peak_only" value="1" id="is_off_peak" {{ old('is_off_peak_only', $promotionRule->is_off_peak_only) ? 'checked' : '' }} class="rounded border-spa-wood text-spa-gold shadow-sm focus:border-spa-gold focus:ring-spa-gold">
                            <label for="is_off_peak" class="ml-2 block text-sm font-medium text-spa-charcoal opacity-90">Off-Peak Only?</label>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-spa-charcoal opacity-90">Start Time</label>
                                <input type="time" name="off_peak_start_time" value="{{ old('off_peak_start_time', $promotionRule->off_peak_start_time ? \Carbon\Carbon::parse($promotionRule->off_peak_start_time)->format('H:i') : '') }}" class="mt-1 block w-full rounded-md border-spa-wood shadow-sm focus:border-spa-gold focus:ring-spa-gold">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-spa-charcoal opacity-90">End Time</label>
                                <input type="time" name="off_peak_end_time" value="{{ old('off_peak_end_time', $promotionRule->off_peak_end_time ? \Carbon\Carbon::parse($promotionRule->off_peak_end_time)->format('H:i') : '') }}" class="mt-1 block w-full rounded-md border-spa-wood shadow-sm focus:border-spa-gold focus:ring-spa-gold">
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-spa-charcoal opacity-90">Global Usage Limit</label>
                            <input type="number" name="usage_limit" value="{{ old('usage_limit', $promotionRule->usage_limit) }}" class="mt-1 block w-full rounded-md border-spa-wood shadow-sm focus:border-spa-gold focus:ring-spa-gold">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-spa-charcoal opacity-90">Per-Customer Limit</label>
                            <input type="number" name="per_customer_limit" value="{{ old('per_customer_limit', $promotionRule->per_customer_limit) }}" class="mt-1 block w-full rounded-md border-spa-wood shadow-sm focus:border-spa-gold focus:ring-spa-gold">
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-8 border-t pt-6 flex justify-end">
                <x-ui.submit-button label="Update Promotion Rule" />
            </div>
        </form>
    </div>
</x-manager-layout>
