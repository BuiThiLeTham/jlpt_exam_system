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
        Schema::create('exams', function (Blueprint $table) {
            $table->id();

            // Cấp độ đề thi: N5, N4, N3, N2 hoặc N1
            $table->foreignId('level_id')
                ->constrained('levels')
                ->restrictOnDelete();

            // Admin tạo đề thi
            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            // Thông tin hiển thị cơ bản
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();

            // fixed: đề cố định
            // random: lấy câu hỏi ngẫu nhiên theo cấu trúc
            $table->string('exam_mode', 20)->default('fixed');

            // practice: kiểm tra hoặc thực hành
            // mock_test: thi thử hoặc test kiến thức
            $table->string('exam_type', 20)->default('mock_test');

            // registered: chỉ sinh viên đã đăng ký
            // guest_and_registered: khách vãng lai và sinh viên
            $table->string('participant_type', 30)
                ->default('guest_and_registered');

            // Có được chọn từng phần để luyện tập hay không
            $table->boolean('allow_partial_sections')->default(false);

            // Sau khi nộp bài có được xem đáp án và giải thích hay không
            $table->boolean('allow_explanation')->default(true);

            // Audio bài nghe có cho phép tua hay không
            $table->boolean('allow_audio_seek')->default(false);

            // Tổng thời gian làm bài
            $table->unsignedInteger('duration_minutes')->nullable();

            // Để null nếu không giới hạn số lượt thi
            $table->unsignedInteger('max_attempts')->nullable();

            // Điểm tối thiểu để đạt
            $table->decimal('passing_score', 8, 2)->nullable();

            // Để null nếu đề thi luôn mở
            $table->timestamp('open_at')->nullable();
            $table->timestamp('close_at')->nullable();

            // Để null nếu đề thi không yêu cầu mật khẩu
            $table->string('access_password')->nullable();

            // immediate: hiển thị kết quả ngay
            // manual: chờ admin công bố
            $table->string('result_publish_mode', 20)
                ->default('immediate');

            // draft: bản nháp
            // published: đã phát hành
            $table->string('status', 20)->default('draft');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exams');
    }
};
