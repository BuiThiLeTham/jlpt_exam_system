<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'question_type_id',
        'created_by',
        'content',
        'image_path',
        'audio_path',
        'explanation',
        'difficulty',
        'status',
    ];

    /**
     * Câu hỏi thuộc danh mục nào.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Câu hỏi thuộc dạng bài Mondai nào.
     */
    public function questionType(): BelongsTo
    {
        return $this->belongsTo(QuestionType::class);
    }

    /**
     * Admin đã tạo câu hỏi.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Các đáp án lựa chọn của câu hỏi.
     */
    public function options(): HasMany
    {
        return $this->hasMany(QuestionOption::class);
    }

    /**
     * Các đề thi đang sử dụng câu hỏi.
     */
    public function examQuestions(): HasMany
    {
        return $this->hasMany(ExamQuestion::class);
    }
}
