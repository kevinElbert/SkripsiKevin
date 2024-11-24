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


