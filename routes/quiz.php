<?php

use App\Http\Controllers\QuizController;
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
