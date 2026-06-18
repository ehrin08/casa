<?php

namespace App\Services;

use App\Models\User;
use App\Models\PromotionRule;
use App\Models\CustomerPromotion;
use App\Models\CustomerRfmSnapshot;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Support\Str;

class PromotionEngineService
{
    /**
     * Generate applicable promotions for a single customer based on active rules.
     */
    public function generateForCustomer(User $customer): array
    {
        $snapshot = $customer->rfmSnapshot;
        if (!$snapshot) {
            // Need a snapshot to evaluate segment-based rules
            return [];
        }

        $activeRules = PromotionRule::where('status', 'active')->get();
        $generatedPromotions = [];

        foreach ($activeRules as $rule) {
            if ($this->isRuleEligibleForCustomer($rule, $customer, $snapshot)) {
                
                // Prevent duplicate active promotion of the same rule
                $existing = CustomerPromotion::where('customer_id', $customer->id)
                    ->where('promotion_rule_id', $rule->id)
                    ->where('status', 'available')
                    ->first();
                
                if (!$existing) {
                    $expiresAt = $rule->valid_until 
                        ? Carbon::parse($rule->valid_until)->endOfDay() 
                        : now()->addDays(30);

                    $promo = CustomerPromotion::create([
                        'promotion_rule_id' => $rule->id,
                        'customer_id' => $customer->id,
                        'code' => 'CP-PROMO-' . strtoupper(Str::random(6)),
                        'title' => $rule->name,
                        'description' => $rule->description,
                        'discount_type' => $rule->discount_type,
                        'discount_value' => $rule->discount_value,
                        'status' => 'available',
                        'generated_at' => now(),
                        'expires_at' => $expiresAt,
                    ]);
                    $generatedPromotions[] = $promo;
                }
            }
        }

        return $generatedPromotions;
    }

    /**
     * Generate for all customers.
     */
    public function generateForAllCustomers(): int
    {
        // Typically, we recalculate RFM first
        app(RfmService::class)->calculateAllCustomers();

        $customers = User::where('role', 'customer')->with('rfmSnapshot')->get();
        $totalGenerated = 0;

        foreach ($customers as $customer) {
            $promos = $this->generateForCustomer($customer);
            $totalGenerated += count($promos);
        }

        return $totalGenerated;
    }

    /**
     * Check if a rule applies to the customer based on RFM and limits.
     */
    public function isRuleEligibleForCustomer(PromotionRule $rule, User $customer, CustomerRfmSnapshot $snapshot): bool
    {
        // 1. Segment check
        if ($rule->segment && $rule->segment !== 'all') {
            if ($snapshot->segment !== $rule->segment) {
                return false;
            }
        }

        // 2. Minimum total spent
        if ($rule->minimum_total_spent && $snapshot->monetary_total < $rule->minimum_total_spent) {
            return false;
        }

        // 3. Minimum visit count
        if ($rule->minimum_visit_count && $snapshot->frequency_count < $rule->minimum_visit_count) {
            return false;
        }

        // 4. Recency constraints
        if ($rule->maximum_days_since_last_visit && $snapshot->recency_days > $rule->maximum_days_since_last_visit) {
            return false;
        }
        if ($rule->minimum_days_since_last_visit && $snapshot->recency_days < $rule->minimum_days_since_last_visit) {
            return false;
        }

        // 5. Per-customer limit
        if ($rule->per_customer_limit) {
            $usedCount = CustomerPromotion::where('customer_id', $customer->id)
                ->where('promotion_rule_id', $rule->id)
                ->where('status', 'used')
                ->count();
            if ($usedCount >= $rule->per_customer_limit) {
                return false;
            }
        }

        // 6. Global usage limit
        if ($rule->usage_limit) {
            $globalUsedCount = CustomerPromotion::where('promotion_rule_id', $rule->id)
                ->where('status', 'used')
                ->count();
            if ($globalUsedCount >= $rule->usage_limit) {
                return false;
            }
        }

        return true;
    }

    /**
     * Validate if a customer promotion can be applied to a specific booking request.
     */
    public function isPromoValidForBooking(CustomerPromotion $promotion, $serviceId, $bookingDate, $startTime): array
    {
        if ($promotion->status !== 'available') {
            return ['valid' => false, 'message' => 'Promotion is not available.'];
        }

        if ($promotion->expires_at && now()->isAfter($promotion->expires_at)) {
            $promotion->update(['status' => 'expired']);
            return ['valid' => false, 'message' => 'Promotion has expired.'];
        }

        $rule = $promotion->rule;

        if ($rule->status !== 'active') {
            return ['valid' => false, 'message' => 'The underlying promotion rule is no longer active.'];
        }

        if ($rule->applicable_service_id && $rule->applicable_service_id != $serviceId) {
            return ['valid' => false, 'message' => 'This promotion is only applicable to a specific service.'];
        }

        if ($rule->is_off_peak_only) {
            $time = Carbon::parse($startTime)->format('H:i:s');
            $start = $rule->off_peak_start_time ?? '00:00:00';
            $end = $rule->off_peak_end_time ?? '23:59:59';
            if ($time < $start || $time > $end) {
                return ['valid' => false, 'message' => 'This promotion is only valid during off-peak hours (' . $start . ' - ' . $end . ').'];
            }
        }

        return ['valid' => true, 'message' => 'Valid.'];
    }

    /**
     * Calculate discount amount safely.
     */
    public function calculateDiscountAmount(CustomerPromotion $promotion, float $subtotal): float
    {
        if ($promotion->discount_type === 'percentage') {
            $amount = $subtotal * ($promotion->discount_value / 100);
        } elseif ($promotion->discount_type === 'fixed') {
            $amount = $promotion->discount_value;
        } elseif ($promotion->discount_type === 'free_service') {
            // Treat as 100% discount
            $amount = $subtotal;
        } else {
            $amount = 0;
        }

        // Prevent negative final totals
        if ($amount > $subtotal) {
            $amount = $subtotal;
        }

        return round($amount, 2);
    }
}
