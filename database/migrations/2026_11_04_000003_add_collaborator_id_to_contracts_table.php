<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contracts', function (Blueprint $table) {
            $table->foreignId('collaborator_id')->nullable()->after('created_by')
                ->constrained('collaborators')->nullOnDelete();
            $table->string('referral_source', 30)->nullable()->after('collaborator_id');
        });
    }

    public function down(): void
    {
        Schema::table('contracts', function (Blueprint $table) {
            $table->dropForeign(['collaborator_id']);
            $table->dropColumn(['collaborator_id', 'referral_source']);
        });
    }
};
