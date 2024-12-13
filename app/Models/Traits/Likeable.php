<?php

namespace App\Models\Traits;

use App\Models\Like;

trait Likeable
{
    /**
     * Relationship to likes.
     */
    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    /**
     * Check if the model is liked by a specific user.
     */
    public function likedBy($user)
    {
        return $this->likes()->where('user_id', $user->id)->exists();
    }

    /**
     * Toggle the like status for the given user.
     */
    public function toggleLike($user)
    {
        if ($this->likedBy($user)) {
            $this->likes()->where('user_id', $user->id)->delete();
        } else {
            $this->likes()->create(['user_id' => $user->id]);
        }
    }

    /**
     * Count the number of likes for the model.
     */
    public function getLikesCountAttribute()
    {
        return $this->likes()->count();
    }
}
