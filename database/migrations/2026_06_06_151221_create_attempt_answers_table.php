<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attempt_answers', function (Blueprint $table) {
            $table->id();

            $table->foreignId('exam_attempt_id')
                ->constrained('exam_attempts')
                ->cascadeOnDelete();

            $table->foreignId('attempt_section_id')
                ->constrained('attempt_sections')
                ->cascadeOnDelete();

            $table->foreignId('exam_question_id')
                ->constrained('exam_questions')
                ->restrictOnDelete();

            // Nullable vì người dùng có thể chưa chọn đáp án
            $table->foreignId('selected_option_id')
                ->nullable()
                ->constrained('question_options')
                ->nullOnDelete();

            $table->boolean('is_correct')->nullable();
            $table->decimal('score', 8, 2)->default(0);

            // Đánh dấu câu hỏi cần xem lại
            $table->boolean('is_marked_for_review')->default(false);

            $table->timestamp('answered_at')->nullable();

            $table->timestamps();

            $table->unique([
                'attempt_section_id',
                'exam_question_id',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attempt_answers');
    }
};
