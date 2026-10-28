<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->string('contract_code')->unique();
            $table->enum('status', ['pending', 'active', 'returned', 'cancelled'])->default('pending');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('branch')->nullable();
            $table->date('contract_date')->nullable();

            $table->string('cccd')->nullable();
            $table->string('customer_name');
            $table->string('customer_phone')->nullable();
            $table->date('cccd_issue_date')->nullable();
            $table->string('cccd_issue_place')->nullable();
            $table->string('customer_address')->nullable();
            $table->string('driver_license_no')->nullable();
            $table->date('license_issue_date')->nullable();
            $table->date('license_expiry_date')->nullable();
            $table->string('license_class')->nullable();

            $table->foreignId('car_id')->nullable()->constrained('cars')->nullOnDelete();
            $table->string('car_name')->nullable();
            $table->string('car_brand')->nullable();
            $table->string('car_model')->nullable();
            $table->string('car_plate')->nullable();
            $table->string('car_color')->nullable();
            $table->integer('car_year')->nullable();

            $table->dateTime('pickup_datetime')->nullable();
            $table->string('pickup_location')->nullable();
            $table->dateTime('return_datetime')->nullable();
            $table->string('return_location')->nullable();
            $table->integer('total_days')->nullable();
            $table->integer('total_hours')->nullable();
            $table->integer('km_limit')->nullable();

            $table->enum('deposit_type', ['cash', 'motorcycle'])->nullable();
            $table->decimal('deposit_amount', 15, 0)->nullable();
            $table->string('deposit_note')->nullable();

            $table->decimal('daily_rate', 15, 0)->default(0);
            $table->integer('rental_days')->default(0);
            $table->decimal('total_rental_fee', 15, 0)->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};