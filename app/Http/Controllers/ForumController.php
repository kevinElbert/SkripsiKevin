<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use App\Models\Comment;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForumController extends Controller
{
    // Menampilkan halaman forum dengan threads
    public function index()
    {
        $threads = Thread::with('comments', 'user')->paginate(10);
        return view('forum.index', compact('threads'));
    }

    // Menampilkan thread dan komentar
    public function show($id)
    {
        $thread = Thread::with('comments.user')->findOrFail($id);
        return view('forum.show', compact('thread'));
    }

    // Menyimpan thread baru
    public function storeThread(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        try {
            $thread = Thread::create([
                'course_id' => $request->course_id,
                'user_id' => Auth::id(),
                'title' => $request->title,
                'content' => $request->content,
            ]);
            return redirect()->route('forum.index')->with('success', 'Thread created successfully!');
        } catch (\Exception $e) {
            Log::error('Error creating thread', ['error' => $e->getMessage()]);
            return redirect()->back()->withErrors('Failed to create thread. Please try again.');
        }
    }

    // Mengedit thread
    public function editThread($id)
    {
        $thread = Thread::findOrFail($id);
        return view('forum.edit', compact('thread'));
    }

    // Update thread
    public function updateThread(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $thread = Thread::findOrFail($id);
        $thread->update([
            'title' => $request->title,
            'content' => $request->content,
        ]);

        return redirect()->route('forum.show', $thread->id)->with('success', 'Thread updated successfully!');
    }

    // Menghapus thread
    public function deleteThread($id)
    {
        $thread = Thread::findOrFail($id);
        $thread->delete();

        return redirect()->route('forum.index')->with('success', 'Thread deleted successfully!');
    }

    // Menyimpan komentar
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

    // Menghapus komentar
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
