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
                return [
                    'quiz' => $quiz,
                    'attempts' => $quiz->getUserAttemptCount($user->id),
                    'highest_score' => $quiz->getHighestScore($user->id),
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

        if (!$quiz->canUserTakeQuiz($user->id)) {
            return redirect()
                ->route('user.quiz.show', ['courseId' => $quiz->course_id])
                ->with('error', 'You have reached the maximum number of attempts for this quiz.');
        }

        // Reset quiz start time when actually starting the quiz
        session(['quiz_start_time' => Carbon::now()]);

        return view('user.quiz.take', compact('quiz'));
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

        if (!$quiz->canUserTakeQuiz($user->id)) {
            return redirect()->back()
                ->with('error', 'You have reached the maximum number of attempts for this quiz.');
        }

        // Calculate time taken
        $startTime = session('quiz_start_time');
        $timeTaken = $startTime ? Carbon::now()->diffInSeconds($startTime) : null;

        // Check if time limit exceeded
        if ($quiz->time_limit && $timeTaken > ($quiz->time_limit * 60)) {
            return redirect()->back()
                ->with('error', 'Time limit exceeded. Your answers were not submitted.');
        }

        // Calculate score
        $score = 0;
        $correctAnswers = collect($quiz->questions)->pluck('correct_answer');
        $answers = collect($validated['answers']);

        foreach ($answers as $key => $answer) {
            if (isset($correctAnswers[$key]) && $correctAnswers[$key] === $answer) {
                $score++;
            }
        }

        // Calculate percentage score
        $percentageScore = ($score / $correctAnswers->count()) * 100;

        // Save result
        $result = QuizResult::create([
            'user_id' => $user->id,
            'quiz_id' => $quiz->id,
            'score' => $score,
            'total_questions' => $correctAnswers->count(),
            'time_taken' => $timeTaken,
            'percentage_score' => $percentageScore,
            'passed' => $percentageScore >= $quiz->passing_score
        ]);

        // Clear quiz start time from session
        session()->forget('quiz_start_time');

        return redirect()
            ->route('user.quiz.result', ['courseId' => $courseId])
            ->with('success', "Quiz completed! You scored $score out of " . $correctAnswers->count());
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

        $previousAttempts = QuizResult::where('user_id', $user->id)
            ->whereHas('quiz', function ($query) use ($courseId) {
                $query->where('course_id', $courseId);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.quiz.result', compact('quizResults', 'courseId', 'previousAttempts'));
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
}