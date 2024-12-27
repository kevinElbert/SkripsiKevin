<?php

use App\Http\Controllers\QuizController;
use App\Http\Controllers\UserQuizController;
use Illuminate\Support\Facades\Route;

// Route::prefix('admin')->middleware('auth')->group(function () {
//     Route::resource('quizzes', QuizController::class);
// });

Route::prefix('admin')->middleware('auth')->group(function () {
    // Route untuk create quiz dengan parameter courseId
    Route::get('quizzes/create/{courseId}', [QuizController::class, 'create'])->name('quizzes.create');

    // Resource route
    Route::resource('quizzes', QuizController::class)->except('create');
});

// Rute untuk user mengakses quiz dalam courses
Route::middleware('auth')->group(function () {
    Route::get('/courses/{courseId}/quiz', [UserQuizController::class, 'showQuiz'])->name('user.quiz.show');
    Route::post('/courses/{courseId}/quiz/submit', [UserQuizController::class, 'submitQuiz'])->name('user.quiz.submit');
    Route::get('/courses/{courseId}/quiz/result', [UserQuizController::class, 'result'])->name('user.quiz.result');
});
