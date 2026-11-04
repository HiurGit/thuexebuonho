<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('collaborator_commissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('collaborator_id')->constrained('collaborators')->cascadeOnDelete();
            $table->foreignId('contract_id')->unique()->constrained('contracts')->cascadeOnDelete();
            $table->string('contract_code', 50)->nullable();
            $table->string('customer_name')->nullable();
            $table->string('customer_phone', 30)->nullable();
            $table->decimal('contract_total', 15, 0)->default(0);
            $table->decimal('commission_rate', 5, 2)->default(10);
            $table->decimal('commission_amount', 15, 0)->default(0);
            $table->string('status', 20)->default('pending')->index();
            $table->timestamp('recognized_at')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->foreignId('paid_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('payment_note')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();

            $table->index(['collaborator_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('collaborator_commissions');
    }
};
