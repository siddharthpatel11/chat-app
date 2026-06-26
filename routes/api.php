<?php

use App\Http\Controllers\Api\BroadcastApiController;
use App\Http\Controllers\Api\ChatApiController;
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
use App\Http\Controllers\Api\StatusApiController;
use App\Http\Controllers\Api\CommunityController;
use App\Http\Controllers\Api\ChannelApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/send-message', [ChatApiController::class, 'send']);
Route::get('/messages/{chatId}', [ChatApiController::class, 'messages']);
Route::get('/messages/{chatId}/search', [ChatApiController::class, 'searchInChat']);

Route::post('/create-chat', [ChatApiController::class, 'createChat']);
Route::get('/chats', [ChatApiController::class, 'chatList']);

Route::post('/save-token', [ChatApiController::class, 'saveToken']);
Route::post('/update-live-location', [ChatApiController::class, 'updateLiveLocation']);

Route::get('/users', [ChatApiController::class, 'users']);
Route::get('/search', [ChatApiController::class, 'globalSearch']);

Route::post('/register', [ChatApiController::class, 'registerUser']);
Route::post('/login', [ChatApiController::class, 'loginUser']);
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
Route::post('/message/delete', [ChatApiController::class, 'deleteMessage']);
Route::post('/message/edit', [ChatApiController::class, 'editMessage']);
Route::post('/user/report', [ChatApiController::class, 'reportUser']);

// Hide Chat Settings API
Route::get('/settings/hide-chat', [ChatApiController::class, 'getHideChatSettings']);
Route::post('/settings/hide-chat', [ChatApiController::class, 'saveHideChatSettings']);

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

// Broadcast Chat Features
Route::post('/broadcast/create', [BroadcastApiController::class, 'create']);
Route::get('/broadcast/list', [BroadcastApiController::class, 'list']);
Route::post('/broadcast/{broadcastId}/add-recipients', [BroadcastApiController::class, 'addRecipients']);
Route::post('/broadcast/{broadcastId}/remove-recipient', [BroadcastApiController::class, 'removeRecipient']);
Route::post('/broadcast/{broadcastId}/delete', [BroadcastApiController::class, 'delete']);
Route::get('/broadcast/{broadcastId}/messages', [BroadcastApiController::class, 'getMessages']);
Route::post('/broadcast/{broadcastId}/send-message', [BroadcastApiController::class, 'sendMessage']);

// Channel Features
Route::post('/channel/upload-avatar', [ChannelApiController::class, 'uploadAvatar']);
Route::post('/channel/upload-message-media', [ChannelApiController::class, 'uploadMessageMedia']);
Route::post('/channel/create', [ChannelApiController::class, 'createChannel']);
Route::post('/channel/{channelId}/follow', [ChannelApiController::class, 'followChannel']);
Route::post('/channel/{channelId}/unfollow', [ChannelApiController::class, 'unfollowChannel']);
Route::post('/channel/{channelId}/update', [ChannelApiController::class, 'updateChannel']);
Route::post('/channel/{channelId}/delete', [ChannelApiController::class, 'deleteChannel']);

// Channel Admin & Owner Features
Route::post('/channel/{channelId}/invite-admins', [ChannelApiController::class, 'inviteAdmins']);
Route::post('/channel/{channelId}/accept-admin-invite', [ChannelApiController::class, 'acceptAdminInvite']);
Route::post('/channel/{channelId}/dismiss-admin', [ChannelApiController::class, 'dismissAdmin']);
Route::post('/channel/{channelId}/dismiss-self-admin', [ChannelApiController::class, 'dismissSelfAdmin']);
Route::post('/channel/{channelId}/remove-follower', [ChannelApiController::class, 'removeFollower']);

// Channel Messages
Route::get('/channel/{channelId}/messages', [ChannelApiController::class, 'getMessages']);
Route::post('/channel/{channelId}/send-message', [ChannelApiController::class, 'sendMessage']);
Route::get('/channel/{channelId}/search', [ChannelApiController::class, 'searchMessages']);

// Channel Additional Settings
Route::post('/channel/{channelId}/mute', [ChannelApiController::class, 'toggleMute']);
Route::post('/channel/{channelId}/report', [ChannelApiController::class, 'reportChannel']);

Route::get('/channel/users', [ChannelApiController::class, 'getUsersDetails']);

// Status Features
Route::post('/status/create', [StatusApiController::class, 'createStatus']);
Route::post('/status/privacy', [StatusApiController::class, 'updatePrivacy']);
Route::post('/status/view', [StatusApiController::class, 'markAsViewed']);
Route::post('/status/reply', [StatusApiController::class, 'replyToStatus']);
Route::get('/status/list', [StatusApiController::class, 'listStatuses']);

Route::middleware('auth:sanctum')->group(function () {
    // Profile General Settings
    Route::get('/profile/general', [GeneralApiController::class, 'getSettings']);
    Route::post('/profile/general', [GeneralApiController::class, 'updateSettings']);

    // Get profile details & Update profile
    Route::post('/update-profile', [ProfileApiController::class, 'updateProfile']);
    Route::get('/get-profile', [ProfileApiController::class, 'getProfile']);

    // Profile Account Settings
    Route::get('/profile/account', [AccountApiController::class, 'getSettings']);
    Route::post('/profile/account', [AccountApiController::class, 'updateSettings']);

    // Profile Privacy Settings
    Route::get('/profile/privacy', [PrivacyApiController::class, 'getSettings']);
    Route::post('/profile/privacy', [PrivacyApiController::class, 'updateSettings']);

    // Profile Chats Settings
    Route::get('/profile/chats', [ChatsApiController::class, 'getSettings']);
    Route::post('/profile/chats', [ChatsApiController::class, 'updateSettings']);

    // Profile Notifications Settings
    Route::get('/profile/notifications', [NotificationsApiController::class, 'getSettings']);
    Route::post('/profile/notifications', [NotificationsApiController::class, 'updateSettings']);

    // Profile Video & Voice Settings
    Route::get('/profile/video-voice', [VideoVoiceApiController::class, 'getSettings']);
    Route::post('/profile/video-voice', [VideoVoiceApiController::class, 'updateSettings']);

    // Profile Keyboard Shortcuts Settings
    Route::get('/profile/keyboard-shortcuts', [KeyboardShortcutsApiController::class, 'getSettings']);
    Route::post('/profile/keyboard-shortcuts', [KeyboardShortcutsApiController::class, 'updateSettings']);

    // Profile Help and Feedback Settings
    Route::get('/profile/help-feedback', [HelpFeedbackApiController::class, 'getSettings']);
    Route::post('/profile/help-feedback', [HelpFeedbackApiController::class, 'updateSettings']);

    // Profile Logout Settings
    Route::post('/profile/logout', [LogoutApiController::class, 'logout']);

    // Communities API
    Route::post('/community/create', [CommunityController::class, 'createCommunity']);
    Route::post('/community/{communityId}/add-groups', [CommunityController::class, 'addGroups']);
    Route::post('/community/{communityId}/create-group', [CommunityController::class, 'createGroupInCommunity']);
    Route::post('/community/{communityId}/leave', [CommunityController::class, 'leaveCommunity']);
    Route::post('/community/{communityId}/deactivate', [CommunityController::class, 'deactivateCommunity']);
    Route::post('/community/{communityId}/add-members', [CommunityController::class, 'addMembers']);
    Route::post('/community/{communityId}/remove-member', [CommunityController::class, 'removeMember']);
    Route::post('/community/{communityId}/toggle-admin', [CommunityController::class, 'toggleAdmin']);
    Route::post('/community/{communityId}/update', [CommunityController::class, 'updateCommunity']);
    Route::match(['get', 'post'], '/community/{communityId}/info', [CommunityController::class, 'communityInfo']);
    Route::post('/community/{communityId}/remove-group', [CommunityController::class, 'removeGroup']);
    Route::post('/community/{communityId}/groups/{groupId}/join', [CommunityController::class, 'joinGroup']);
    Route::post('/community/{communityId}/groups/{groupId}/join-request', [CommunityController::class, 'sendJoinRequest']);
    Route::post('/community/{communityId}/requests/{requestId}/handle', [CommunityController::class, 'handleJoinRequest']);
});

// Meta AI
Route::post('/meta-ai/ask', [MetaAiApiController::class, 'ask']);

// Global Media
Route::get('/media/all', [MediaApiController::class, 'getGlobalMedia']);

// Global Media Actions
Route::post('/media/delete', [MediaApiController::class, 'deleteMedia']);
Route::post('/media/forward', [MediaApiController::class, 'forwardMedia']);
Route::post('/channel/{channelId}/react-message', [ChannelApiController::class, 'reactMessage']);
Route::post('/channel/{channelId}/delete-message', [ChannelApiController::class, 'deleteMessage']);
Route::post('/channel/{channelId}/delete-messages', [ChannelApiController::class, 'deleteMessages']);
