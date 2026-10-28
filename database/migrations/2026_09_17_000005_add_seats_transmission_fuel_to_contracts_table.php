<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contracts', function (Blueprint $table) {
            $table->integer('car_seats')->nullable()->after('car_year');
            $table->string('car_transmission', 50)->nullable()->after('car_seats');
            $table->string('car_fuel', 50)->nullable()->after('car_transmission');
        });
    }

    public function down(): void
    {
        Schema::table('contracts', function (Blueprint $table) {
            $table->dropColumn(['car_seats', 'car_transmission', 'car_fuel']);
        });
    }
};