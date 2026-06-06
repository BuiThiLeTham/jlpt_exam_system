<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ExamAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'exam_id',
        'user_id',
        'lead_id',
        'mode',
        'started_at',
        'submitted_at',
        'total_score',
        'correct_count',
        'wrong_count',
        'unanswered_count',
        'status',
        'is_passed',
    ];

    protected function casts(): array
    {
        return [
            'started_at' => 'datetime',
            'submitted_at' => 'datetime',
            'total_score' => 'decimal:2',
            'correct_count' => 'integer',
            'wrong_count' => 'integer',
            'unanswered_count' => 'integer',
            'is_passed' => 'boolean',
        ];
    }

    /**
     * Lượt thi thuộc đề nào.
     */
    public function exam(): BelongsTo
    {
        return $this->belongsTo(Exam::class);
    }

    /**
     * Người thi đã đăng nhập.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Khách vãng lai làm bài thi thử.
     */
    public function lead(): BelongsTo
    {
        return $this->belongsTo(Lead::class);
    }

    /**
     * Các phần thực tế được chọn để làm.
     */
    public function attemptSections(): HasMany
    {
        return $this->hasMany(AttemptSection::class);
    }

    /**
     * Toàn bộ câu trả lời của lượt thi.
     */
    public function answers(): HasMany
    {
        return $this->hasMany(AttemptAnswer::class);
    }
}
