<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'student_id',
        'score',
    ];

    // Relasi ke model Course
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    // Relasi ke model User (untuk student)
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}
