<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function toggleLike($type, $id)
    {
        $model = $type === 'thread' ? Thread::class : Comment::class;
        $item = $model::findOrFail($id);

        // Toggle like/unlike
        $item->toggleLike(Auth::user());

        return response()->json([
            'likes' => $item->likes()->count(),
            'liked' => $item->likedBy(Auth::user()),
        ]);
    }
}
