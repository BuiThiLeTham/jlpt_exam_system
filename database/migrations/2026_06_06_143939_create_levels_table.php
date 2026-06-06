<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('levels', function (Blueprint $table) {
            $table->id();

            // Mã cấp độ: N5, N4, N3, N2, N1
            $table->string('code', 10)->unique();

            // Tên hiển thị, ví dụ: JLPT N5
            $table->string('name');

            // Nội dung mô tả thêm cho cấp độ
            $table->text('description')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('levels');
    }
};
