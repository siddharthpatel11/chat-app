<?php

use App\Http\Controllers\Api\ChatApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/send-message',[ChatApiController::class,'send']);
Route::get('/messages/{chatId}',[ChatApiController::class,'messages']);
Route::get('/messages/{chatId}/search',[ChatApiController::class,'searchInChat']);

Route::post('/create-chat',[ChatApiController::class,'createChat']);
Route::get('/chats',[ChatApiController::class,'chatList']);

Route::post('/save-token',[ChatApiController::class,'saveToken']);
Route::post('/update-live-location', [ChatApiController::class, 'updateLiveLocation']);

Route::get('/users', [ChatApiController::class, 'users']);
Route::get('/search', [ChatApiController::class, 'globalSearch']);
Route::post('/update-profile', [ChatApiController::class, 'updateProfile']);
Route::post('/register', [ChatApiController::class, 'registerUser']);
