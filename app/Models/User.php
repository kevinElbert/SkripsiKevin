<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\QuizResult;
use App\Models\Course;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }

    // public function quizResults(): HasMany
    // {
    //     return $this->hasMany(QuizResult::class);
    // }
    public function quizResults()
    {
        return $this->hasMany(QuizResult::class);
    }

    // public function courses()
    // {
    //     return $this->belongsToMany(Course::class, 'user_courses', 'user_id', 'course_id')->withTimestamps();
    // }
    
    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'user_courses')->withPivot('progress')->withTimestamps();
    }
}
