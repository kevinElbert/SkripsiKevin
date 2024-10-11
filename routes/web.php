<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Route untuk homepage
Route::get('/', [HomeController::class, 'index']);

// Route untuk home dengan controller
Route::get('/home', [HomeController::class, 'index']);

// Route untuk homeadmin, hanya bisa diakses oleh admin
Route::get('/homeadmin', [HomeController::class, 'index'])->middleware('checkUserType');

// Route untuk dashboard, hanya bisa diakses oleh user yang terotentikasi dan terverifikasi
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Group route untuk profil, memerlukan autentikasi
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Include route auth yang disediakan oleh Laravel Breeze atau Fortify
require __DIR__.'/auth.php';

