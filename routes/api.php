<?php

use App\Http\Controllers\Api\ChatApiController;
use App\Http\Controllers\Api\GroupApiController;
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
Route::post('/check-phone', [ChatApiController::class, 'checkPhone']);

// Voice & Video Call
Route::post('/call/initiate', [ChatApiController::class, 'initiateCall']);
Route::post('/call/status', [ChatApiController::class, 'updateCallStatus']);

// Contact Info
Route::get('/contact-info/{userId}', [ChatApiController::class, 'contactInfo']);

// Chat Menu Features
Route::post('/chat/settings', [ChatApiController::class, 'updateChatSettings']);
Route::post('/user/block', [ChatApiController::class, 'toggleBlockUser']);
Route::post('/chat/clear', [ChatApiController::class, 'clearChat']);
Route::post('/chat/delete', [ChatApiController::class, 'deleteChat']);
Route::post('/user/report', [ChatApiController::class, 'reportUser']);

// Group Chat Features
Route::post('/group/create', [GroupApiController::class, 'createGroup']);
Route::post('/group/{groupId}/add-members', [GroupApiController::class, 'addMembers']);
Route::post('/group/{groupId}/remove-member', [GroupApiController::class, 'removeMember']);
Route::post('/group/{groupId}/make-admin', [GroupApiController::class, 'makeAdmin']);
Route::post('/group/{groupId}/leave', [GroupApiController::class, 'leaveGroup']);
Route::get('/group/{groupId}/info', [GroupApiController::class, 'groupInfo']);
Route::get('/group/{groupId}/messages', [GroupApiController::class, 'getMessages']);
Route::post('/group/{groupId}/send-message', [GroupApiController::class, 'sendMessage']);
Route::post('/group/{groupId}/call/initiate', [GroupApiController::class, 'initiateCall']);
