<?php

use App\Http\Controllers\CourseController;
use Illuminate\Support\Facades\Route;

// Route untuk menampilkan daftar kursus
Route::get('/courses/{course:slug}', [CourseController::class, 'show'])->name('courses.show');

// Route untuk "enroll" kursus (membutuhkan autentikasi)
Route::middleware('auth')->post('/courses/{slug}/enroll', [CourseController::class, 'enroll'])->name('courses.enroll');

// Route untuk fitur "Show More" pada daftar kursus (AJAX)
Route::get('/courses/load-more', [CourseController::class, 'loadMore'])->name('courses.loadMore');

// Route untuk halaman informasi kursus
Route::get('/courses/{slug}/info', [CourseController::class, 'info'])->name('courses.info');
