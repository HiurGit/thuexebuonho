<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('visitors', function (Blueprint $table) {
            $table->dropColumn(['user_agent', 'browser', 'platform', 'device_type', 'is_bot']);
        });
    }

    public function down(): void
    {
        Schema::table('visitors', function (Blueprint $table) {
            $table->text('user_agent')->nullable()->after('ip_address');
            $table->string('browser')->nullable()->after('user_agent');
            $table->string('platform')->nullable()->after('browser');
            $table->string('device_type', 20)->nullable()->after('platform');
            $table->boolean('is_bot')->default(false)->after('device_type');
        });
    }
};
