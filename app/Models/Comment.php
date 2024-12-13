<?php

namespace App\Models;

namespace App\Models;

namespace App\Models;

use App\Models\Traits\Likeable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory, Likeable;

    protected $fillable = ['thread_id', 'user_id', 'content', 'parent_id'];

    // Relasi ke Thread
    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi Parent Comment
    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    // Relasi Replies (Komentar Balasan)
    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }
}


