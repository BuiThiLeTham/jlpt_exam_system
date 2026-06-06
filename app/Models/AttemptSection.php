<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AttemptSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'exam_attempt_id',
        'exam_section_id',
        'started_at',
        'submitted_at',
        'score',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'started_at' => 'datetime',
            'submitted_at' => 'datetime',
            'score' => 'decimal:2',
        ];
    }

    /**
     * Phần bài làm thuộc lượt thi nào.
     */
    public function examAttempt(): BelongsTo
    {
        return $this->belongsTo(ExamAttempt::class);
    }

    /**
     * Cấu hình phần thi gốc.
     */
    public function examSection(): BelongsTo
    {
        return $this->belongsTo(ExamSection::class);
    }

    /**
     * Các câu trả lời trong phần thi.
     */
    public function answers(): HasMany
    {
        return $this->hasMany(AttemptAnswer::class);
    }
}
