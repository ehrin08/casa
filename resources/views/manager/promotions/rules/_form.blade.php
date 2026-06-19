<input type="hidden" name="_modal_id" value="{{ $modalId ?? '' }}">

<div class="grid grid-cols-1 md:grid-cols-2 gap-8">
    <!-- Basic Info -->
    <div class="space-y-6">
        <h3 class="text-lg font-bold text-spa-charcoal border-b pb-2">Basic Details</h3>
        
        <div>
            <label class="block text-sm font-medium text-spa-charcoal opacity-90">Rule Name *</label>
            <input type="text" name="name" value="{{ old('name', $rule->name ?? '') }}" class="mt-1 block w-full rounded-md border-spa-wood shadow-sm focus:border-[#2c3e38] focus:ring-[#2c3e38]" required>
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <label class="block text-sm font-medium text-spa-charcoal opacity-90">Description</label>
            <textarea name="description" rows="3" class="mt-1 block w-full rounded-md border-spa-wood shadow-sm focus:border-[#2c3e38] focus:ring-[#2c3e38]">{{ old('description', $rule->description ?? '') }}</textarea>
            <x-input-error class="mt-2" :messages="$errors->get('description')" />
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-spa-charcoal opacity-90">Discount Type *</label>
                <select name="discount_type" class="mt-1 block w-full rounded-md border-spa-wood shadow-sm focus:border-[#2c3e38] focus:ring-[#2c3e38]">
                    <option value="percentage" {{ old('discount_type', $rule->discount_type ?? '') == 'percentage' ? 'selected' : '' }}>Percentage (%)</option>
                    <option value="fixed" {{ old('discount_type', $rule->discount_type ?? '') == 'fixed' ? 'selected' : '' }}>Fixed Amount (₱)</option>
                    <option value="free_service" {{ old('discount_type', $rule->discount_type ?? '') == 'free_service' ? 'selected' : '' }}>Free Service</option>
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('discount_type')" />
            </div>
            <div>
                <label class="block text-sm font-medium text-spa-charcoal opacity-90">Discount Value *</label>
                <input type="number" step="0.01" name="discount_value" value="{{ old('discount_value', $rule->discount_value ?? 0) }}" class="mt-1 block w-full rounded-md border-spa-wood shadow-sm focus:border-[#2c3e38] focus:ring-[#2c3e38]" required>
                <x-input-error class="mt-2" :messages="$errors->get('discount_value')" />
            </div>
        </div>
        
        <div>
            <label class="block text-sm font-medium text-spa-charcoal opacity-90">Target Segment</label>
            <select name="segment" class="mt-1 block w-full rounded-md border-spa-wood shadow-sm focus:border-[#2c3e38] focus:ring-[#2c3e38]">
                <option value="all" {{ old('segment', $rule->segment ?? '') == 'all' ? 'selected' : '' }}>All Customers</option>
                <option value="champions" {{ old('segment', $rule->segment ?? '') == 'champions' ? 'selected' : '' }}>Champions</option>
                <option value="loyal_customers" {{ old('segment', $rule->segment ?? '') == 'loyal_customers' ? 'selected' : '' }}>Loyal Customers</option>
                <option value="at_risk" {{ old('segment', $rule->segment ?? '') == 'at_risk' ? 'selected' : '' }}>At Risk</option>
                <option value="new_customers" {{ old('segment', $rule->segment ?? '') == 'new_customers' ? 'selected' : '' }}>New Customers</option>
                <option value="dormant" {{ old('segment', $rule->segment ?? '') == 'dormant' ? 'selected' : '' }}>Dormant</option>
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('segment')" />
        </div>
        
        <div>
            <label class="block text-sm font-medium text-spa-charcoal opacity-90">Status</label>
            <select name="status" class="mt-1 block w-full rounded-md border-spa-wood shadow-sm focus:border-[#2c3e38] focus:ring-[#2c3e38]">
                <option value="active" {{ old('status', $rule->status ?? 'active') == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ old('status', $rule->status ?? 'active') == 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('status')" />
        </div>
    </div>

    <!-- Eligibility & Limits -->
    <div class="space-y-6">
        <h3 class="text-lg font-bold text-spa-charcoal border-b pb-2">Eligibility & Limits</h3>
        
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-spa-charcoal opacity-90">Min Total Spent (₱)</label>
                <input type="number" step="0.01" name="minimum_total_spent" value="{{ old('minimum_total_spent', $rule->minimum_total_spent ?? '') }}" class="mt-1 block w-full rounded-md border-spa-wood shadow-sm focus:border-[#2c3e38] focus:ring-[#2c3e38]">
                <x-input-error class="mt-2" :messages="$errors->get('minimum_total_spent')" />
            </div>
            <div>
                <label class="block text-sm font-medium text-spa-charcoal opacity-90">Min Visit Count</label>
                <input type="number" name="minimum_visit_count" value="{{ old('minimum_visit_count', $rule->minimum_visit_count ?? '') }}" class="mt-1 block w-full rounded-md border-spa-wood shadow-sm focus:border-[#2c3e38] focus:ring-[#2c3e38]">
                <x-input-error class="mt-2" :messages="$errors->get('minimum_visit_count')" />
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-spa-charcoal opacity-90">Max Recency Days</label>
                <input type="number" name="maximum_days_since_last_visit" value="{{ old('maximum_days_since_last_visit', $rule->maximum_days_since_last_visit ?? '') }}" class="mt-1 block w-full rounded-md border-spa-wood shadow-sm focus:border-[#2c3e38] focus:ring-[#2c3e38]">
                <x-input-error class="mt-2" :messages="$errors->get('maximum_days_since_last_visit')" />
            </div>
            <div>
                <label class="block text-sm font-medium text-spa-charcoal opacity-90">Min Recency Days</label>
                <input type="number" name="minimum_days_since_last_visit" value="{{ old('minimum_days_since_last_visit', $rule->minimum_days_since_last_visit ?? '') }}" class="mt-1 block w-full rounded-md border-spa-wood shadow-sm focus:border-[#2c3e38] focus:ring-[#2c3e38]">
                <x-input-error class="mt-2" :messages="$errors->get('minimum_days_since_last_visit')" />
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-spa-charcoal opacity-90">Specific Service Only</label>
            <select name="applicable_service_id" class="mt-1 block w-full rounded-md border-spa-wood shadow-sm focus:border-[#2c3e38] focus:ring-[#2c3e38]">
                <option value="">Any Service</option>
                @foreach($services as $service)
                    <option value="{{ $service->id }}" {{ old('applicable_service_id', $rule->applicable_service_id ?? '') == $service->id ? 'selected' : '' }}>{{ $service->name }}</option>
                @endforeach
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('applicable_service_id')" />
        </div>

        <div class="border border-spa-beige p-4 rounded-md bg-spa-cream/50">
            <div class="flex items-center mb-4">
                <input type="checkbox" name="is_off_peak_only" value="1" id="is_off_peak_{{ $modalId ?? 'form' }}" class="rounded border-spa-wood text-[#2c3e38] shadow-sm focus:border-[#2c3e38] focus:ring-[#2c3e38]" {{ old('is_off_peak_only', $rule->is_off_peak_only ?? false) ? 'checked' : '' }}>
                <label for="is_off_peak_{{ $modalId ?? 'form' }}" class="ml-2 block text-sm font-medium text-spa-charcoal opacity-90">Off-Peak Only?</label>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-spa-charcoal opacity-90">Start Time</label>
                    <input type="time" name="off_peak_start_time" value="{{ old('off_peak_start_time', isset($rule) && $rule->off_peak_start_time ? \Carbon\Carbon::parse($rule->off_peak_start_time)->format('H:i') : '') }}" class="mt-1 block w-full rounded-md border-spa-wood shadow-sm focus:border-[#2c3e38] focus:ring-[#2c3e38]">
                    <x-input-error class="mt-2" :messages="$errors->get('off_peak_start_time')" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-spa-charcoal opacity-90">End Time</label>
                    <input type="time" name="off_peak_end_time" value="{{ old('off_peak_end_time', isset($rule) && $rule->off_peak_end_time ? \Carbon\Carbon::parse($rule->off_peak_end_time)->format('H:i') : '') }}" class="mt-1 block w-full rounded-md border-spa-wood shadow-sm focus:border-[#2c3e38] focus:ring-[#2c3e38]">
                    <x-input-error class="mt-2" :messages="$errors->get('off_peak_end_time')" />
                </div>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-spa-charcoal opacity-90">Global Usage Limit</label>
                <input type="number" name="usage_limit" value="{{ old('usage_limit', $rule->usage_limit ?? '') }}" class="mt-1 block w-full rounded-md border-spa-wood shadow-sm focus:border-[#2c3e38] focus:ring-[#2c3e38]">
                <x-input-error class="mt-2" :messages="$errors->get('usage_limit')" />
            </div>
            <div>
                <label class="block text-sm font-medium text-spa-charcoal opacity-90">Per-Customer Limit</label>
                <input type="number" name="per_customer_limit" value="{{ old('per_customer_limit', $rule->per_customer_limit ?? '') }}" class="mt-1 block w-full rounded-md border-spa-wood shadow-sm focus:border-[#2c3e38] focus:ring-[#2c3e38]">
                <x-input-error class="mt-2" :messages="$errors->get('per_customer_limit')" />
            </div>
        </div>
    </div>
</div>
