<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customer_promotions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('promotion_rule_id')->constrained()->cascadeOnDelete();
            $table->foreignId('customer_id')->constrained('users')->cascadeOnDelete();
            $table->string('code')->unique();
            $table->string('title');
            $table->text('description')->nullable();
            
            // Snapshot of rule discount at generation time
            $table->string('discount_type');
            $table->decimal('discount_value', 10, 2)->default(0);
            
            $table->string('status')->default('available')->comment('available, used, expired, cancelled');
            
            $table->dateTime('generated_at')->nullable();
            $table->dateTime('used_at')->nullable();
            $table->dateTime('expires_at')->nullable();
            
            $table->foreignId('booking_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('transaction_id')->nullable()->constrained()->nullOnDelete();
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customer_promotions');
    }
};
