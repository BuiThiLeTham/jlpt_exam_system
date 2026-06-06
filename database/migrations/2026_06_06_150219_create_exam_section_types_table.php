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
        Schema::create('exam_section_types', function (Blueprint $table) {
            $table->id();

            // Mondai thuộc phần thi nào
            $table->foreignId('exam_section_id')
                ->constrained('exam_sections')
                ->cascadeOnDelete();

            // Liên kết với dạng bài trong ngân hàng câu hỏi
            $table->foreignId('question_type_id')
                ->constrained('question_types')
                ->restrictOnDelete();

            // Tổng số câu cần lấy cho Mondai này
            $table->unsignedInteger('total_questions');

            // Tổng điểm của Mondai
            $table->decimal('total_score', 8, 2);

            // Thứ tự Mondai trong phần thi
            $table->unsignedInteger('sort_order')->default(1);

            $table->timestamps();

            // Không được thêm trùng một Mondai trong cùng phần thi
            $table->unique([
                'exam_section_id',
                'question_type_id',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_section_types');
    }
};
