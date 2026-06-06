<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AttemptAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'exam_attempt_id',
        'attempt_section_id',
        'exam_question_id',
        'selected_option_id',
        'is_correct',
        'score',
        'is_marked_for_review',
        'answered_at',
    ];

    protected function casts(): array
    {
        return [
            'is_correct' => 'boolean',
            'score' => 'decimal:2',
            'is_marked_for_review' => 'boolean',
            'answered_at' => 'datetime',
        ];
    }

    /**
     * Câu trả lời thuộc lượt thi nào.
     */
    public function examAttempt(): BelongsTo
    {
        return $this->belongsTo(ExamAttempt::class);
    }

    /**
     * Câu trả lời thuộc phần thi nào.
     */
    public function attemptSection(): BelongsTo
    {
        return $this->belongsTo(AttemptSection::class);
    }

    /**
     * Câu hỏi cụ thể trong đề thi.
     */
    public function examQuestion(): BelongsTo
    {
        return $this->belongsTo(ExamQuestion::class);
    }

    /**
     * Đáp án người thi đã chọn.
     */
    public function selectedOption(): BelongsTo
    {
        return $this->belongsTo(
            QuestionOption::class,
            'selected_option_id'
        );
    }
}
