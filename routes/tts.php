<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TextToSpeechController;

Route::post('/tts/generate', [TextToSpeechController::class, 'generateSpeech'])->name('tts.generate');