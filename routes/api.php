<?php

use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\BroadcastApiController;
use App\Http\Controllers\Api\CallApiController;
use App\Http\Controllers\Api\ChannelApiController;
use App\Http\Controllers\Api\ChatApiController;
use App\Http\Controllers\Api\CommunityController;
use App\Http\Controllers\Api\ContactApiController;
use App\Http\Controllers\Api\GroupApiController;
use App\Http\Controllers\Api\MediaApiController;
use App\Http\Controllers\Api\MetaAiApiController;
use App\Http\Controllers\Api\Profile\AccountApiController;
use App\Http\Controllers\Api\Profile\ChatsApiController;
use App\Http\Controllers\Api\Profile\GeneralApiController;
use App\Http\Controllers\Api\Profile\HelpFeedbackApiController;
use App\Http\Controllers\Api\Profile\KeyboardShortcutsApiController;
use App\Http\Controllers\Api\Profile\LogoutApiController;
use App\Http\Controllers\Api\Profile\NotificationsApiController;
use App\Http\Controllers\Api\Profile\PrivacyApiController;
use App\Http\Controllers\Api\Profile\ProfileApiController;
use App\Http\Controllers\Api\Profile\VideoVoiceApiController;
use App\Http\Controllers\Api\SettingsApiController;
use App\Http\Controllers\Api\StatusApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Public Auth Routes
Route::middleware('throttle:6,1')->prefix('v1')->group(function () {
    Route::post('/register', [AuthApiController::class, 'registerUser']);
    Route::post('/login', [AuthApiController::class, 'loginUser']);
    Route::post('/check-phone', [ContactApiController::class, 'checkPhone']);
});

// Protected API Routes
Route::middleware(['auth:sanctum', 'throttle:60,1'])->prefix('v1')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/send-message', [ChatApiController::class, 'send'])->middleware('throttle:30,1');
    Route::get('/messages/{chatId}', [ChatApiController::class, 'messages']);
    Route::get('/messages/{chatId}/search', [ChatApiController::class, 'searchInChat']);

    Route::post('/create-chat', [ChatApiController::class, 'createChat']);
    Route::get('/chats', [ChatApiController::class, 'chatList']);

    Route::post('/save-token', [ChatApiController::class, 'saveToken']);
    Route::post('/update-live-location', [ChatApiController::class, 'updateLiveLocation']);

    Route::get('/users', [ChatApiController::class, 'users']);
    Route::get('/search', [ChatApiController::class, 'globalSearch']);

    // GIFs & Stickers
    Route::get('/gifs/trending', [ChatApiController::class, 'trendingGifs']);
    Route::get('/gifs/search', [ChatApiController::class, 'searchGifs']);
    Route::get('/stickers/trending', [ChatApiController::class, 'trendingStickers']);
    Route::get('/stickers/search', [ChatApiController::class, 'searchStickers']);

    // Voice & Video Call
    Route::post('/call/initiate', [CallApiController::class, 'initiateCall']);
    Route::post('/call/status', [CallApiController::class, 'updateCallStatus']);

    // Contact Info
    Route::get('/contact-info/{userId}', [ContactApiController::class, 'contactInfo']);

    // Chat Menu Features
    Route::patch('/chat/settings', [SettingsApiController::class, 'updateChatSettings']);
    Route::post('/user/block', [SettingsApiController::class, 'toggleBlockUser']);
    Route::delete('/chat/clear', [ChatApiController::class, 'clearChat']);
    Route::delete('/chat/delete', [ChatApiController::class, 'deleteChat']);
    Route::delete('/message/delete', [ChatApiController::class, 'deleteMessage']);
    Route::patch('/message/edit', [ChatApiController::class, 'editMessage']);
    Route::post('/user/report', [SettingsApiController::class, 'reportUser']);

    // Hide Chat Settings API
    Route::get('/settings/hide-chat', [SettingsApiController::class, 'getHideChatSettings']);
    Route::post('/settings/hide-chat', [SettingsApiController::class, 'saveHideChatSettings']);
    
    // Disappearing Messages API
    Route::post('/settings/default-message-timer', [SettingsApiController::class, 'setDefaultMessageTimer']);
    Route::post('/settings/disappearing-message-timer', [SettingsApiController::class, 'setDisappearingMessageTimer']);

    // Group Chat Features
    Route::post('/group/create', [GroupApiController::class, 'createGroup']);
    Route::post('/group/{groupId}/add-members', [GroupApiController::class, 'addMembers']);
    Route::delete('/group/{groupId}/member', [GroupApiController::class, 'removeMember']);
    Route::post('/group/{groupId}/make-admin', [GroupApiController::class, 'makeAdmin']);
    Route::delete('/group/{groupId}/leave', [GroupApiController::class, 'leaveGroup']);
    Route::get('/group/{groupId}/info', [GroupApiController::class, 'groupInfo']);
    Route::get('/group/{groupId}/messages', [GroupApiController::class, 'getMessages']);
    Route::post('/group/{groupId}/send-message', [GroupApiController::class, 'sendMessage'])->middleware('throttle:30,1');
    Route::post('/group/{groupId}/call/initiate', [GroupApiController::class, 'initiateCall']);

    // Broadcast Chat Features
    Route::post('/broadcast/create', [BroadcastApiController::class, 'create']);
    Route::get('/broadcast/list', [BroadcastApiController::class, 'list']);
    Route::post('/broadcast/{broadcastId}/add-recipients', [BroadcastApiController::class, 'addRecipients']);
    Route::delete('/broadcast/{broadcastId}/recipient', [BroadcastApiController::class, 'removeRecipient']);
    Route::delete('/broadcast/{broadcastId}', [BroadcastApiController::class, 'delete']);
    Route::get('/broadcast/{broadcastId}/messages', [BroadcastApiController::class, 'getMessages']);
    Route::post('/broadcast/{broadcastId}/send-message', [BroadcastApiController::class, 'sendMessage'])->middleware('throttle:30,1');

    // Channel Features
    Route::post('/channel/upload-avatar', [ChannelApiController::class, 'uploadAvatar']);
    Route::post('/channel/upload-message-media', [ChannelApiController::class, 'uploadMessageMedia']);
    Route::post('/channel/create', [ChannelApiController::class, 'createChannel']);
    Route::post('/channel/{channelId}/follow', [ChannelApiController::class, 'followChannel']);
    Route::delete('/channel/{channelId}/follow', [ChannelApiController::class, 'unfollowChannel']);
    Route::patch('/channel/{channelId}', [ChannelApiController::class, 'updateChannel']);
    Route::delete('/channel/{channelId}', [ChannelApiController::class, 'deleteChannel']);

    // Channel Admin & Owner Features
    Route::post('/channel/{channelId}/invite-admins', [ChannelApiController::class, 'inviteAdmins']);
    Route::post('/channel/{channelId}/accept-admin-invite', [ChannelApiController::class, 'acceptAdminInvite']);
    Route::delete('/channel/{channelId}/admin', [ChannelApiController::class, 'dismissAdmin']);
    Route::delete('/channel/{channelId}/self-admin', [ChannelApiController::class, 'dismissSelfAdmin']);
    Route::delete('/channel/{channelId}/follower', [ChannelApiController::class, 'removeFollower']);

    // Channel Messages
    Route::get('/channel/{channelId}/messages', [ChannelApiController::class, 'getMessages']);
    Route::post('/channel/{channelId}/send-message', [ChannelApiController::class, 'sendMessage'])->middleware('throttle:30,1');
    Route::get('/channel/{channelId}/search', [ChannelApiController::class, 'searchMessages']);
    Route::post('/channel/{channelId}/react-message', [ChannelApiController::class, 'reactMessage']);
    Route::delete('/channel/{channelId}/message', [ChannelApiController::class, 'deleteMessage']);
    Route::delete('/channel/{channelId}/messages', [ChannelApiController::class, 'deleteMessages']);
    
    // Channel Additional Settings
    Route::patch('/channel/{channelId}/mute', [ChannelApiController::class, 'toggleMute']);
    Route::post('/channel/{channelId}/report', [ChannelApiController::class, 'reportChannel']);
    
    Route::get('/channel/users', [ChannelApiController::class, 'getUsersDetails']);

    // Status Features
    Route::post('/status/create', [StatusApiController::class, 'createStatus']);
    Route::patch('/status/privacy', [StatusApiController::class, 'updatePrivacy']);
    Route::post('/status/view', [StatusApiController::class, 'markAsViewed']);
    Route::post('/status/reply', [StatusApiController::class, 'replyToStatus']);
    Route::get('/status/list', [StatusApiController::class, 'listStatuses']);

    // Profile General Settings
    Route::get('/profile/general', [GeneralApiController::class, 'getSettings']);
    Route::patch('/profile/general', [GeneralApiController::class, 'updateSettings']);

    // Get profile details & Update profile
    Route::patch('/profile', [ProfileApiController::class, 'updateProfile']);
    Route::get('/profile', [ProfileApiController::class, 'getProfile']);
    
    // Profile Account Settings
    Route::get('/profile/account', [AccountApiController::class, 'getSettings']);
    Route::patch('/profile/account', [AccountApiController::class, 'updateSettings']);
    
    // Profile Privacy Settings
    Route::get('/profile/privacy', [PrivacyApiController::class, 'getSettings']);
    Route::patch('/profile/privacy', [PrivacyApiController::class, 'updateSettings']);
    
    // Profile Chats Settings
    Route::get('/profile/chats', [ChatsApiController::class, 'getSettings']);
    Route::patch('/profile/chats', [ChatsApiController::class, 'updateSettings']);
    
    // Chat Wallpaper API
    Route::post('/profile/chats/wallpaper', [SettingsApiController::class, 'updateWallpaper']);
    
    // Profile Notifications Settings
    Route::get('/profile/notifications', [NotificationsApiController::class, 'getSettings']);
    Route::patch('/profile/notifications', [NotificationsApiController::class, 'updateSettings']);

    // Profile Video & Voice Settings
    Route::get('/profile/video-voice', [VideoVoiceApiController::class, 'getSettings']);
    Route::patch('/profile/video-voice', [VideoVoiceApiController::class, 'updateSettings']);

    // Profile Keyboard Shortcuts Settings
    Route::get('/profile/keyboard-shortcuts', [KeyboardShortcutsApiController::class, 'getSettings']);
    Route::patch('/profile/keyboard-shortcuts', [KeyboardShortcutsApiController::class, 'updateSettings']);

    // Profile Help and Feedback Settings
    Route::get('/profile/help-feedback', [HelpFeedbackApiController::class, 'getSettings']);
    Route::patch('/profile/help-feedback', [HelpFeedbackApiController::class, 'updateSettings']);

    // Profile Logout Settings
    Route::post('/profile/logout', [LogoutApiController::class, 'logout']);

    // Communities API
    Route::post('/community/create', [CommunityController::class, 'createCommunity']);
    Route::post('/community/{communityId}/add-groups', [CommunityController::class, 'addGroups']);
    Route::post('/community/{communityId}/create-group', [CommunityController::class, 'createGroupInCommunity']);
    Route::delete('/community/{communityId}/leave', [CommunityController::class, 'leaveCommunity']);
    Route::post('/community/{communityId}/deactivate', [CommunityController::class, 'deactivateCommunity']);
    Route::post('/community/{communityId}/add-members', [CommunityController::class, 'addMembers']);
    Route::delete('/community/{communityId}/member', [CommunityController::class, 'removeMember']);
    Route::post('/community/{communityId}/toggle-admin', [CommunityController::class, 'toggleAdmin']);
    Route::patch('/community/{communityId}', [CommunityController::class, 'updateCommunity']);
    Route::match(['get', 'post'], '/community/{communityId}/info', [CommunityController::class, 'communityInfo']);
    Route::delete('/community/{communityId}/group', [CommunityController::class, 'removeGroup']);
    Route::post('/community/{communityId}/groups/{groupId}/join', [CommunityController::class, 'joinGroup']);
    Route::post('/community/{communityId}/groups/{groupId}/join-request', [CommunityController::class, 'sendJoinRequest']);
    Route::post('/community/{communityId}/requests/{requestId}/handle', [CommunityController::class, 'handleJoinRequest']);

    // Meta AI
    Route::post('/meta-ai/ask', [MetaAiApiController::class, 'ask'])->middleware('throttle:30,1');

    // Global Media
    Route::get('/media/all', [MediaApiController::class, 'getGlobalMedia']);

    // Global Media Actions
    Route::delete('/media', [MediaApiController::class, 'deleteMedia']);
    Route::post('/media/forward', [MediaApiController::class, 'forwardMedia']);
});
