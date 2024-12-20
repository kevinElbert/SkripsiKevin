<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Course;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    // Tampilkan semua quiz
    public function index()
    {
        $courses = Course::all(); // Semua course
        $quizzes = Quiz::with('course')->get(); // Semua quiz dengan relasi course
        return view('admin.quizzes.index', compact('quizzes', 'courses'));
    }


    //Tampilkan form untuk membuat quiz
    // public function create(Request $request)
    // {
    //     $courseId = $request->input('course_id');
    //     $course = Course::findOrFail($courseId);
    //     return view('admin.quizzes.create', ['courseId' => $courseId, 'courseTitle' => $course->title]);
        
    // }

    public function create($courseId)
    {
        // Cek apakah course ada
        $course = Course::find($courseId);

        if (!$course) {
            abort(404, "Course not found.");
        }

        return view('admin.quizzes.create', ['courseId' => $courseId, 'courseTitle' => $course->title]);
    }

    // Simpan quiz baru
    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'questions' => 'required|array',
            'questions.*.question' => 'required|string',
            'questions.*.options' => 'required|array|min:2',
            'questions.*.correct_answer' => 'required|string',
        ]);

        Quiz::create([
            'course_id' => $request->course_id,
            'title' => $request->title,
            'questions' => $request->questions,
        ]);

        return redirect()->route('quizzes.index')->with('success', 'Quiz created successfully!');
    }

    // Tampilkan detail quiz
    public function show(Quiz $quiz)
    {
        return view('admin.quizzes.show', compact('quiz'));
    }

    // Tampilkan form edit quiz
    public function edit(Quiz $quiz)
    {
        $courses = Course::all();
        return view('admin.quizzes.edit', compact('quiz', 'courses'));
    }

    // Update quiz
    public function update(Request $request, Quiz $quiz)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'questions' => 'required|array',
            'questions.*.question' => 'required|string',
            'questions.*.options' => 'required|array|min:2',
            'questions.*.correct_answer' => 'required|string',
        ]);

        $quiz->update([
            'title' => $request->title,
            'questions' => $request->questions,
        ]);

        return redirect()->route('quizzes.index')->with('success', 'Quiz updated successfully!');
    }

    // Hapus quiz
    public function destroy(Quiz $quiz)
    {
        $quiz->delete();
        return redirect()->route('quizzes.index')->with('success', 'Quiz deleted successfully!');
    }
}
