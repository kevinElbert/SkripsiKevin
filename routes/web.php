<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TextToSpeechController;
use App\Http\Controllers\VoiceActionController;

// Route untuk homepage
// Route::get('/', [HomeController::class, 'index']);

Route::get('/', function () {
    return redirect('/home');
});

// Route untuk home dengan controller
Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::post('/update-contrast-mode', [HomeController::class, 'updateContrastMode'])->name('update.contrast.mode');

// Voice Action Routes
Route::post('/voice-action/process', [VoiceActionController::class, 'processCommand'])
    ->name('voice.process')->middleware('auth');
Route::get('/voice-action/search-course', [VoiceActionController::class, 'searchCourse'])
    ->name('voice.search-course')->middleware('auth');

// Include route auth yang disediakan oleh Laravel Breeze atau Fortify
require __DIR__.'/auth.php';
require __DIR__.'/user.php';
require __DIR__.'/courses.php';
require __DIR__.'/admin.php';
require __DIR__.'/quiz.php';
require __DIR__.'/tts.php';
