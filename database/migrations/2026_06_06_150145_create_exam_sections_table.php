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
        Schema::create('exam_sections', function (Blueprint $table) {
            $table->id();

            // Phần thi thuộc đề thi nào
            $table->foreignId('exam_id')
                ->constrained('exams')
                ->cascadeOnDelete();

            // Ví dụ: Chữ - Từ vựng, Ngữ pháp - Đọc hiểu, Nghe hiểu
            $table->string('name');

            // Hướng dẫn riêng cho phần thi
            $table->text('instructions')->nullable();

            // Thời gian làm phần thi, tính bằng phút
            $table->unsignedInteger('duration_minutes');

            // Tổng số câu dự kiến trong phần thi
            $table->unsignedInteger('total_questions');

            // Tổng điểm của phần thi
            $table->decimal('total_score', 8, 2);

            // Thứ tự hiển thị của phần thi
            $table->unsignedInteger('sort_order')->default(1);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_sections');
    }
};
