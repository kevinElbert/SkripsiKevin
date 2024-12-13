<?php

use App\Http\Controllers\CourseController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\LikeController;

// Route untuk menampilkan daftar kursus
Route::get('/courses/{slug}', [CourseController::class, 'show'])->name('courses.show');

// Route untuk "enroll" kursus (membutuhkan autentikasi)
Route::middleware('auth')->post('/courses/{slug}/enroll', [CourseController::class, 'enroll'])->name('courses.enroll');

// Route untuk fitur "Show More" pada daftar kursus (AJAX)
Route::get('/courses/load-more', [CourseController::class, 'loadMore'])->name('courses.loadMore');

// Route untuk halaman informasi kursus
Route::get('/courses/{slug}/info', [CourseController::class, 'info'])->name('courses.info');

Route::middleware('auth')->group(function () {
    Route::get('forum/{course_id}', [ForumController::class, 'index'])->name('forum.index');
    Route::get('forum/{id}/thread', [ForumController::class, 'show'])->name('forum.show');
    Route::post('forum', [ForumController::class, 'store'])->name('forum.store');
    Route::post('forum/{id}/comment', [ForumController::class, 'storeComment'])->name('forum.comment.store');
    Route::post('like/{type}/{id}', [LikeController::class, 'toggleLike'])->name('like.toggle');
    Route::delete('forum/comment/{id}', [ForumController::class, 'deleteComment'])->name('forum.comment.delete');
});
