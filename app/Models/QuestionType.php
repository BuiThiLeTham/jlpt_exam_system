<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class QuestionType extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'description',
    ];

    /**
     * Mondai thuộc danh mục nào.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Các câu hỏi thuộc Mondai này.
     */
    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    /**
     * Các cấu hình đề thi đang sử dụng Mondai này.
     */
    public function examSectionTypes(): HasMany
    {
        return $this->hasMany(ExamSectionType::class);
    }
}
