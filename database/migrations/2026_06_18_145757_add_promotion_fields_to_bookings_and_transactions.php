<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Note: Since this is added later, we shouldn't define foreign key constraint to customer_promotions
            // directly if customer_promotions table doesn't exist yet, but since migrations run in order,
            // we should be safe. However, to avoid circular dependencies, we can just use bigInteger.
            $table->unsignedBigInteger('customer_promotion_id')->nullable()->after('status');
            $table->string('promo_code')->nullable()->after('customer_promotion_id');
            $table->decimal('original_amount', 10, 2)->nullable()->after('service_price');
            $table->decimal('discount_amount', 10, 2)->default(0)->after('original_amount');
            $table->decimal('final_amount', 10, 2)->nullable()->after('discount_amount');
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->unsignedBigInteger('customer_promotion_id')->nullable()->after('therapist_id');
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn([
                'customer_promotion_id',
                'promo_code',
                'original_amount',
                'discount_amount',
                'final_amount'
            ]);
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('customer_promotion_id');
        });
    }
};
