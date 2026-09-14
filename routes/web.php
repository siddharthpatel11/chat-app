<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\WebChannelController;
use App\Http\Controllers\MetaAiController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect('/chat');
    }
    return redirect('/login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/update-profile', [ProfileController::class, 'updateWebProfile'])->name('profile.update.web');
});

Route::get('/manifest.json', [App\Http\Controllers\ManifestController::class, 'index'])->name('manifest');
Route::get('/app-icon.svg', [App\Http\Controllers\ManifestController::class, 'icon'])->name('app-icon');

// Android APK download
Route::get('/download/universal', function () {
    $apkPath = public_path('download/universal-app.apk');
    if (file_exists($apkPath)) {
        return response()->download($apkPath, 'UniversalApp.apk', [
            'Content-Type'        => 'application/vnd.android.package-archive',
            'Content-Disposition' => 'attachment; filename="UniversalApp.apk"',
            'Cache-Control'       => 'no-store, no-cache, must-revalidate, max-age=0',
            'Pragma'              => 'no-cache',
            'Expires'             => '0',
        ]);
    }
    return response('<html><body style="font-family:sans-serif;text-align:center;padding:40px;background:#111b21;color:#e9edef;"><h2 style="color:#00a884">APK Building</h2><p>The Android APK is currently being built in the background. Please wait a minute and refresh this page.</p></body></html>', 404);
})->name('download.universal');

// Keep old route just in case, but redirect it
Route::get('/download/app', function () {
    return redirect()->route('download.universal');
});

// Desktop App download
Route::get('/download/desktop', function () {
    $exePath = public_path('download/desktop-app.exe');
    if (file_exists($exePath)) {
        return response()->download($exePath, 'ChatApp-Desktop.exe', [
            'Content-Type'        => 'application/x-msdownload',
            'Content-Disposition' => 'attachment; filename="ChatApp-Desktop.exe"',
        ]);
    }
    return response('<html><body style="font-family:sans-serif;text-align:center;padding:40px;background:#111b21;color:#e9edef;"><h2 style="color:#00a884">App Not Found</h2><p>The Desktop App installer is currently not available.</p></body></html>', 404);
})->name('download.desktop');

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

    Route::post('/chat/event/update', [ChatController::class, 'updateEvent']);
    Route::post('/chat/event/cancel', [ChatController::class, 'cancelEvent']);
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

    // Hide Chat settings
    Route::get('/chat/hide-settings', [ChatController::class, 'getHideChatSettings']);
    Route::post('/chat/hide-settings', [ChatController::class, 'saveHideChatSettings']);

    // Communities (Web Router)
    Route::post('/community/create', [CommunityController::class, 'createCommunity']);
    Route::post('/community/{communityId}/add-groups', [CommunityController::class, 'addGroups']);
    Route::post('/community/{communityId}/create-group', [CommunityController::class, 'createGroupInCommunity']);
    Route::post('/community/{communityId}/leave', [CommunityController::class, 'leaveCommunity']);
    Route::post('/community/{communityId}/deactivate', [CommunityController::class, 'deactivateCommunity']);
    Route::post('/community/{communityId}/add-members', [CommunityController::class, 'addMembers']);
    Route::post('/community/{communityId}/remove-member', [CommunityController::class, 'removeMember']);
    Route::post('/community/{communityId}/toggle-admin', [CommunityController::class, 'toggleAdmin']);
    Route::post('/community/{communityId}/update', [CommunityController::class, 'updateCommunity']);
    Route::get('/community/{communityId}/info', [CommunityController::class, 'communityInfo']);
    Route::post('/community/{communityId}/remove-group', [CommunityController::class, 'removeGroup']);
    Route::post('/community/{communityId}/groups/{groupId}/join', [CommunityController::class, 'joinGroup']);
    Route::post('/community/{communityId}/groups/{groupId}/join-request', [CommunityController::class, 'sendJoinRequest']);
    Route::post('/community/{communityId}/requests/{requestId}/handle', [CommunityController::class, 'handleJoinRequest']);

    // Channels (Web Router)
    Route::get('/channel/{channelId}', [ChatController::class, 'index']);
    Route::post('/channel/create', [WebChannelController::class, 'createChannel']);
    Route::post('/channel/upload-avatar', [WebChannelController::class, 'uploadAvatar']);
    Route::post('/channel/upload-message-media', [WebChannelController::class, 'uploadMessageMedia']);
    Route::get('/users/details', [WebChannelController::class, 'getUsersDetails']);
    Route::post('/channel/{channelId}/follow', [WebChannelController::class, 'followChannel']);
    Route::post('/channel/{channelId}/unfollow', [WebChannelController::class, 'unfollowChannel']);
    Route::post('/channel/{channelId}/update', [WebChannelController::class, 'updateChannel']);
    // Disappearing messages timers
    Route::post('/chat/settings/disappearing-message-timer', [ChatController::class, 'setDisappearingMessageTimer']);
    Route::post('/chat/settings/default-message-timer', [ChatController::class, 'setDefaultMessageTimer']);

    // Log chat transfer events
    Route::post('/chat/transfer-log', [ChatController::class, 'transferLog']);
});

require __DIR__.'/auth.php';
