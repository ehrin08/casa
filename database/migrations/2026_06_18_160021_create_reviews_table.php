<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->unique()->constrained()->cascadeOnDelete();
            $table->foreignId('customer_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('service_id')->constrained()->cascadeOnDelete();
            $table->foreignId('therapist_id')->constrained()->cascadeOnDelete();
            
            $table->integer('rating'); // 1 to 5
            $table->text('comment');
            $table->json('tags')->nullable();
            
            $table->string('sentiment'); // 'positive' or 'negative'
            $table->decimal('sentiment_score', 5, 2)->default(0);
            $table->string('key_snippet')->nullable();
            
            $table->string('status')->default('visible'); // 'visible' or 'hidden'
            $table->timestamp('reviewed_at')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
