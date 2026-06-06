<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ExamSectionType extends Model
{
    use HasFactory;

    protected $fillable = [
        'exam_section_id',
        'question_type_id',
        'total_questions',
        'total_score',
        'score_mode',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'total_questions' => 'integer',
            'total_score' => 'decimal:2',
            'sort_order' => 'integer',
        ];
    }

    /**
     * Mondai thuộc phần thi nào.
     */
    public function examSection(): BelongsTo
    {
        return $this->belongsTo(ExamSection::class);
    }

    /**
     * Dạng bài trong ngân hàng câu hỏi.
     */
    public function questionType(): BelongsTo
    {
        return $this->belongsTo(QuestionType::class);
    }

    /**
     * Các câu hỏi được gán vào Mondai này.
     */
    public function examQuestions(): HasMany
    {
        return $this->hasMany(ExamQuestion::class)
            ->orderBy('sort_order');
    }
}
