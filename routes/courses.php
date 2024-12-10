<?php

use App\Http\Controllers\CourseController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ForumController;

// Route untuk menampilkan daftar kursus
Route::get('/courses/{slug}', [CourseController::class, 'show'])->name('courses.show');

// Route untuk "enroll" kursus (membutuhkan autentikasi)
Route::middleware('auth')->post('/courses/{slug}/enroll', [CourseController::class, 'enroll'])->name('courses.enroll');

// Route untuk fitur "Show More" pada daftar kursus (AJAX)
Route::get('/courses/load-more', [CourseController::class, 'loadMore'])->name('courses.loadMore');

// Route untuk halaman informasi kursus
Route::get('/courses/{slug}/info', [CourseController::class, 'info'])->name('courses.info');

// Route::prefix('forum')->name('forum.')->middleware('auth')->group(function () {
//     Route::get('/', [ForumController::class, 'index'])->name('index'); // Menampilkan semua thread
//     Route::get('/{id}', [ForumController::class, 'show'])->name('show'); // Menampilkan thread dan komentarnya
//     Route::post('/create-thread', [ForumController::class, 'storeThread'])->name('storeThread'); // Membuat thread
//     Route::post('/{threadId}/comment', [ForumController::class, 'storeComment'])->name('storeComment'); // Menambahkan komentar
//     Route::delete('/comment/{id}', [ForumController::class, 'deleteComment'])->name('deleteComment'); // Menghapus komentar
// });

// Route untuk Forum
// Route::prefix('forum')->name('forum.')->group(function () {
//     Route::get('/', [ForumController::class, 'index'])->name('index'); // Semua user bisa akses
//     Route::get('/{id}', [ForumController::class, 'show'])->name('show'); // Semua user bisa lihat thread
//     Route::post('/create-thread', [ForumController::class, 'storeThread'])->name('storeThread');
//     // Komentar tetap membutuhkan autentikasi
//     Route::middleware('auth')->post('/{threadId}/comment', [ForumController::class, 'storeComment'])->name('storeComment');
//     Route::middleware('auth')->delete('/comment/{id}', [ForumController::class, 'deleteComment'])->name('deleteComment');
// });

// Route::middleware('auth')->group(function () {
//     Route::resource('forum', ForumController::class)->except(['create', 'store']);
//     Route::post('forum/store', [ForumController::class, 'storeThread'])->name('forum.storeThread');
//     Route::put('forum/{id}/update', [ForumController::class, 'updateThread'])->name('forum.updateThread');
//     Route::delete('forum/{id}/delete', [ForumController::class, 'deleteThread'])->name('forum.deleteThread');
// });

// Route::group(function () {
//     Route::resource('forum', ForumController::class)->except(['create', 'store']);
//     Route::post('forum/store', [ForumController::class, 'storeThread'])->name('forum.storeThread');
//     Route::put('forum/{id}/update', [ForumController::class, 'updateThread'])->name('forum.updateThread');
//     Route::delete('forum/{id}/delete', [ForumController::class, 'deleteThread'])->name('forum.deleteThread');
// });

Route::middleware('auth')->group(function () {
    Route::get('forum', [ForumController::class, 'index'])->name('forum.index'); // Daftar threads
    Route::get('forum/{id}', [ForumController::class, 'show'])->name('forum.show'); // Detail thread
    Route::post('forum', [ForumController::class, 'store'])->name('forum.store'); // Membuat thread
    Route::post('forum/{id}/comment', [ForumController::class, 'storeComment'])->name('forum.comment.store'); // Menambah komentar
});


