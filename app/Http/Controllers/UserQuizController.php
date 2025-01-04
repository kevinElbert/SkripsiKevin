<?php

// app/Http/Controllers/UserQuizController.php
namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\QuizResult; 
use App\Models\QuizAnswer;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class UserQuizController extends Controller
{
    public function showQuiz(int $courseId): View
    {
        $course = Course::findOrFail($courseId);
        $quizzes = Quiz::where('course_id', $courseId)->get();

        return view('user.quiz.show', compact('course', 'quizzes'));
    }

    // public function submitQuiz(Request $request, int $courseId): RedirectResponse
    // {
    //     $validated = $request->validate([
    //         'quiz_id' => 'required|exists:quizzes,id',
    //         'answers' => 'required|array',
    //         'answers.*' => 'required|string',
    //     ]);

    //     $quiz = Quiz::findOrFail($validated['quiz_id']);
    //     $correctAnswers = collect($quiz->questions)->pluck('correct_answer')->toArray();
    //     $userAnswers = $validated['answers'];

    //     $score = 0;
    //     foreach ($userAnswers as $key => $answer) {
    //         if (isset($correctAnswers[$key]) && $correctAnswers[$key] === $answer) {
    //             $score++;
    //         }

    //             // / Simpan jawaban pengguna ke `quiz_answers`
    //         QuizAnswer::create([
    //             'user_id' => Auth::id(),
    //             'quiz_id' => $quiz->id,
    //             'correct_option' => json_encode($correctAnswers),
    //             'answer' => $answer,
    //         ]);
    //     }

    //     $user = Auth::user();
    //     if (!$user) {
    //         return redirect()->route('login');
    //     }
        
    //     QuizResult::create([
    //         'user_id' => $user->id,
    //         'quiz_id' => $quiz->id,
    //         'score' => $score,
    //         'total_questions' => count($correctAnswers),
    //     ]);
    //     return redirect()
    //         ->route('user.quiz.result', $courseId)
    //         ->with('success', "You scored $score out of " . count($correctAnswers));
    // }

    public function submitQuiz(Request $request, int $courseId): RedirectResponse
    {
        $validated = $request->validate([
            'quiz_id' => 'required|exists:quizzes,id',
            'answers' => 'required|array',
            'answers.*' => 'required|string',
        ]);

        $quiz = Quiz::findOrFail($validated['quiz_id']);
        $correctAnswers = collect($quiz->questions)->pluck('correct_answer')->toArray();
        $userAnswers = $validated['answers'];

        $score = 0;
        foreach ($userAnswers as $key => $answer) {
            $isCorrect = (isset($correctAnswers[$key]) && $correctAnswers[$key] === $answer);
            if ($isCorrect) {
                $score++;
            }

            // Simpan jawaban pengguna ke `quiz_answers`
            QuizAnswer::create([
                'user_id' => Auth::id(),
                'quiz_id' => $quiz->id,
                'question' => $quiz->questions[$key]['question'],
                'options' => $quiz->questions[$key]['options'],
                'correct_option' => $correctAnswers[$key],
                'answer' => $answer,
            ]);
        }

        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

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

    public function result(int $courseId): View
    {
        $user = Auth::user();
        $quizResults = QuizResult::where('user_id', $user->id)->whereHas('quiz', function ($query) use ($courseId) {
            $query->where('course_id', $courseId);
        })->get();

        return view('user.quiz.result', compact('quizResults', 'courseId'));
    }
}