<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminSubTopicController;
use App\Http\Controllers\CourseController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'checkUserType'])->group(function () {
    // Route untuk dashboard admin
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('dashboard');

    // Route untuk CRUD kursus oleh admin
    Route::prefix('admin/courses')->name('courses.')->group(function () {
        Route::get('/', [CourseController::class, 'index'])->name('index');
        Route::get('/create', [CourseController::class, 'create'])->name('create');
        Route::post('/', [CourseController::class, 'store'])->name('store');
        Route::get('/{course}/edit', [CourseController::class, 'edit'])->name('edit');
        Route::patch('/{course}', [CourseController::class, 'update'])->name('update');
        Route::delete('/{course}', [CourseController::class, 'destroy'])->name('destroy'); 
    });
});

// Route untuk sub-topics
Route::prefix('admin/courses/{courseId}/sub_topics')->middleware('auth', 'isAdmin')->name('admin.sub_topics.')->group(function () {
    Route::get('/', [AdminSubTopicController::class, 'index'])->name('index');
    Route::get('/create', [AdminSubTopicController::class, 'create'])->name('create');
    Route::post('/', [AdminSubTopicController::class, 'store'])->name('store');
    Route::get('/{subTopicId}/edit', [AdminSubTopicController::class, 'edit'])->name('edit');
    Route::put('/{subTopicId}', [AdminSubTopicController::class, 'update'])->name('update');
    Route::delete('/{subTopicId}', [AdminSubTopicController::class, 'destroy'])->name('destroy'); 
});
