<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

// Route untuk homepage
Route::get('/', [HomeController::class, 'index']);

// Route untuk home dengan controller
Route::get('/home', [HomeController::class, 'index']);

// Include route auth yang disediakan oleh Laravel Breeze atau Fortify
require __DIR__.'/auth.php';
require __DIR__.'/user.php';
require __DIR__.'/courses.php';
require __DIR__.'/admin.php';
require __DIR__.'/quiz.php';
