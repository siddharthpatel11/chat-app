<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\MetaAiController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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
    Route::get('/chat/groups/voice-call', [ChatController::class, 'groupVoiceCall'])->name('group.voice.call');
    Route::get('/chat/groups/video-call', [ChatController::class, 'groupVideoCall'])->name('group.video.call');
    Route::post('/send', [ChatController::class, 'send']);
    Route::post('/save-token', [ChatController::class, 'saveToken']);
    Route::post('/update-live-location', [ChatController::class, 'updateLiveLocation']);
    Route::post('/upload-status-media', [ChatController::class, 'uploadStatusMedia']);

    Route::post('/save-contact', [ChatController::class, 'saveContact']);
    Route::post('/delete-contact', [ChatController::class, 'deleteContact']);
    Route::post('/send-group-notification', [ChatController::class, 'sendGroupNotification']);
    Route::post('/meta-ai/ask', [MetaAiController::class, 'ask']);

    // Chat Menu Features (Web)
    Route::post('/chat/settings', [ChatController::class, 'updateChatSettings']);
    Route::post('/user/block', [ChatController::class, 'toggleBlockUser']);
    Route::post('/chat/clear', [ChatController::class, 'clearChat']);
    Route::post('/chat/delete', [ChatController::class, 'deleteChat']);
    Route::post('/user/report', [ChatController::class, 'reportUser']);
});

require __DIR__.'/auth.php';
