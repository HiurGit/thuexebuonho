<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contracts', function (Blueprint $table) {
            $table->string('car_chassis')->nullable()->after('car_year');
            $table->string('car_engine')->nullable()->after('car_chassis');
            $table->string('car_owner')->nullable()->after('car_engine');
            $table->string('deposit_moto_brand')->nullable()->after('deposit_note');
            $table->string('deposit_moto_plate')->nullable()->after('deposit_moto_brand');
            $table->string('deposit_moto_registration')->nullable()->after('deposit_moto_plate');
            $table->string('deposit_other')->nullable()->after('deposit_moto_registration');
        });
    }

    public function down(): void
    {
        Schema::table('contracts', function (Blueprint $table) {
            $table->dropColumn([
                'car_chassis', 'car_engine', 'car_owner',
                'deposit_moto_brand', 'deposit_moto_plate', 'deposit_moto_registration', 'deposit_other',
            ]);
        });
    }
};
