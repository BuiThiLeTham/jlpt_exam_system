<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Exam extends Model
{
    use HasFactory;

    protected $fillable = [
        'level_id',
        'created_by',
        'title',
        'slug',
        'description',
        'exam_mode',
        'exam_type',
        'participant_type',
        'allow_partial_sections',
        'allow_explanation',
        'allow_audio_seek',
        'duration_minutes',
        'max_attempts',
        'passing_score',
        'open_at',
        'close_at',
        'access_password',
        'result_publish_mode',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'allow_partial_sections' => 'boolean',
            'allow_explanation' => 'boolean',
            'allow_audio_seek' => 'boolean',
            'duration_minutes' => 'integer',
            'max_attempts' => 'integer',
            'passing_score' => 'decimal:2',
            'open_at' => 'datetime',
            'close_at' => 'datetime',
        ];
    }

    /**
     * Đề thi thuộc cấp độ JLPT nào.
     */
    public function level(): BelongsTo
    {
        return $this->belongsTo(Level::class);
    }

    /**
     * Admin tạo đề thi.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Các phần thi lớn của đề.
     */
    public function sections(): HasMany
    {
        return $this->hasMany(ExamSection::class)
            ->orderBy('sort_order');
    }

    /**
     * Các lượt làm bài của đề thi.
     */
    public function attempts(): HasMany
    {
        return $this->hasMany(ExamAttempt::class);
    }

    /**
     * Kiểm tra đề đã phát hành hay chưa.
     */
    public function isPublished(): bool
    {
        return $this->status === 'published';
    }
}
