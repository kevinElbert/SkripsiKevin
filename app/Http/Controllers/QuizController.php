<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class QuizController extends Controller
{
    // Tampilkan semua quiz
    public function index(Request $request)
    {
        $sortField = $request->input('sort', 'title');
        $status = $request->input('status', null);

        // Filter berdasarkan status jika ada
        $quizzes = Quiz::with('course', 'results')
            ->when($status !== null, function ($query) use ($status) {
                if ($status === 'published') {
                    $query->where('is_published', 1);
                } elseif ($status === 'draft') {
                    $query->where('is_published', 0);
                }
            })
            ->orderBy($sortField)
            ->paginate(10);

        $totalQuizzes = Quiz::count();
        $totalQuestions = Quiz::sum(DB::raw('JSON_LENGTH(questions)'));
        $mostActiveCourse = Course::withCount('quizzes')->orderBy('quizzes_count', 'desc')->first();
        $totalAttempts = Quiz::withCount('results')
            ->when($status !== null, function ($query) use ($status) {
                if ($status === 'published') {
                    $query->where('is_published', 1);
                } elseif ($status === 'draft') {
                    $query->where('is_published', 0);
                }
            })
            ->get()
            ->sum('results_count');

        return view('admin.quizzes.index', compact('quizzes', 'totalQuizzes', 'totalQuestions', 'mostActiveCourse', 'totalAttempts'));
    }

    public function create($courseId)
    {
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
            'questions.*.media' => 'nullable|file|mimes:jpg,jpeg,png,mp4,mov|max:2048',
            'is_published' => 'nullable|boolean',
        ]);

        $questions = $request->questions;

        foreach ($questions as $key => $question) {
            if (isset($question['media'])) {
                $uploadedFileUrl = Cloudinary::upload($question['media']->getRealPath())->getSecurePath();
                $questions[$key]['media'] = $uploadedFileUrl;
            }
        }

        Quiz::create([
            'course_id' => $request->course_id,
            'title' => $request->title,
            'questions' => $questions,
            'is_published' => $request->has('is_published') ? 1 : 0, // Default ke 0 jika tidak dicentang
        ]);

        return redirect()->route('quizzes.index')->with('success', 'Quiz created successfully!');
    }

    // Tampilkan detail quiz
    public function show(Quiz $quiz)
    {
        $quiz->load(['results.user']);
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
            'is_published' => 'nullable|boolean',
        ]);

        $quiz->update([
            'title' => $request->title,
            'questions' => $request->questions,
            'is_published' => $request->has('is_published') ? 1 : 0, // Default ke 0 jika tidak dicentang
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
