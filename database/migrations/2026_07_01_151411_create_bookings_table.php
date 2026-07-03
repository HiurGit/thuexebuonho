<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('car_id')->constrained()->cascadeOnDelete();
            $table->string('customer_name')->nullable();
            $table->string('customer_phone');
            
            // Rental type
            $table->enum('rental_type', ['one-day', 'multi-day', 'hourly'])->default('one-day');
            
            // Dates
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('start_time')->default('06:00');
            $table->string('end_time')->default('22:00');
            
            // Session (for hourly)
            $table->string('session_type')->nullable(); // sang, chieu, toi
            
            // Pickup
            $table->enum('pickup_type', ['shop', 'delivery'])->default('shop');
            
            // Pricing
            $table->integer('days')->default(1);
            $table->decimal('total_price', 12, 0)->default(0);
            $table->decimal('deposit', 12, 0)->default(0);
            
            // Status
            $table->enum('status', ['pending', 'confirmed', 'delivered', 'completed', 'cancelled'])->default('pending');
            
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
