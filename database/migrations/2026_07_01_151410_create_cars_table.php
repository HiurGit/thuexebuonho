<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->integer('seats')->default(5);
            $table->string('transmission')->default('Tự động'); // Tự động, Số sàn
            $table->string('fuel')->default('Máy xăng'); // Máy xăng, Máy dầu, Điện
            $table->string('fuel_consumption')->nullable(); // 6l/100km
            $table->integer('year')->nullable();
            $table->string('insurance')->default('Đầy đủ');
            $table->string('address')->default('07 Chu Văn An, Buôn Hồ');
            
            // Pricing
            $table->decimal('price_per_day', 12, 0)->default(650000);
            $table->decimal('price_per_session', 12, 0)->default(350000);
            $table->decimal('price_multi_day', 12, 0)->nullable(); // discount for 3+ days
            $table->decimal('price_out_province', 12, 0)->nullable(); // extra for out of province

            // Deposit
            $table->decimal('deposit_min', 12, 0)->default(300000);
            $table->decimal('deposit_max', 12, 0)->default(1000000);
            $table->decimal('deposit_asset', 12, 0)->default(15000000); // or motorbike value

            // Status
            $table->enum('status', ['available', 'rented', 'maintenance'])->default('available');
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
