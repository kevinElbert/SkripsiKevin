<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Quiz;
use App\Models\QuizResult;
use App\Models\QuizAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class UserQuizController extends Controller
{
    // Tampilkan daftar kuis untuk course tertentu
    public function showQuiz(int $courseId): View
    {
        $course = Course::findOrFail($courseId);
        $quizzes = Quiz::where('course_id', $courseId)->get();

        return view('user.quiz.show', compact('course', 'quizzes'));
    }

    // Submit jawaban kuis
    // public function submitQuiz(Request $request, int $courseId): RedirectResponse
    // {
    //     $validated = $request->validate([
    //         'quiz_id' => 'required|exists:quizzes,id',
    //         'answers' => 'required|array',
    //         'answers.*' => 'required|string',
    //     ]);

    //     $quiz = Quiz::findOrFail($validated['quiz_id']);

    //     // Periksa jika user sudah mengerjakan kuis ini
    //     $existingResult = QuizResult::where('user_id', Auth::id())
    //         ->where('quiz_id', $quiz->id)
    //         ->first();

    //     if ($existingResult) {
    //         return redirect()
    //             ->route('user.quiz.result', $courseId)
    //             ->with('error', 'You have already completed this quiz.');
    //     }

    //     // Ambil jawaban benar dari kuis
    //     $correctAnswers = collect($quiz->questions)->pluck('correct_answer')->toArray();
    //     $userAnswers = $validated['answers'];

    //     // Mapping untuk konversi indeks ke huruf (A, B, C, D)
    //     $optionMapping = ['A', 'B', 'C', 'D'];

    //     $score = 0;

    //     // Hitung skor dan simpan jawaban pengguna
    //     foreach ($userAnswers as $key => $answer) {
    //         // Konversi jawaban pengguna dari indeks ke huruf
    //         $userAnswer = $optionMapping[$answer];

    //         // Bandingkan jawaban pengguna dengan jawaban benar
    //         $isCorrect = (isset($correctAnswers[$key]) && $correctAnswers[$key] === $userAnswer);
    //         if ($isCorrect) {
    //             $score++;
    //         }

    //         // Simpan jawaban pengguna ke tabel quiz_answers
    //         QuizAnswer::create([
    //             'user_id' => Auth::id(),
    //             'quiz_id' => $quiz->id,
    //             'question' => $quiz->questions[$key]['question'],
    //             'options' => $quiz->questions[$key]['options'],
    //             'correct_option' => $correctAnswers[$key],
    //             'answer' => $userAnswer,
    //         ]);
    //     }

    //     // Simpan hasil kuis ke tabel quiz_results
    //     QuizResult::create([
    //         'user_id' => Auth::id(),
    //         'quiz_id' => $quiz->id,
    //         'score' => $score,
    //         'total_questions' => count($correctAnswers),
    //     ]);

    //     return redirect()
    //         ->route('user.quiz.result', $courseId)
    //         ->with('success', "You scored $score out of " . count($correctAnswers));
    // }

    public function submitQuiz(Request $request, int $courseId)
    {
        $validated = $request->validate([
            'quiz_id' => 'required|exists:quizzes,id',
            'answers' => 'required|array',
            'answers.*' => 'required|string',
        ]);

        $quiz = Quiz::findOrFail($validated['quiz_id']);

        // Ambil jawaban benar
        $correctAnswers = collect($quiz->questions)->pluck('correct_answer')->toArray();
        $userAnswers = $validated['answers'];

        $score = 0;

        // Hitung skor
        foreach ($userAnswers as $key => $answer) {
            if (isset($correctAnswers[$key]) && $correctAnswers[$key] === $answer) {
                $score++;
            }
        }

        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        // Simpan hasil kuis
        QuizResult::create([
            'user_id' => $user->id,
            'quiz_id' => $quiz->id,
            'score' => $score,
            'total_questions' => count($correctAnswers),
        ]);

        return redirect()
            ->route('user.quiz.result', $courseId)
            ->with('success', "You scored $score out of " . count($correctAnswers));
    }

    // Tampilkan hasil kuis pengguna
    public function result(int $courseId): View
    {
        $user = Auth::user();
        $quizResults = QuizResult::where('user_id', $user->id)
            ->whereHas('quiz', function ($query) use ($courseId) {
                $query->where('course_id', $courseId);
            })
            ->get();

        return view('user.quiz.result', compact('quizResults', 'courseId'));
    }
}
