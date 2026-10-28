<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contracts', function (Blueprint $table) {
            $table->date('dob')->nullable()->after('customer_phone');
            $table->string('gender', 20)->nullable()->after('dob');
        });
    }

    public function down(): void
    {
        Schema::table('contracts', function (Blueprint $table) {
            $table->dropColumn(['dob', 'gender']);
        });
    }
};