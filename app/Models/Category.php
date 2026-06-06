<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'level_id',
        'name',
        'slug',
        'description',
    ];

    /**
     * Danh mục thuộc cấp độ JLPT nào.
     */
    public function level(): BelongsTo
    {
        return $this->belongsTo(Level::class);
    }

    /**
     * Các dạng bài Mondai thuộc danh mục.
     */
    public function questionTypes(): HasMany
    {
        return $this->hasMany(QuestionType::class);
    }

    /**
     * Các câu hỏi thuộc danh mục.
     */
    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }
}
