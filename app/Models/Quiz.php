<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'title',
        'questions',
    ];

    protected $casts = [
        'questions' => 'array', // Cast JSON ke array PHP
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
