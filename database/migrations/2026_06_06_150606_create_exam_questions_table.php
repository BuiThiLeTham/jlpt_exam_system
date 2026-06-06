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
        Schema::create('exam_questions', function (Blueprint $table) {
            $table->id();

            // Câu hỏi được đưa vào Mondai nào của đề thi
            $table->foreignId('exam_section_type_id')
                ->constrained('exam_section_types')
                ->cascadeOnDelete();

            // Câu hỏi lấy từ ngân hàng câu hỏi
            $table->foreignId('question_id')
                ->constrained('questions')
                ->restrictOnDelete();

            // Điểm riêng của câu hỏi
            $table->decimal('score', 8, 2)->default(0);

            // Thứ tự câu hỏi trong Mondai
            $table->unsignedInteger('sort_order')->default(1);

            $table->timestamps();

            // Không được thêm trùng một câu hỏi vào cùng một Mondai
            $table->unique([
                'exam_section_type_id',
                'question_id',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_questions');
    }
};
