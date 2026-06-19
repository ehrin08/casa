<x-manager-layout>
    <x-slot name="header">
        Create Promotion Rule
    </x-slot>

    <div class="mb-6">
        <a href="{{ route('manager.promotions.rules') }}" class="text-sm font-medium text-[#1f2d28] hover:underline">&larr; Back to Rules</a>
    </div>

    <div class="bg-spa-white rounded-xl shadow-sm border border-spa-beige overflow-hidden">
        <form action="{{ route('manager.promotions.rules.store') }}" method="POST" class="p-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Basic Info -->
                <div class="space-y-6">
                    <h3 class="text-lg font-bold text-spa-charcoal border-b pb-2">Basic Details</h3>
                    
                    <div>
                        <label class="block text-sm font-medium text-spa-charcoal opacity-90">Rule Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="mt-1 block w-full rounded-md border-spa-wood shadow-sm focus:border-spa-gold focus:ring-spa-gold" required>
                        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-spa-charcoal opacity-90">Description</label>
                        <textarea name="description" rows="3" class="mt-1 block w-full rounded-md border-spa-wood shadow-sm focus:border-spa-gold focus:ring-spa-gold">{{ old('description') }}</textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-spa-charcoal opacity-90">Discount Type</label>
                            <select name="discount_type" class="mt-1 block w-full rounded-md border-spa-wood shadow-sm focus:border-spa-gold focus:ring-spa-gold">
                                <option value="percentage" {{ old('discount_type') == 'percentage' ? 'selected' : '' }}>Percentage (%)</option>
                                <option value="fixed" {{ old('discount_type') == 'fixed' ? 'selected' : '' }}>Fixed Amount (₱)</option>
                                <option value="free_service" {{ old('discount_type') == 'free_service' ? 'selected' : '' }}>Free Service</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-spa-charcoal opacity-90">Discount Value</label>
                            <input type="number" step="0.01" name="discount_value" value="{{ old('discount_value', 0) }}" class="mt-1 block w-full rounded-md border-spa-wood shadow-sm focus:border-spa-gold focus:ring-spa-gold" required>
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-spa-charcoal opacity-90">Target Segment</label>
                        <select name="segment" class="mt-1 block w-full rounded-md border-spa-wood shadow-sm focus:border-spa-gold focus:ring-spa-gold">
                            <option value="all">All Customers</option>
                            <option value="champions">Champions</option>
                            <option value="loyal_customers">Loyal Customers</option>
                            <option value="at_risk">At Risk</option>
                            <option value="new_customers">New Customers</option>
                            <option value="dormant">Dormant</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-spa-charcoal opacity-90">Status</label>
                        <select name="status" class="mt-1 block w-full rounded-md border-spa-wood shadow-sm focus:border-spa-gold focus:ring-spa-gold">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                </div>

                <!-- Eligibility & Limits -->
                <div class="space-y-6">
                    <h3 class="text-lg font-bold text-spa-charcoal border-b pb-2">Eligibility & Limits</h3>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-spa-charcoal opacity-90">Min Total Spent (₱)</label>
                            <input type="number" step="0.01" name="minimum_total_spent" value="{{ old('minimum_total_spent') }}" class="mt-1 block w-full rounded-md border-spa-wood shadow-sm focus:border-spa-gold focus:ring-spa-gold">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-spa-charcoal opacity-90">Min Visit Count</label>
                            <input type="number" name="minimum_visit_count" value="{{ old('minimum_visit_count') }}" class="mt-1 block w-full rounded-md border-spa-wood shadow-sm focus:border-spa-gold focus:ring-spa-gold">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-spa-charcoal opacity-90">Max Recency Days</label>
                            <input type="number" name="maximum_days_since_last_visit" value="{{ old('maximum_days_since_last_visit') }}" class="mt-1 block w-full rounded-md border-spa-wood shadow-sm focus:border-spa-gold focus:ring-spa-gold">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-spa-charcoal opacity-90">Min Recency Days</label>
                            <input type="number" name="minimum_days_since_last_visit" value="{{ old('minimum_days_since_last_visit') }}" class="mt-1 block w-full rounded-md border-spa-wood shadow-sm focus:border-spa-gold focus:ring-spa-gold">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-spa-charcoal opacity-90">Specific Service Only</label>
                        <select name="applicable_service_id" class="mt-1 block w-full rounded-md border-spa-wood shadow-sm focus:border-spa-gold focus:ring-spa-gold">
                            <option value="">Any Service</option>
                            @foreach($services as $service)
                                <option value="{{ $service->id }}">{{ $service->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="border p-4 rounded-md bg-spa-cream">
                        <div class="flex items-center mb-4">
                            <input type="checkbox" name="is_off_peak_only" value="1" id="is_off_peak" class="rounded border-spa-wood text-spa-gold shadow-sm focus:border-spa-gold focus:ring-spa-gold">
                            <label for="is_off_peak" class="ml-2 block text-sm font-medium text-spa-charcoal opacity-90">Off-Peak Only?</label>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-spa-charcoal opacity-90">Start Time</label>
                                <input type="time" name="off_peak_start_time" value="{{ old('off_peak_start_time') }}" class="mt-1 block w-full rounded-md border-spa-wood shadow-sm focus:border-spa-gold focus:ring-spa-gold">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-spa-charcoal opacity-90">End Time</label>
                                <input type="time" name="off_peak_end_time" value="{{ old('off_peak_end_time') }}" class="mt-1 block w-full rounded-md border-spa-wood shadow-sm focus:border-spa-gold focus:ring-spa-gold">
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-spa-charcoal opacity-90">Global Usage Limit</label>
                            <input type="number" name="usage_limit" value="{{ old('usage_limit') }}" class="mt-1 block w-full rounded-md border-spa-wood shadow-sm focus:border-spa-gold focus:ring-spa-gold">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-spa-charcoal opacity-90">Per-Customer Limit</label>
                            <input type="number" name="per_customer_limit" value="{{ old('per_customer_limit') }}" class="mt-1 block w-full rounded-md border-spa-wood shadow-sm focus:border-spa-gold focus:ring-spa-gold">
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-8 border-t pt-6 flex justify-end">
                <x-ui.submit-button label="Save Promotion Rule" />
            </div>
        </form>
    </div>
</x-manager-layout>
