<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('promotion_rules', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            
            // RFM Targeting
            $table->string('segment')->nullable()->comment('champions, loyal_customers, at_risk, new_customers, dormant, all');
            
            // Discount Definition
            $table->string('discount_type')->default('percentage')->comment('percentage, fixed, free_service');
            $table->decimal('discount_value', 10, 2)->default(0);
            
            // Eligibility Rules
            $table->decimal('minimum_total_spent', 10, 2)->nullable();
            $table->integer('minimum_visit_count')->nullable();
            $table->integer('maximum_days_since_last_visit')->nullable();
            $table->integer('minimum_days_since_last_visit')->nullable();
            $table->foreignId('applicable_service_id')->nullable()->constrained('services')->nullOnDelete();
            
            // Peak/Off-peak rules
            $table->boolean('is_off_peak_only')->default(false);
            $table->time('off_peak_start_time')->nullable();
            $table->time('off_peak_end_time')->nullable();
            
            // Validity and Limits
            $table->date('valid_from')->nullable();
            $table->date('valid_until')->nullable();
            $table->integer('usage_limit')->nullable();
            $table->integer('per_customer_limit')->nullable();
            
            // Status
            $table->string('status')->default('active')->comment('active, inactive');
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('promotion_rules');
    }
};
