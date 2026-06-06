<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attempt_sections', function (Blueprint $table) {
            $table->id();

            $table->foreignId('exam_attempt_id')
                ->constrained('exam_attempts')
                ->cascadeOnDelete();

            $table->foreignId('exam_section_id')
                ->constrained('exam_sections')
                ->restrictOnDelete();

            $table->timestamp('started_at')->nullable();
            $table->timestamp('submitted_at')->nullable();

            $table->decimal('score', 8, 2)->default(0);

            // pending: chưa làm
            // in_progress: đang làm
            // submitted: đã nộp phần
            $table->string('status', 20)->default('pending');

            $table->timestamps();

            $table->unique([
                'exam_attempt_id',
                'exam_section_id',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attempt_sections');
    }
};
