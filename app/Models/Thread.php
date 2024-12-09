<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    use HasFactory;

    /**
     * Fillable attributes for mass assignment.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'course_id',
        'sub_topic_id',
        'user_id',
        'title',
        'content',
    ];

    /**
     * Cast attributes to specific types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'course_id' => 'integer',
        'sub_topic_id' => 'integer',
        'user_id' => 'integer',
    ];

    /**
     * Relationship: Thread belongs to a course.
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Relationship: Thread belongs to a subtopic.
     */
    public function subTopic()
    {
        return $this->belongsTo(SubTopic::class);
    }

    /**
     * Relationship: Thread belongs to a user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship: Thread has many comments.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // Eager load comments, user, and course for performance optimization
    public function scopeWithRelations($query)
    {
        return $query->with('comments.user', 'course', 'subTopic');
    }
}
