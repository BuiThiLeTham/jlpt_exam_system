<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Level extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'description',
    ];

    /**
     * Các danh mục thuộc cấp độ JLPT này.
     */
    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
    }

    /**
     * Các đề thi thuộc cấp độ JLPT này.
     */
    public function exams(): HasMany
    {
        return $this->hasMany(Exam::class);
    }
}
