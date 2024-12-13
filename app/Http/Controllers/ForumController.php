<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use App\Models\Comment;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ForumController extends Controller
{
    // Menampilkan daftar threads berdasarkan course
    public function index($course_id)
    {
        $threads = Thread::where('course_id', $course_id)
            ->with('user', 'course')
            ->latest()
            ->paginate(10);

        $course = Course::findOrFail($course_id); // Ambil detail course

        return view('forum.index', compact('threads', 'course'));
    }

    // Menampilkan detail thread beserta komentar
    public function show($id)
    {
        $thread = Thread::with([
            'comments' => fn ($query) => $query->whereNull('parent_id')->with('replies.user'),
            'comments.user',
            'user',
            'course'
        ])->findOrFail($id);
    
        return view('forum.show', compact('thread'));
    }
    
    // Membuat thread baru
    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        Thread::create([
            'course_id' => $request->course_id,
            'user_id' => Auth::id(),
            'title' => $request->title,
            'content' => $request->content,
        ]);

        return redirect()->route('forum.index', $request->course_id)->with('success', 'Thread created successfully!');
    }

    // Menambahkan komentar pada thread
    public function storeComment(Request $request, $threadId)
    {
        $request->validate([
            'content' => 'required|string',
            'parent_id' => 'nullable|exists:comments,id',
        ]);
    
        Comment::create([
            'thread_id' => $threadId,
            'user_id' => Auth::id(),
            'content' => $request->content,
            'parent_id' => $request->parent_id,
        ]);
    
        return redirect()->route('forum.show', $threadId)->with('success', 'Comment added successfully!');
    }    
    
    public function deleteComment($id)
    {
        $comment = Comment::findOrFail($id);

        // Check if the authenticated user is the owner of the comment
        if ($comment->user_id != Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $comment->delete();

        return redirect()->back()->with('success', 'Comment deleted successfully!');
    }
}
