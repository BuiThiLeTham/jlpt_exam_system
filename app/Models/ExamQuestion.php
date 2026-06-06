<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ExamQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'exam_section_type_id',
        'question_id',
        'score',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'score' => 'decimal:2',
            'sort_order' => 'integer',
        ];
    }

    /**
     * Câu hỏi thuộc Mondai nào trong đề thi.
     */
    public function examSectionType(): BelongsTo
    {
        return $this->belongsTo(ExamSectionType::class);
    }

    /**
     * Nội dung lấy từ ngân hàng câu hỏi.
     */
    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

    /**
     * Các câu trả lời của người thi cho câu hỏi này.
     */
    public function attemptAnswers(): HasMany
    {
        return $this->hasMany(AttemptAnswer::class);
    }
}
