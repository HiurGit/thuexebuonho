<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->foreignId('collaborator_id')->nullable()->after('car_id')
                ->constrained('collaborators')->nullOnDelete();
            $table->string('referral_code', 50)->nullable()->after('collaborator_id')->index();
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropForeign(['collaborator_id']);
            $table->dropIndex(['referral_code']);
            $table->dropColumn(['collaborator_id', 'referral_code']);
        });
    }
};
