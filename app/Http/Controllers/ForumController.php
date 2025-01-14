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

        // Cek jika user adalah admin atau pemilik komentar
        if (Auth::user()->usertype === 'admin' || $comment->user_id == Auth::id()) {
            $comment->delete();
            return redirect()->back()->with('success', 'Comment deleted successfully!');
        }

        return redirect()->back()->with('error', 'Unauthorized action.');
    }

    public function deleteThread($id)
    {
        $thread = Thread::findOrFail($id);

        // Check jika admin atau pemilik thread
        if (Auth::user()->is_admin || $thread->user_id == Auth::id()) {
            $thread->delete();
            return redirect()->back()->with('success', 'Thread deleted successfully!');
        }

        abort(403, 'Unauthorized action.');
    }

    public function editThread(Request $request, $id)
    {
        $thread = Thread::findOrFail($id);

        if (Auth::user()->is_admin || $thread->user_id == Auth::id()) {
            $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'required|string',
            ]);

            $thread->update($request->only('title', 'content'));
            return redirect()->route('forum.show', $thread->id)->with('success', 'Thread updated successfully!');
        }

        abort(403, 'Unauthorized action.');
    }
}
