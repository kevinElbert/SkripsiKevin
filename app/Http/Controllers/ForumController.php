<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForumController extends Controller
{
    public function index()
    {
        $threads = Thread::with('comments', 'user')->paginate(10);
        return view('forum.index', compact('threads'));
    }

    public function show($id)
    {
        $thread = Thread::with('comments.user')->findOrFail($id);
        return view('forum.show', compact('thread'));
    }

    public function storeThread(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'sub_topic_id' => 'nullable|exists:sub_topics,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $userId = Auth::id();

        if (!$userId) {
            return redirect()->route('login')->with('error', 'You need to login to create a thread.');
        }

        $thread = Thread::create([
            'course_id' => $request->course_id,
            'sub_topic_id' => $request->sub_topic_id,
            'user_id' => $userId,
            'title' => $request->title,
            'content' => $request->content,
        ]);

        return redirect()->route('forum.show', $thread->id)->with('success', 'Thread created successfully!');
    }

    public function storeComment(Request $request, $threadId)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        $userId = Auth::id();

        if (!$userId) {
            return redirect()->route('login')->with('error', 'You need to login to comment.');
        }

        $thread = Thread::findOrFail($threadId);

        Comment::create([
            'thread_id' => $thread->id,
            'user_id' => $userId,
            'content' => $request->content,
        ]);

        return redirect()->route('forum.show', $thread->id)->with('success', 'Comment added successfully!');
    }
    
    public function deleteComment($id)
    {
        $comment = Comment::findOrFail($id);

        if ($comment->user_id != Auth::id()) {
            abort(403, 'You do not have permission to delete this comment.');
        }

        $comment->delete();

        return back()->with('success', 'Comment deleted successfully!');
    }
}
