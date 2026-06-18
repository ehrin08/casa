<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customer_rfm_snapshots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('users')->cascadeOnDelete();
            
            $table->integer('recency_days')->nullable();
            $table->integer('frequency_count')->default(0);
            $table->decimal('monetary_total', 10, 2)->default(0);
            
            $table->integer('recency_score')->default(1);
            $table->integer('frequency_score')->default(1);
            $table->integer('monetary_score')->default(1);
            
            $table->string('rfm_score')->nullable();
            $table->string('segment')->nullable();
            
            $table->dateTime('calculated_at')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customer_rfm_snapshots');
    }
};
