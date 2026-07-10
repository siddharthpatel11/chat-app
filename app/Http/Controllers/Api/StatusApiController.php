<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Kreait\Firebase\Factory;

class StatusApiController extends Controller
{
    protected $db;
    protected $messaging;

    public function __construct()
    {
        $firebaseService = app(\App\Services\FirebaseService::class);
        $this->db = $firebaseService->database();
        $this->messaging = $firebaseService->messaging();
    }

    // 1. Create Status
    public function createStatus(Request $request)
    {
        $request->validate([
            'type' => 'required|in:text,image,video',
        ]);

        $userId = auth()->id() ?? $request->user_id;
        if (!$userId) {
            return response()->json(['status' => false, 'message' => 'User ID is required'], 400);
        }

        $user = \App\Models\User::find($userId);
        $userName = $user->name ?? $user->phone ?? 'User';
        $userAvatar = $user->avatar ?? null;

        // Fetch Privacy Settings from Firebase (or default to 'all')
        $privacyConfig = $this->db->getReference("users/{$userId}/status_privacy")->getValue();
        $privacyMode = $privacyConfig['mode'] ?? 'all';
        $privacyContacts = $privacyConfig['contacts'] ?? [];

        $statusRef = $this->db->getReference("statuses/{$userId}");
        $newStatus = $statusRef->push();
        $pushId = $newStatus->getKey();

        $statusData = [
            'id' => $pushId,
            'userId' => (string) $userId,
            'userName' => $userName,
            'userAvatar' => $userAvatar,
            'type' => $request->type,
            'timestamp' => (int) round(microtime(true) * 1000),
            'viewers' => [],
            'privacyMode' => $privacyMode,
            'privacyContacts' => $privacyContacts,
        ];

        if ($request->type === 'text') {
            $request->validate(['text' => 'required|string']);
            $statusData['text'] = $request->text;
            $statusData['bgColor'] = $request->bg_color ?? '#00a884';
            $statusData['font'] = $request->font ?? 'sans-serif';
        } else {
            $request->validate(['file' => 'required|file']);
            $file = $request->file('file');
            $path = $file->store('uploads/statuses', 'public');
            $mediaUrl = url('storage/' . $path);
            
            $statusData['mediaUrl'] = $mediaUrl;
            $statusData['caption'] = $request->caption ?? '';
        }

        $newStatus->set($statusData);

        return response()->json([
            'status' => true,
            'message' => 'Status created successfully',
            'push_id' => $pushId,
            'data' => $statusData
        ]);
    }

    // 2. Update Privacy
    public function updatePrivacy(Request $request)
    {
        $request->validate([
            'mode' => 'required|in:all,except,only',
            'contacts' => 'nullable|array' // Array of user IDs
        ]);

        $userId = auth()->id() ?? $request->user_id;
        if (!$userId) {
            return response()->json(['status' => false, 'message' => 'User ID is required'], 400);
        }

        $privacyData = [
            'mode' => $request->mode,
            'contacts' => $request->contacts ?? []
        ];

        $this->db->getReference("users/{$userId}/status_privacy")->set($privacyData);

        return response()->json([
            'status' => true,
            'message' => 'Privacy settings updated successfully',
            'data' => $privacyData
        ]);
    }

    // 3. Mark as Viewed
    public function markAsViewed(Request $request)
    {
        $request->validate([
            'target_user_id' => 'required',
            'status_id' => 'required' // This is the push ID of the status
        ]);

        $viewerId = auth()->id() ?? $request->user_id;
        if (!$viewerId) {
            return response()->json(['status' => false, 'message' => 'User ID is required'], 400);
        }

        $viewerUser = \App\Models\User::find($viewerId);
        $viewerName = $viewerUser->name ?? $viewerUser->phone ?? 'Someone';

        $viewerData = [
            'time' => (int) round(microtime(true) * 1000),
            'name' => $viewerName
        ];

        // Path: statuses/creator_id/status_push_id/viewers/viewer_id
        $this->db->getReference("statuses/{$request->target_user_id}/{$request->status_id}/viewers/{$viewerId}")->set($viewerData);

        return response()->json([
            'status' => true,
            'message' => 'Marked as viewed'
        ]);
    }

    // 4. Reply to Status
    public function replyToStatus(Request $request)
    {
        $request->validate([
            'target_user_id' => 'required',
            'text' => 'required|string',
            'reply_to_text' => 'nullable|string'
        ]);

        $senderId = auth()->id() ?? $request->user_id;
        if (!$senderId) {
            return response()->json(['status' => false, 'message' => 'User ID is required'], 400);
        }

        $targetUserId = $request->target_user_id;

        // Generate 1-on-1 chat ID
        $chatId = $senderId < $targetUserId ? "chat_{$senderId}_{$targetUserId}" : "chat_{$targetUserId}_{$senderId}";

        $targetUser = \App\Models\User::find($targetUserId);
        $targetUserName = $targetUser->name ?? $targetUser->phone ?? 'User';

        $messageData = [
            'sender_id' => $senderId,
            'text' => $request->text,
            'type' => 'text',
            'time' => now()->timestamp,
            'status' => 'sent',
            'reply_to_text' => $request->reply_to_text ?? 'Status',
            'reply_to_name' => $targetUserName
        ];

        // Send message to chat
        $this->db->getReference("chats/{$chatId}/messages")->push($messageData);

        // Update chat metadata
        $this->db->getReference("chats/{$chatId}")->update([
            'last_message' => 'Replied to status',
            'last_message_time' => now()->timestamp,
            'users' => [(int)$senderId, (int)$targetUserId] // Ensure users array exists
        ]);

        // Optional: Send Notification
        $receiver = \App\Models\User::find($targetUserId);
        $senderName = \App\Models\User::find($senderId)->name ?? 'Someone';
        
        if ($receiver && $receiver->fcm_token) {
            $notificationTitle = $senderName;
            $notificationBody = 'Replied to your status: ' . $request->text;
            
            $message = \Kreait\Firebase\Messaging\CloudMessage::withTarget('token', $receiver->fcm_token)
                ->withNotification(\Kreait\Firebase\Messaging\Notification::create($notificationTitle, $notificationBody))
                ->withData([
                    'chat_id' => $chatId,
                    'type' => 'status_reply',
                    'sender_id' => (string)$senderId
                ]);
            try { $this->messaging->send($message); } catch (\Exception $e) {}
        }

        return response()->json([
            'status' => true,
            'message' => 'Reply sent successfully',
            'chat_id' => $chatId
        ]);
    }

    // 5. List Statuses
    public function listStatuses(Request $request)
    {
        $userId = auth()->id() ?? $request->user_id;
        if (!$userId) {
            return response()->json(['status' => false, 'message' => 'User ID is required'], 400);
        }

        $allStatuses = $this->db->getReference('statuses')->getValue() ?: [];
        $currentTime = round(microtime(true) * 1000);
        
        $myStatuses = [];
        $recentStatuses = [];
        $viewedStatuses = [];

        foreach ($allStatuses as $creatorId => $creatorStatuses) {
            if (!is_array($creatorStatuses)) {
                continue;
            }
            $filteredForCreator = [];
            
            // Check Privacy if it's someone else's status
            if ($creatorId != $userId) {
                // Determine if we can see their status
                // In a real implementation, you'd fetch the creator's privacy settings.
                // Since privacy is saved in statuses directly, we check the latest status privacy mode.
                
                $canView = true;
                foreach ($creatorStatuses as $s) {
                    if (isset($s['privacyMode'])) {
                        $mode = $s['privacyMode'];
                        $contacts = $s['privacyContacts'] ?? [];
                        
                        // Wait, privacy contacts might be strings or ints.
                        $isInContacts = in_array($userId, $contacts) || in_array((string)$userId, $contacts);
                        
                        if ($mode === 'except' && $isInContacts) {
                            $canView = false;
                        } elseif ($mode === 'only' && !$isInContacts) {
                            $canView = false;
                        }
                        break; // Just check the first one to determine user's current policy
                    }
                }
                
                if (!$canView) continue;
            }

            foreach ($creatorStatuses as $pushId => $status) {
                // Filter 24 hours (86400000 milliseconds)
                if (isset($status['timestamp']) && ($currentTime - $status['timestamp']) <= 86400000) {
                    // Inject Firebase push ID
                    $status['push_id'] = $pushId;
                    $filteredForCreator[] = $status;
                }
            }

            if (empty($filteredForCreator)) continue;

            // Sort by timestamp
            usort($filteredForCreator, function($a, $b) {
                return $a['timestamp'] <=> $b['timestamp'];
            });

            // If it's my status
            if ($creatorId == $userId) {
                $myStatuses = $filteredForCreator;
            } else {
                // Check if all are viewed
                $allViewed = true;
                foreach ($filteredForCreator as $s) {
                    if (!isset($s['viewers'][$userId])) {
                        $allViewed = false;
                        break;
                    }
                }
                
                if ($allViewed) {
                    $viewedStatuses[] = [
                        'creator_id' => $creatorId,
                        'creator_name' => $filteredForCreator[0]['userName'] ?? 'User',
                        'creator_avatar' => $filteredForCreator[0]['userAvatar'] ?? null,
                        'statuses' => $filteredForCreator
                    ];
                } else {
                    $recentStatuses[] = [
                        'creator_id' => $creatorId,
                        'creator_name' => $filteredForCreator[0]['userName'] ?? 'User',
                        'creator_avatar' => $filteredForCreator[0]['userAvatar'] ?? null,
                        'statuses' => $filteredForCreator
                    ];
                }
            }
        }

        return response()->json([
            'status' => true,
            'data' => [
                'my_statuses' => $myStatuses,
                'recent_updates' => $recentStatuses,
                'viewed_updates' => $viewedStatuses
            ]
        ]);
    }
}
