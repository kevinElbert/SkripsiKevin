<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Quiz;
use App\Models\QuizResult;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;

class UserQuizController extends Controller
{
    public function showQuiz(int $courseId): View
    {
        $course = Course::findOrFail($courseId);
        $user = Auth::user();
        
        $quizzes = Quiz::where('course_id', $courseId)
            ->where('is_published', true)
            ->get()
            ->map(function ($quiz) use ($user) {
                $highestScore = $quiz->getHighestScore($user->id);
                return [
                    'quiz' => $quiz,
                    'attempts' => $quiz->getUserAttemptCount($user->id),
                    'highest_score' => number_format($highestScore, 1), // Format dengan 1 desimal
                    'can_take' => $quiz->canUserTakeQuiz($user->id),
                    'has_passed' => $quiz->hasUserPassed($user->id)
                ];
            });

        // Set quiz start time
        session(['quiz_start_time' => Carbon::now()]);

        return view('user.quiz.show', compact('course', 'quizzes'));
    }

    public function takeQuiz(int $quizId): View
    {
        $quiz = Quiz::findOrFail($quizId);
        $user = Auth::user();
        $attemptCount = $quiz->getUserAttemptCount($user->id);
        $canTakeQuiz = $quiz->canUserTakeQuiz($user->id);
        $highestScore = $quiz->getHighestScore($user->id);
        $previousAttempts = QuizResult::where('user_id', $user->id)
            ->where('quiz_id', $quizId)
            ->orderBy('created_at', 'desc')
            ->get();
    
        if (!$canTakeQuiz) {
            return redirect()
                ->route('user.quiz.show', ['courseId' => $quiz->course_id])
                ->with('error', 'You have reached the maximum number of attempts for this quiz.');
        }
    
        // Reset quiz start time when actually starting the quiz
        session(['quiz_start_time' => Carbon::now()]);
    
        return view('user.quiz.take', compact(
            'quiz',
            'attemptCount',
            'canTakeQuiz',
            'highestScore',
            'previousAttempts'
        ));
    }

    public function submitQuiz(Request $request, int $courseId): RedirectResponse
    {
        $validated = $request->validate([
            'quiz_id' => 'required|exists:quizzes,id',
            'answers' => 'required|array',
            'answers.*' => 'required|string',
        ]);
    
        $quiz = Quiz::findOrFail($validated['quiz_id']);
        $user = Auth::user();
    
        // Calculate score
        $score = 0;
        $questions = collect($quiz->questions);
        $answers = collect($validated['answers']);
    
        foreach ($questions as $index => $question) {
            $userAnswer = $answers[$index] ?? null;
            if ($userAnswer) {
                // Mendapatkan index jawaban user (0 untuk A, 1 untuk B, dst)
                $answerIndex = array_search($userAnswer, $question['options']);
                // Mengkonversi index ke huruf A, B, C, D
                $userAnswerLetter = chr(65 + $answerIndex); // 65 adalah ASCII untuk 'A'
                
                if ($userAnswerLetter === $question['correct_answer']) {
                    $score++;
                }
            }
        }
    
        // Calculate percentage score
        $totalQuestions = $questions->count();
        $percentageScore = ($score / $totalQuestions) * 100;
    
        // Save result
        $result = QuizResult::create([
            'user_id' => $user->id,
            'quiz_id' => $quiz->id,
            'score' => $score,
            'total_questions' => $totalQuestions,
            'time_taken' => session('quiz_start_time') ? Carbon::now()->diffInSeconds(session('quiz_start_time')) : 0,
            'percentage_score' => $percentageScore,
            'passed' => $percentageScore >= $quiz->passing_score
        ]);
    
        // Clear quiz start time from session
        session()->forget('quiz_start_time');
    
        return redirect()
            ->route('user.quiz.result', ['courseId' => $courseId])
            ->with('success', "Quiz completed! You scored $score out of $totalQuestions");
    }

    public function result(int $courseId): View
    {
        $user = Auth::user();
        $quizResults = QuizResult::where('user_id', $user->id)
            ->whereHas('quiz', function ($query) use ($courseId) {
                $query->where('course_id', $courseId);
            })
            ->with(['quiz.course'])
            ->latest()
            ->get();
    
        // Dapatkan quiz yang berhubungan dengan hasil terakhir
        $quiz = $quizResults->isNotEmpty() ? $quizResults->first()->quiz : null;
    
        $previousAttempts = QuizResult::where('user_id', $user->id)
            ->whereHas('quiz', function ($query) use ($courseId) {
                $query->where('course_id', $courseId);
            })
            ->orderBy('created_at', 'desc')
            ->get();
    
        return view('user.quiz.result', compact('quizResults', 'courseId', 'previousAttempts', 'quiz'));
    }

    public function history(): View
    {
        $user = Auth::user();
        $quizAttempts = QuizResult::where('user_id', $user->id)
            ->with(['quiz.course'])
            ->latest()
            ->get();

        $averageScore = $quizAttempts->avg('percentage_score');
        $passingRate = $quizAttempts->where('passed', true)->count() / max(1, $quizAttempts->count()) * 100;

        return view('user.quiz.history', compact('quizAttempts', 'averageScore', 'passingRate'));
    }

    public function reviewQuiz(int $quizId, int $resultId): View
    {
        $quiz = Quiz::findOrFail($quizId);
        $result = QuizResult::findOrFail($resultId);
        
        // Hanya boleh review jika sudah lulus
        if (!$result->passed) {
            return redirect()->back()
                ->with('error', 'You need to pass the quiz first to review the answers.');
        }
        
        // Pastikan user hanya bisa melihat hasil quiznya sendiri
        if ($result->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('user.quiz.review', compact('quiz', 'result'));
    }
}