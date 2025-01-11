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
    // Quiz routes
    Route::get('/courses/{courseId}/quiz', [UserQuizController::class, 'showQuiz'])
        ->name('user.quiz.show');
        
    Route::get('/quiz/{quizId}/take', [UserQuizController::class, 'takeQuiz'])
        ->name('user.quiz.take');
        
    Route::post('/courses/{courseId}/quiz/submit', [UserQuizController::class, 'submitQuiz'])  // Perbaikan disini
        ->name('user.quiz.submit');
        
    Route::get('/courses/{courseId}/quiz/result', [UserQuizController::class, 'result'])
        ->name('user.quiz.result');
        
    Route::get('/quiz/history', [UserQuizController::class, 'history'])
        ->name('user.quiz.history');

    Route::get('/quiz/{quizId}/review/{resultId}', [UserQuizController::class, 'reviewQuiz'])
        ->name('user.quiz.review');
});
