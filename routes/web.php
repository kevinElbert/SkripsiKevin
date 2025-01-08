<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TextToSpeechController;

// Route untuk homepage
// Route::get('/', [HomeController::class, 'index']);

// Route untuk home dengan controller
Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::post('/update-contrast-mode', [HomeController::class, 'updateContrastMode'])->name('update.contrast.mode');

// Include route auth yang disediakan oleh Laravel Breeze atau Fortify
require __DIR__.'/auth.php';
require __DIR__.'/user.php';
require __DIR__.'/courses.php';
require __DIR__.'/admin.php';
require __DIR__.'/quiz.php';
require __DIR__.'/tts.php';
