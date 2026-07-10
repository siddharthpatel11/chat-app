<?php

namespace App\Http\Controllers;

use App\Services\FirebaseService;
use Illuminate\Http\Request;
use App\Events\MessageSent;
use Illuminate\Support\Facades\Schema;

class ChatController extends Controller
{
    protected $db;
    protected $messaging;

    public function __construct(FirebaseService $firebaseService)
    {
        $this->db = $firebaseService->database();
        $this->messaging = $firebaseService->messaging();
    }

    public function index()
    {
        $users = \App\Models\User::where('id', '!=', auth()->id())->get();

        $contacts = [];
        if (Schema::hasTable('contacts')) {
            $contacts = \App\Models\Contact::where('user_id', auth()->id())->get()->keyBy('contact_user_id');
        }

        foreach ($users as $user) {
            if (isset($contacts[$user->id])) {
                $user->saved_name = $contacts[$user->id]->custom_name;
                $user->is_contact = true;
            } else {
                $user->saved_name = $user->phone;
                $user->is_contact = false;
            }
        }

        return view('chat.index', compact('users'));
    }

    public function send(Request $request)
    {
        $db = $this->db;
        $messaging = $this->messaging;

        $chatId = $request->chat_id;
        $senderId = auth()->id();
        
        if (!$senderId) {
            return response()->json(['status' => false, 'message' => 'Unauthorized'], 401);
        }

        $type = 'text';
        $fileUrl = null;
        $fileName = null;
        $lat = null;
        $lng = null;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $mimeType = $file->getMimeType();

            if (str_starts_with($mimeType, 'image/')) {
                $type = 'image';
            } elseif (str_starts_with($mimeType, 'video/')) {
                $type = 'video';
            } elseif (str_starts_with($mimeType, 'audio/')) {
                $type = 'audio';
            } else {
                $type = 'document';
            }

            $fileName = $file->getClientOriginalName();
            $path = $file->store('uploads', 'public');
            $fileUrl = url('storage/' . $path);
        } elseif ($request->has('file_url')) {
            $fileUrl = $request->file_url;
            $fileName = $request->file_name;
            $type = $request->type ?? 'document';
        }

        if ($request->type === 'location' || $request->type === 'live_location') {
            $type = $request->type;
            $lat = $request->lat;
            $lng = $request->lng;
        } elseif ($request->type === 'scheduled_call') {
            $type = 'scheduled_call';
        }

        $data = [
            'sender_id' => $senderId,
            'text' => $request->message ?? '',
            'type' => $type,
            'file_url' => $fileUrl,
            'file_name' => $fileName,
            'reply_to_id' => $request->reply_to_id ?? null,
            'reply_to_text' => $request->reply_to_text ?? null,
            'reply_to_name' => $request->reply_to_name ?? null,
            'lat' => $lat,
            'lng' => $lng,
            'duration' => $request->duration ?? null,
            'time' => microtime(true),
            'status' => 'sent',
        ];

        if ($type === 'scheduled_call') {
            $data['call_name'] = $request->call_name;
            $data['description'] = $request->description;
            $data['start_time'] = (int)$request->start_time;
            $data['end_time'] = $request->has('end_time') && $request->end_time ? (int)$request->end_time : null;
            $data['call_type'] = $request->call_type;
            $data['require_approval'] = filter_var($request->require_approval, FILTER_VALIDATE_BOOLEAN);
            $data['group_call_id'] = $request->group_call_id;
        }

        // Determine node (chats or groups)
        $isGroup = str_starts_with($chatId, 'group_');
        $node = $isGroup ? 'groups' : 'chats';

        // Keep the 'group_' prefix for groups in Firebase Realtime Database
        if ($isGroup) {
            $firebaseChatId = $chatId;
            if (str_starts_with($firebaseChatId, 'group_group_')) {
                $firebaseChatId = substr($firebaseChatId, 6);
            }
        } else {
            $firebaseChatId = $chatId;
        }

        $disappearingMessageService = app(\App\Services\DisappearingMessageService::class);
        $isExpiring = $disappearingMessageService->attachExpirationData($chatId, $senderId, $data);

        // Push to Realtime Database
        $msgRef = $db->getReference("$node/$firebaseChatId/messages")->push($data);

        if ($isExpiring) {
            $disappearingMessageService->logExpiringMessage($chatId, $msgRef->getKey(), $data['expires_at']);
        }

        // Dispatch WebSocket Event
        broadcast(new MessageSent($chatId, $data))->toOthers();

        // Handle Notifications
        $senderName = auth()->user()->name ?? auth()->user()->phone ?? 'Someone';
        $notificationBody = $request->message ?? '';

        if ($type === 'image') {
            $notificationBody = '📷 Photo' . ($request->message ? ': ' . $request->message : '');
        } elseif ($type === 'video') {
            $notificationBody = '🎥 Video' . ($request->message ? ': ' . $request->message : '');
        } elseif ($type === 'audio') {
            $notificationBody = '🎤 Audio message';
        } elseif ($type === 'document') {
            $notificationBody = '📄 Document: ' . ($fileName ?? 'File');
        } elseif ($type === 'location') {
            $notificationBody = '📍 Location';
        } elseif ($type === 'live_location') {
            $notificationBody = '📍 Live Location';
        } elseif ($type === 'scheduled_call') {
            $notificationBody = '📅 Scheduled call: ' . ($request->call_name ?? 'Call');
        }

        if ($isGroup) {
            // Group Notification Logic - Use numeric ID for node lookup
            $group = $db->getReference("groups/$firebaseChatId")->getValue();
            if ($group && isset($group['users'])) {
                $userIds = is_array($group['users']) ? $group['users'] : array_values($group['users']);
                $receivers = \App\Models\User::whereIn('id', $userIds)
                    ->where('id', '!=', $senderId)
                    ->whereNotNull('fcm_token', 'and')
                    ->get();

                $groupName = $group['name'] ?? 'Group';
                $notificationTitle = $groupName;
                $finalBody = $senderName . ": " . $notificationBody;

                $tokens = $receivers->pluck('fcm_token')->filter()->toArray();
                if (!empty($tokens)) {
                    $message = \Kreait\Firebase\Messaging\CloudMessage::new()
                        ->withNotification(\Kreait\Firebase\Messaging\Notification::create($notificationTitle, $finalBody))
                        ->withData([
                            'chat_id' => $chatId, // Keep group_ prefix for frontend
                            'type' => $type,
                            'sender_name' => $senderName,
                            'sender_id' => (string)$senderId,
                            'group_id' => (string)$chatId,
                            'click_action' => 'FLUTTER_NOTIFICATION_CLICK'
                        ]);
                    try {
                        $messaging->sendMulticast($message, $tokens);
                    } catch (\Exception $e) {
                        \Illuminate\Support\Facades\Log::error('FCM Multicast Group Send Error: ' . $e->getMessage());
                    }
                }
            }
        } else {
            // 1-to-1 Notification Logic - Target ONLY the recipient
            $ids = explode('_', str_replace('chat_', '', $chatId));
            $otherUserId = null;
            if (count($ids) >= 2) {
                $otherUserId = ($ids[0] == $senderId) ? $ids[1] : $ids[0];
            }

            if ($otherUserId) {
                $receivers = \App\Models\User::where('id', $otherUserId)
                    ->whereNotNull('fcm_token', 'and')
                    ->get();

                foreach ($receivers as $user) {
                    $message = \Kreait\Firebase\Messaging\CloudMessage::withTarget('token', $user->fcm_token)
                        ->withNotification(\Kreait\Firebase\Messaging\Notification::create($senderName, $notificationBody))
                        ->withData([
                            'chat_id' => (string)$senderId,
                            'type' => $type,
                            'sender_name' => $senderName,
                            'sender_id' => (string)$senderId,
                            'click_action' => 'FLUTTER_NOTIFICATION_CLICK'
                        ]);
                    try { 
                        $messaging->send($message); 
                    } catch (\Exception $e) {
                        \Illuminate\Support\Facades\Log::error('FCM Send Error: ' . $e->getMessage());
                    }
                }
            }
        }

        return response()->json(['status' => true]);
    }

    public function saveToken(Request $request)
    {
        auth()->user()->update(['fcm_token' => $request->token]);
        return response()->json(['status' => true]);
    }

    public function voiceCall(Request $request)
    {
        $groupCallId = $request->query('group_call_id', null);
        if ($groupCallId) {
            return redirect()->route('group.voice.call', $request->query());
        }

        $name = $request->query('name', 'User');
        $avatar = $request->query('avatar');
        if (empty($avatar)) {
            $avatar = 'https://ui-avatars.com/api/?name=' . urlencode($name) . '&background=202c33&color=fff&size=280';
        }
        $role = $request->query('role', 'caller');
        $callId = $request->query('call_id', null);
        $calleeId = $request->query('callee_id', null);
        $myUserId = auth()->id();
        $myName = auth()->user()->name ?? 'Me';
        $myAvatar = auth()->user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($myName) . '&background=202c33&color=fff&size=280';
        $users = \App\Models\User::where('id', '!=', auth()->id())->get(['id', 'name', 'avatar', 'phone']);
        return view('chat.calls.voice_call', compact('name', 'avatar', 'role', 'callId', 'calleeId', 'groupCallId', 'myUserId', 'myName', 'myAvatar', 'users'));
    }

    public function videoCall(Request $request)
    {
        $groupCallId = $request->query('group_call_id', null);
        if ($groupCallId) {
            return redirect()->route('group.video.call', $request->query());
        }

        $name = $request->query('name', 'User');
        $avatar = $request->query('avatar');
        if (empty($avatar)) {
            $avatar = 'https://ui-avatars.com/api/?name=' . urlencode($name) . '&background=202c33&color=fff&size=280';
        }
        $role = $request->query('role', 'caller');
        $callId = $request->query('call_id', null);
        $calleeId = $request->query('callee_id', null);
        $myUserId = auth()->id();
        $myName = auth()->user()->name ?? 'Me';
        $myAvatar = auth()->user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($myName) . '&background=202c33&color=fff&size=280';
        $users = \App\Models\User::where('id', '!=', auth()->id())->get(['id', 'name', 'avatar', 'phone']);
        return view('chat.calls.video_call', compact('name', 'avatar', 'role', 'callId', 'calleeId', 'groupCallId', 'myUserId', 'myName', 'myAvatar', 'users'));
    }

    public function groupVoiceCall(Request $request)
    {
        $name = $request->query('name', 'Group');
        $avatar = $request->query('avatar');
        $role = $request->query('role', 'caller');
        $groupCallId = $request->query('group_call_id', null);
        $groupId = $request->query('group_id', null);
        $myUserId = auth()->id();
        $myName = auth()->user()->name ?? 'Me';
        $myAvatar = auth()->user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($myName) . '&background=202c33&color=fff&size=280';

        // Fetch group members
        $users = [];
        if ($groupId) {
            // Ideally fetch from DB, but for now we'll pass the list or handle in view
            $users = \App\Models\User::where('id', '!=', auth()->id())->get(['id', 'name', 'avatar', 'phone']);
        }

        return view('chat.groups.group_voice_call', compact('name', 'avatar', 'role', 'groupCallId', 'groupId', 'myUserId', 'myName', 'myAvatar', 'users'));
    }

    public function groupVideoCall(Request $request)
    {
        $name = $request->query('name', 'Group');
        $avatar = $request->query('avatar');
        $role = $request->query('role', 'caller');
        $groupCallId = $request->query('group_call_id', null);
        $groupId = $request->query('group_id', null);
        $myUserId = auth()->id();
        $myName = auth()->user()->name ?? 'Me';
        $myAvatar = auth()->user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($myName) . '&background=202c33&color=fff&size=280';

        $users = \App\Models\User::where('id', '!=', auth()->id())->get(['id', 'name', 'avatar', 'phone']);

        return view('chat.groups.group_video_call', compact('name', 'avatar', 'role', 'groupCallId', 'groupId', 'myUserId', 'myName', 'myAvatar', 'users'));
    }

    public function updateLiveLocation(Request $request)
    {
        $db = $this->db;

        $db->getReference("live_locations/user_" . auth()->id())->set([
            'lat' => $request->lat,
            'lng' => $request->lng,
            'time' => now()->timestamp
        ]);

        return response()->json(['status' => true]);
    }

    public function uploadStatusMedia(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->store('uploads/statuses', 'public');
            $fileUrl = url('storage/' . $path);
            return response()->json(['status' => true, 'url' => $fileUrl]);
        }
        return response()->json(['status' => false], 400);
    }

    public function saveContact(Request $request)
    {
        $request->validate([
            'contact_user_id' => 'required|exists:users,id',
            'custom_name' => 'nullable|string|max:255',
        ]);

        $userId = auth()->id();
        if (!$userId) {
            return response()->json(['status' => false, 'message' => 'Unauthorized'], 401);
        }

        $contact = \App\Models\Contact::updateOrCreate(
            ['user_id' => $userId, 'contact_user_id' => $request->contact_user_id],
            ['custom_name' => $request->custom_name]
        );

        return response()->json([
            'status' => true,
            'message' => 'Contact saved successfully',
            'contact' => $contact
        ]);
    }

    public function deleteContact(Request $request)
    {
        $request->validate([
            'contact_user_id' => 'required|exists:users,id',
        ]);

        $userId = auth()->id();
        if (!$userId) {
            return response()->json(['status' => false, 'message' => 'Unauthorized'], 401);
        }

        \App\Models\Contact::where('user_id', $userId)
            ->where('contact_user_id', $request->contact_user_id)
            ->delete();

        return response()->json([
            'status' => true,
            'message' => 'Contact deleted successfully'
        ]);
    }

    public function sendGroupNotification(Request $request)
    {
        $db = $this->db;
        $messaging = $this->messaging;

        $groupId = $request->group_id;
        $senderId = auth()->id();
        $messageText = $request->message;
        $type = $request->type ?? 'text';

        // Fetch group members from Firebase
        $group = $db->getReference("groups/$groupId")->getValue();
        if (!$group || !isset($group['users'])) {
            return response()->json(['status' => false, 'message' => 'Group not found or no users']);
        }

        $userIds = $group['users'];

        // Fetch users who have FCM tokens
        $receivers = \App\Models\User::whereIn('id', $userIds)
            ->where('id', '!=', $senderId)
            ->whereNotNull('fcm_token', 'and')
            ->get();

        $senderName = auth()->user()->name ?? auth()->user()->phone ?? 'Someone';
        $groupName = $group['name'] ?? 'Group';

        $notificationTitle = $groupName;
        $notificationBody = $senderName . ": " . ($messageText ?? 'Media');

        if ($type === 'image') {
            $notificationBody = $senderName . ': 📷 Photo';
        } elseif ($type === 'video') {
            $notificationBody = $senderName . ': 🎥 Video';
        } elseif ($type === 'audio') {
            $notificationBody = $senderName . ': 🎤 Audio';
        } elseif ($type === 'document') {
            $notificationBody = $senderName . ': 📄 Document';
        }

        $tokens = $receivers->pluck('fcm_token')->filter()->toArray();
        if (!empty($tokens)) {
            $message = \Kreait\Firebase\Messaging\CloudMessage::new()
                ->withNotification(\Kreait\Firebase\Messaging\Notification::create($notificationTitle, $notificationBody))
                ->withData([
                    'chat_id' => 'group_' . $groupId,
                    'type' => $type,
                    'sender_name' => $senderName,
                    'sender_id' => (string)$senderId,
                    'group_id' => (string)$groupId,
                    'click_action' => 'FLUTTER_NOTIFICATION_CLICK'
                ]);

            try {
                $messaging->sendMulticast($message, $tokens);
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Group FCM Multicast Send Error: ' . $e->getMessage());
            }
        }

        return response()->json(['status' => true]);
    }

    // ⚙️ Update Chat Settings (Mute, Lock, Fav, Disappearing)
    public function updateChatSettings(Request $request)
    {
        $db = $this->db;

        $request->validate([
            'chat_id' => 'required',
            'setting_key' => 'required|string',
            'setting_value' => 'required'
        ]);

        $userId = auth()->id();
        if (!$userId) return response()->json(['status' => false, 'message' => 'Unauthorized'], 401);

        $db->getReference("chats/{$request->chat_id}/settings/{$userId}/{$request->setting_key}")
            ->set($request->setting_value);

        return response()->json(['status' => true, 'message' => 'Settings updated successfully']);
    }

    // Set Default Message Timer
    public function setDefaultMessageTimer(Request $request, \App\Services\DisappearingMessageService $disappearingMessageService)
    {
        $request->validate([
            'duration' => 'required|integer'
        ]);

        $userId = auth()->id();
        $disappearingMessageService->setDefaultTimer($userId, $request->duration);

        return response()->json(['status' => true, 'message' => 'Default message timer updated']);
    }

    // Set Disappearing Message Timer for a specific chat
    public function setDisappearingMessageTimer(Request $request, \App\Services\DisappearingMessageService $disappearingMessageService)
    {
        $request->validate([
            'chat_id' => 'required',
            'duration' => 'required|integer'
        ]);

        $disappearingMessageService->setChatTimer((string)$request->chat_id, $request->duration);

        return response()->json(['status' => true, 'message' => 'Disappearing message timer updated for this chat']);
    }

    // 🚫 Block/Unblock User
    public function toggleBlockUser(Request $request)
    {
        $db = $this->db;

        $request->validate([
            'blocked_user_id' => 'required',
            'action' => 'required|in:block,unblock'
        ]);

        $userId = auth()->id();
        if (!$userId) return response()->json(['status' => false, 'message' => 'Unauthorized'], 401);

        if ($request->action === 'block') {
            $db->getReference("users/{$userId}/blocked/{$request->blocked_user_id}")->set(true);
            $message = 'User blocked';
        } else {
            $db->getReference("users/{$userId}/blocked/{$request->blocked_user_id}")->remove();
            $message = 'User unblocked';
        }

        return response()->json(['status' => true, 'message' => $message]);
    }

    // 🧹 Clear Chat
    public function clearChat(Request $request)
    {
        $db = $this->db;

        $request->validate(['chat_id' => 'required']);
        $userId = auth()->id();
        if (!$userId) return response()->json(['status' => false, 'message' => 'Unauthorized'], 401);

        $db->getReference("chats/{$request->chat_id}/settings/{$userId}/cleared_at")
            ->set(now()->timestamp);

        return response()->json(['status' => true, 'message' => 'Chat cleared']);
    }

    // 🗑️ Delete Chat
    public function deleteChat(Request $request)
    {
        $db = $this->db;

        $request->validate(['chat_id' => 'required']);
        $userId = auth()->id();
        if (!$userId) return response()->json(['status' => false, 'message' => 'Unauthorized'], 401);

        $db->getReference("chats/{$request->chat_id}/settings/{$userId}/deleted_at")
            ->set(now()->timestamp);

        return response()->json(['status' => true, 'message' => 'Chat deleted']);
    }

    // 🚨 Report User/Chat
    public function reportUser(Request $request)
    {
        $request->validate([
            'reported_id' => 'required',
            'reason' => 'required|string'
        ]);

        $db = $this->db;

        $userId = auth()->id();
        if (!$userId) return response()->json(['status' => false, 'message' => 'Unauthorized'], 401);
        $reportId = 'report_' . time() . '_' . uniqid();

        $db->getReference("reports/{$reportId}")->set([
            'reporter_id' => $userId,
            'reported_id' => $request->reported_id,
            'chat_id' => $request->chat_id ?? null,
            'reason' => $request->reason,
            'time' => now()->timestamp
        ]);

        return response()->json(['status' => true, 'message' => 'Report submitted successfully']);
    }

    // 🔒 Get Hide Chat Settings (Password hash and Hidden Chats)
    public function getHideChatSettings(Request $request)
    {
        $db = $this->db;

        $userId = auth()->id();
        if (!$userId) return response()->json(['status' => false, 'message' => 'Unauthorized'], 401);
        
        $settings = $db->getReference("users/{$userId}/hide_chat_settings")->getValue() ?: [
            'hidden_chats' => [],
            'password' => null,
            'password_hash' => null
        ];

        // Ensure backward compatibility
        if (isset($settings['password']) && !isset($settings['password_hash'])) {
            $settings['password_hash'] = \Illuminate\Support\Facades\Hash::make($settings['password']);
        }
        unset($settings['password']);

        return response()->json([
            'status' => true,
            'data' => $settings
        ]);
    }

    // 🔒 Save Hide Chat Settings
    public function saveHideChatSettings(Request $request)
    {
        $db = $this->db;

        $request->validate([
            'password' => 'nullable|string',
            'password_hash' => 'nullable|string',
            'hidden_chats' => 'nullable|array'
        ]);

        $userId = auth()->id();
        if (!$userId) return response()->json(['status' => false, 'message' => 'Unauthorized'], 401);
        
        $pwd = $request->input('password') ?? $request->input('password_hash');
        $hashedPwd = $pwd ? \Illuminate\Support\Facades\Hash::make($pwd) : null;

        $settings = [
            'password_hash' => $hashedPwd,
            'hidden_chats' => $request->input('hidden_chats', [])
        ];

        $db->getReference("users/{$userId}/hide_chat_settings")->set($settings);

        return response()->json([
            'status' => true,
            'message' => 'Hide Chat settings updated successfully'
        ]);
    }
}
