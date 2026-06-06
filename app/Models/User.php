<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'role',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Các câu hỏi do admin này tạo.
     */
    public function createdQuestions(): HasMany
    {
        return $this->hasMany(Question::class, 'created_by');
    }

    /**
     * Các đề thi do admin này tạo.
     */
    public function createdExams(): HasMany
    {
        return $this->hasMany(Exam::class, 'created_by');
    }

    /**
     * Các lượt thi của học viên đã đăng nhập.
     */
    public function examAttempts(): HasMany
    {
        return $this->hasMany(ExamAttempt::class);
    }

    /**
     * Kiểm tra người dùng có phải admin hay không.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Kiểm tra tài khoản có đang hoạt động hay không.
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }
}
