<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('global_guides', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['usage', 'accident', 'insurance']); // loại hướng dẫn chung
            $table->string('section_title'); // Tiêu đề từng phần: "Trước khi khởi hành"
            $table->text('content'); // Nội dung (HTML)
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('global_guides');
    }
};
