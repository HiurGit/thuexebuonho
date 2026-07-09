<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('visitor_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('session_id')->nullable()->index();
            $table->string('visitor_token')->index();
            $table->string('ip_address', 45)->nullable()->index();
            $table->text('user_agent')->nullable();
            $table->string('browser')->nullable();
            $table->string('platform')->nullable();
            $table->string('device_type', 20)->nullable();
            $table->text('referer')->nullable();
            $table->text('visited_url');
            $table->string('route_name')->nullable()->index();
            $table->string('method', 10)->default('GET');
            $table->boolean('is_bot')->default(false)->index();
            $table->timestamp('visited_at')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visitor_logs');
    }
};
