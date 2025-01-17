<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'title',
        'questions',
        'media',
        'passing_score',
        'time_limit',
        'is_published',
        'attempts_allowed'
    ];

    protected $casts = [
        'questions' => 'array',
        'media' => 'array',
        'is_published' => 'boolean',
        'passing_score' => 'integer',
        'time_limit' => 'integer',
        'attempts_allowed' => 'integer'
    ];

    protected $attributes = [
        'passing_score' => 60,
        'time_limit' => 30,
        'attempts_allowed' => 3,
        'is_published' => false
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function results(): HasMany
    {
        return $this->hasMany(QuizResult::class);
    }

    public function getUserAttemptCount($userId): int
    {
        return $this->results()
            ->where('user_id', $userId)
            ->count();
    }

    public function canUserTakeQuiz($userId): bool
    {
        if ($this->attempts_allowed === 0) return true;
        return $this->getUserAttemptCount($userId) < $this->attempts_allowed;
    }

    public function getHighestScore($userId): float
    {
        $highestResult = $this->results()
            ->where('user_id', $userId)
            ->orderByDesc('percentage_score')
            ->first();

        return $highestResult ? $highestResult->percentage_score : 0;
    }

    public function hasUserPassed($userId): bool
    {
        $highestScore = $this->getHighestScore($userId);
        return $highestScore >= $this->passing_score;
    }
}