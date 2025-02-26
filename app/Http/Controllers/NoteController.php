<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Course;
use App\Models\SubTopic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class NoteController extends Controller
{
    // Menampilkan semua notes untuk user
    public function index()
    {
        $notes = Note::where('user_id', Auth::id())
            ->with(['course', 'subTopic'])
            ->latest()
            ->get();

        return view('notes.index', compact('notes'));
    }

    // Menampilkan form untuk membuat notes baru
    public function create($courseId, $subTopicId = null)
    {
        try{
        $course = Course::findOrFail($courseId);
        $subTopic = $subTopicId ? SubTopic::findOrFail($subTopicId) : null;

        return view('notes.create', compact('course', 'subTopic'));
    } catch (\Exception $e) {
        // Log error
        Log::error('Note creation error: ' . $e->getMessage());
        
        // Return dengan error
        return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function store(Request $request)
    {
        try{
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'sub_topic_id' => 'nullable|sometimes|exists:sub_topics,id',
        ]);

        // Check if a note already exists for this course and sub_topic
        $note = Note::where('user_id', Auth::id())
            ->where('course_id', $request->course_id)
            ->where('sub_topic_id', $request->sub_topic_id)
            ->first();

        if ($note) {
            // Update the existing note
            $note->update([
                'title' => $request->title,
                'content' => $request->content,
            ]);
        } else {
            // Create a new note
            Note::create([
                'user_id' => Auth::id(),
                'course_id' => $request->course_id,
                'sub_topic_id' => $request->sub_topic_id,
                'title' => $request->title,
                'content' => $request->content,
            ]);
        }

        return back()->with('success', 'Note saved successfully!');
    } catch (\Exception $e) {
            // Log error
            Log::error('Note store error: ' . $e->getMessage());
            
            // Return dengan error
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
            }
    }

    // Menampilkan detail note
    public function show(Note $note)
    {
        if ($note->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        return view('notes.show', compact('note'));
    }

    // Menampilkan form edit notes
    public function edit(Note $note)
    {
        if ($note->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        return view('notes.edit', compact('note'));
    }

    // Mengupdate notes
    public function update(Request $request, Note $note)
    {
        if ($note->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'title' => 'nullable|string|max:255',
            'content' => 'required|string',
        ]);

        // Update data
        $note->update([
            'title' => $request->title ?? $note->title,
            'content' => $request->content,
        ]);

        return redirect()->route('notes.index')->with('success', 'Note updated successfully!');
    }


    // Menghapus notes
    public function destroy(Note $note)
    {
        if ($note->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $note->delete();

        return redirect()->route('notes.index')->with('success', 'Note deleted successfully!');
    }
}
