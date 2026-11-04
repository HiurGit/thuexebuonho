<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('collaborator_customers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('collaborator_id')->constrained('collaborators')->cascadeOnDelete();
            $table->string('customer_name')->nullable();
            $table->string('customer_phone', 30)->nullable()->unique();
            $table->string('cccd', 50)->nullable()->unique();
            $table->string('source', 30)->nullable();
            $table->foreignId('booking_id')->nullable()->constrained('bookings')->nullOnDelete();
            $table->foreignId('contract_id')->nullable()->constrained('contracts')->nullOnDelete();
            $table->text('note')->nullable();
            $table->timestamps();

            $table->index(['collaborator_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('collaborator_customers');
    }
};
