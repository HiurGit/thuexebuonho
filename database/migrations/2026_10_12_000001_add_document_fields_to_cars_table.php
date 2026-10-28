<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cars', function (Blueprint $table) {
            $table->string('brand')->nullable()->after('name');
            $table->string('model')->nullable()->after('brand');
            $table->string('color')->nullable()->after('model');
            $table->string('chassis_no')->nullable()->after('color');
            $table->string('engine_no')->nullable()->after('chassis_no');
            $table->string('owner')->nullable()->after('engine_no');
        });
    }

    public function down(): void
    {
        Schema::table('cars', function (Blueprint $table) {
            $table->dropColumn(['brand', 'model', 'color', 'chassis_no', 'engine_no', 'owner']);
        });
    }
};
