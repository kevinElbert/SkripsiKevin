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
        'media',
    ];

    protected $casts = [
        'questions' => 'array',
        'media' => 'array',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
