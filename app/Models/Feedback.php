<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $table = 'feedbacks';

    protected $fillable = [
        'course_id',
        'user_id',
        'user_name',
        'comment',
        'rating',
    ];

    public function course()
    {
        return $this->hasMany(Feedback::class);
    }

    public function user()
    {
        return $this->hasMany(Feedback::class);
    }
}
