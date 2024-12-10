<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class ForumController extends Controller
{
    // Menampilkan daftar threads
    public function index()
    {
        $threads = Thread::with('user', 'course')->latest()->paginate(10);
        $courses = \App\Models\Course::all(); // Ambil semua course
        return view('forum.index', compact('threads', 'courses'));
    }

    // Menampilkan detail thread beserta komentar
    public function show($id)
    {
        $thread = Thread::with('comments.user', 'user', 'course')->findOrFail($id);
        return view('forum.show', compact('thread'));
    }

    // Membuat thread baru
    public function store(Request $request)
    {
        log::info('Request received:', $request->all());
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

        return redirect()->route('forum.index')->with('success', 'Thread created successfully!');
    }

    // Menambahkan komentar pada thread
    public function storeComment(Request $request, $threadId)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        Comment::create([
            'thread_id' => $threadId,
            'user_id' => Auth::id(),
            'content' => $request->content,
        ]);

        return redirect()->route('forum.show', $threadId)->with('success', 'Comment added successfully!');
    }
}
