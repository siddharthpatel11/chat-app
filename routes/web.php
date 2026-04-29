<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/chat', [ChatController::class, 'index']);
    Route::get('/chat/voice-call', [ChatController::class, 'voiceCall']);
    Route::get('/chat/video-call', [ChatController::class, 'videoCall']);
    Route::post('/send', [ChatController::class, 'send']);
    Route::post('/save-token', [ChatController::class, 'saveToken']);
    Route::post('/update-live-location', [ChatController::class, 'updateLiveLocation']);
});

require __DIR__.'/auth.php';
