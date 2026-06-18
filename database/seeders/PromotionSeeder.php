<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PromotionRule;
use App\Models\User;
use App\Services\PromotionEngineService;

class PromotionSeeder extends Seeder
{
    public function run(PromotionEngineService $engine): void
    {
        // 1. Create Promotion Rules
        PromotionRule::create([
            'name' => '10% Off Off-Peak Massage',
            'description' => 'Enjoy 10% off any massage during our quiet hours (10:00 AM - 2:00 PM).',
            'segment' => 'all',
            'discount_type' => 'percentage',
            'discount_value' => 10,
            'is_off_peak_only' => true,
            'off_peak_start_time' => '10:00:00',
            'off_peak_end_time' => '14:00:00',
            'status' => 'active',
        ]);

        PromotionRule::create([
            'name' => 'Champion Reward: ₱300 Off',
            'description' => 'A special thank you for our best customers. Get ₱300 off your next visit.',
            'segment' => 'champions',
            'discount_type' => 'fixed',
            'discount_value' => 300,
            'per_customer_limit' => 1,
            'status' => 'active',
        ]);

        PromotionRule::create([
            'name' => 'Welcome Back! 20% Off',
            'description' => 'We miss you! Come back and enjoy 20% off any service.',
            'segment' => 'dormant',
            'discount_type' => 'percentage',
            'discount_value' => 20,
            'minimum_days_since_last_visit' => 90,
            'status' => 'active',
        ]);

        PromotionRule::create([
            'name' => 'Loyalty Reward: Free Add-on Service',
            'description' => 'As a loyal customer, your next basic service is free!',
            'segment' => 'loyal_customers',
            'discount_type' => 'free_service',
            'discount_value' => 0,
            'minimum_visit_count' => 5,
            'status' => 'active',
        ]);

        // 2. Generate initial RFM and promos
        // Assuming DatabaseSeeder already ran and created users and transactions
        $engine->generateForAllCustomers();
    }
}
