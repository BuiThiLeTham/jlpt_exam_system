<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('exam_attempts', function (Blueprint $table) {
            $table->id();

            $table->foreignId('exam_id')
                ->constrained('exams')
                ->restrictOnDelete();

            // Có giá trị nếu người thi đã đăng nhập
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            // Có giá trị nếu người thi là khách vãng lai
            $table->foreignId('lead_id')
                ->nullable()
                ->constrained('leads')
                ->nullOnDelete();

            // full_exam: thi toàn bộ đề
            // selected_sections: chọn phần để luyện
            $table->string('mode', 30)->default('full_exam');

            $table->timestamp('started_at')->nullable();
            $table->timestamp('submitted_at')->nullable();

            $table->decimal('total_score', 8, 2)->default(0);

            $table->unsignedInteger('correct_count')->default(0);
            $table->unsignedInteger('wrong_count')->default(0);
            $table->unsignedInteger('unanswered_count')->default(0);

            // in_progress: đang làm
            // submitted: đã nộp
            $table->string('status', 20)->default('in_progress');

            $table->boolean('is_passed')->nullable();

            $table->timestamps();

            $table->index([
                'exam_id',
                'status',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exam_attempts');
    }
};
