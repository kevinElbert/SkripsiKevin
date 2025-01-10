<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuizResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'quiz_id', 
        'user_id', 
        'score', 
        'total_questions'
    ];

    protected $casts = [
        'score' => 'integer',
        'total_questions' => 'integer'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    public function getPercentageScore(): float
    {
        return $this->total_questions > 0 ? ($this->score / $this->total_questions) * 100 : 0;
    }

    public function hasPassed(): bool
    {
        return $this->getPercentageScore() >= $this->quiz->passing_score;
    }
}