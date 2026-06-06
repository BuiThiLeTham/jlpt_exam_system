<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lead extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'phone',
        'email',
    ];

    /**
     * Các lượt thi thử của khách vãng lai.
     */
    public function examAttempts(): HasMany
    {
        return $this->hasMany(ExamAttempt::class);
    }
}
