<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CourseController;
use Illuminate\Support\Facades\Route;

// Route untuk homepage
Route::get('/', [HomeController::class, 'index']);

// Route untuk home dengan controller
Route::get('/home', [HomeController::class, 'index']);


// Route untuk admin dashboard, hanya bisa diakses oleh admin yang terautentikasi
Route::middleware(['auth', 'checkUserType'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('dashboard');
});


// Group route untuk profil, memerlukan autentikasi
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'checkUserType'])->group(function () {
    Route::get('/admin/courses', [CourseController::class, 'index'])->name('courses.index');
    Route::get('/admin/courses/create', [CourseController::class, 'create'])->name('courses.create');
    Route::post('/admin/courses', [CourseController::class, 'store'])->name('courses.store');
    Route::get('/admin/courses/{course}/edit', [CourseController::class, 'edit'])->name('courses.edit');
    Route::patch('/admin/courses/{course}', [CourseController::class, 'update'])->name('courses.update');
    Route::delete('/admin/courses/{course}', [CourseController::class, 'destroy'])->name('courses.destroy');
});


// Include route auth yang disediakan oleh Laravel Breeze atau Fortify
require __DIR__.'/auth.php';
