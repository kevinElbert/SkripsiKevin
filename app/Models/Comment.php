<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    /**
     * Fillable attributes for mass assignment.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'thread_id',
        'user_id',
        'content',
    ];

    /**
     * Cast attributes to specific types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'thread_id' => 'integer',
        'user_id' => 'integer',
    ];

    /**
     * Relationship: Comment belongs to a thread.
     */
    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }

    /**
     * Relationship: Comment belongs to a user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
