<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Traits\Likeable;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    use HasFactory, Likeable;

    protected $fillable = ['course_id', 'user_id', 'title', 'content'];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Course
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    // Relasi ke Comment
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
