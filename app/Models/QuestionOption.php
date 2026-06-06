<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class QuestionOption extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_id',
        'label',
        'content',
        'is_correct',
    ];

    protected function casts(): array
    {
        return [
            'is_correct' => 'boolean',
        ];
    }

    /**
     * Đáp án thuộc câu hỏi nào.
     */
    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

    /**
     * Các lượt chọn đáp án này trong bài làm.
     */
    public function attemptAnswers(): HasMany
    {
        return $this->hasMany(AttemptAnswer::class, 'selected_option_id');
    }
}
