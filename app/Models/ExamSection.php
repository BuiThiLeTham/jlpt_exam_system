<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ExamSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'exam_id',
        'name',
        'instructions',
        'duration_minutes',
        'total_questions',
        'total_score',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'duration_minutes' => 'integer',
            'total_questions' => 'integer',
            'total_score' => 'decimal:2',
            'sort_order' => 'integer',
        ];
    }

    /**
     * Phần thi thuộc đề nào.
     */
    public function exam(): BelongsTo
    {
        return $this->belongsTo(Exam::class);
    }

    /**
     * Các Mondai nằm trong phần thi.
     */
    public function sectionTypes(): HasMany
    {
        return $this->hasMany(ExamSectionType::class)
            ->orderBy('sort_order');
    }

    /**
     * Các lượt làm phần thi này.
     */
    public function attemptSections(): HasMany
    {
        return $this->hasMany(AttemptSection::class);
    }
}
