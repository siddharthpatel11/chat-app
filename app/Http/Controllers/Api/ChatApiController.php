<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class ChatApiController extends Controller
{
    protected $db;

    protected $messaging;

    public function __construct()
    {
        $factory = (new Factory)
            ->withServiceAccount(storage_path('app/firebase.json'))
            ->withDatabaseUri(env('FIREBASE_DATABASE_URL'));

        $this->db = $factory->createDatabase();
        $this->messaging = $factory->createMessaging();
    }

    public function send(Request $request)
    {
        $chatId = $request->chat_id;
        $senderId = $request->sender_id ?? 1;

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
            $fileUrl = url('storage/'.$path);
        }

        // 📍 Location support
        if ($request->type === 'location' || $request->type === 'live_location') {
            $type = $request->type;
            $lat = $request->lat;
            $lng = $request->lng;
        }

        // Check if blocked
        $chatData = $this->db->getReference("chats/$chatId")->getValue();
        $receiverId = null;
        if (isset($chatData['users'])) {
            foreach ($chatData['users'] as $uid) {
                if ($uid != $senderId) {
                    $receiverId = $uid;
                    break;
                }
            }
        }

        if ($receiverId) {
            $isBlocked = $this->db->getReference("users/{$receiverId}/blocked/{$senderId}")->getValue();
            if ($isBlocked) {
                return response()->json(['status' => false, 'message' => 'You cannot send messages to this user (Blocked)'], 403);
            }
        }

        $data = [
            'sender_id' => $senderId,
            'text' => $request->message ?? '',
            'type' => $type,
            'file_url' => $fileUrl,
            'file_name' => $fileName,
            'reply_to_id' => $request->reply_to_id ?? null,
            'reply_to_text' => $request->reply_to_text ?? null,
            'lat' => $lat,
            'lng' => $lng,
            'duration' => $request->duration ?? null,
            'time' => now()->timestamp,
            'status' => 'sent',
        ];

        // Push to Realtime Database
        $this->db->getReference("chats/$chatId/messages")->push($data);

        // Update chat metadata with last message info
        $this->db->getReference("chats/$chatId")->update([
            'last_message' => $request->message ?: ucfirst($type),
            'last_message_time' => $data['time'],
            'updated_at' => now()->timestamp,
        ]);

        // 🔔 Better notification text
        $notifyText = $request->message;

        if ($type == 'image') {
            $notifyText = '📷 Image';
        }
        if ($type == 'video') {
            $notifyText = '🎥 Video';
        }
        if ($type == 'audio') {
            $notifyText = '🎧 Audio';
        }
        if ($type == 'document') {
            $notifyText = '📄 Document';
        }
        if ($type == 'location') {
            $notifyText = '📍 Location';
        }
        if ($type == 'live_location') {
            $notifyText = '🔴 Live location';
        }

        // Send FCM Notification to all other users in system with a token
        // In a real app, you'd filter by users in this specific chat
        $receivers = User::where('id', '!=', $senderId)
            ->whereNotNull('fcm_token')
            ->get();

        foreach ($receivers as $user) {
            $message = CloudMessage::withTarget('token', $user->fcm_token)
                ->withNotification(Notification::create('New Message', $request->message))
                ->withData(['chat_id' => $chatId]);

            try {
                $this->messaging->send($message);
            } catch (\Exception $e) {
                Log::error('API FCM Send Error: '.$e->getMessage());
            }
        }

        return response()->json([
            'status' => true,
            'message' => 'Message sent',
            'data' => $data,
        ]);
    }

    // Save FCM Token via API
    public function saveToken(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'token' => 'required',
        ]);

        $user = User::find($request->user_id);
        if ($user) {
            $user->update(['fcm_token' => $request->token]);

            return response()->json(['status' => true, 'message' => 'Token saved']);
        }

        return response()->json(['status' => false, 'message' => 'User not found'], 404);
    }

    // Get message
    public function messages(Request $request, $chatId)
    {
        $userId = auth()->id() ?? $request->user_id;
        $messages = $this->db->getReference("chats/$chatId/messages")->getValue();

        $clearedAt = $userId ? $this->db->getReference("chats/$chatId/settings/$userId/cleared_at")->getValue() : null;

        if ($messages && $clearedAt) {
            $filteredMessages = [];
            foreach ($messages as $msgId => $msg) {
                if (isset($msg['time']) && $msg['time'] >= $clearedAt) {
                    $filteredMessages[$msgId] = $msg;
                }
            }
            $messages = $filteredMessages;
        }

        $isBlocked = false;
        $chatData = $this->db->getReference("chats/$chatId")->getValue();
        if ($chatData && isset($chatData['users'])) {
            foreach ($chatData['users'] as $u) {
                if ($u != $userId) {
                    $isBlocked = $this->db->getReference("users/{$userId}/blocked/{$u}")->getValue() ? true : false;
                    break;
                }
            }
        }

        return response()->json([
            'status' => true,
            'is_blocked' => $isBlocked,
            'data' => $messages ?: [],
        ]);
    }

    // Search messages within a specific chat
    public function searchInChat(Request $request, $chatId)
    {
        $query = $request->query('query');
        if (! $query) {
            return response()->json([
                'status' => false,
                'message' => 'Query parameter is required',
            ], 400);
        }

        $messages = $this->db->getReference("chats/$chatId/messages")->getValue();
        $results = [];

        if ($messages) {
            foreach ($messages as $msgId => $msg) {
                if (isset($msg['text']) && stripos($msg['text'], $query) !== false) {
                    $results[] = array_merge($msg, ['id' => $msgId]);
                }
            }
        }

        // Sort by time descending
        usort($results, function ($a, $b) {
            return ($b['time'] ?? 0) - ($a['time'] ?? 0);
        });

        return response()->json([
            'status' => true,
            'data' => $results,
        ]);
    }

    // Create chat
    public function createChat(Request $request)
    {
        $users = $request->users;

        if (! $users || ! is_array($users) || count($users) < 2) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid users array provided',
            ], 400);
        }

        // Sort to ensure consistent matching [1, 2] == [2, 1]
        $sortedUsers = $users;
        sort($sortedUsers);

        // Check if a chat already exists for these users
        $chats = $this->db->getReference('chats')->getValue();

        if ($chats) {
            foreach ($chats as $chatId => $chatData) {
                if (isset($chatData['users']) && is_array($chatData['users'])) {
                    $existingUsers = $chatData['users'];
                    sort($existingUsers);

                    if ($existingUsers == $sortedUsers) {
                        return response()->json([
                            'status' => true,
                            'chat_id' => $chatId,
                            'message' => 'Chat already exists',
                        ]);
                    }
                }
            }
        }

        // Create new chat
        $chatId = 'chat_'.time().'_'.uniqid();

        $data = [
            'users' => $users,
            'created_at' => now()->timestamp,
            'updated_at' => now()->timestamp,
        ];

        $this->db->getReference("chats/$chatId")->set($data);

        return response()->json([
            'status' => true,
            'chat_id' => $chatId,
            'message' => 'Chat created successfully',
        ]);
    }

    // Chat List
    public function chatList(Request $request)
    {
        $userId = $request->user_id ?? auth()->id();

        if (! $userId) {
            return response()->json([
                'status' => false,
                'message' => 'User ID is required',
            ], 400);
        }

        $chats = $this->db->getReference('chats')->getValue();
        $userChats = [];

        if ($chats) {
            foreach ($chats as $chatId => $chatData) {
                if (isset($chatData['users']) && in_array($userId, $chatData['users'])) {
                    $isDeleted = isset($chatData['settings'][$userId]['deleted_at']);

                    if (! $isDeleted) {
                        $chatData['user_settings'] = $chatData['settings'][$userId] ?? [];
                        unset($chatData['settings']); // remove other users settings

                        $chatData['is_blocked'] = false;
                        foreach ($chatData['users'] as $u) {
                            if ($u != $userId) {
                                $chatData['is_blocked'] = $this->db->getReference("users/{$userId}/blocked/{$u}")->getValue() ? true : false;
                                break;
                            }
                        }

                        $userChats[$chatId] = $chatData;
                    }
                }
            }
        }

        // Sort chats by updated_at or last_message_time descending
        uasort($userChats, function ($a, $b) {
            $timeA = $a['updated_at'] ?? $a['last_message_time'] ?? $a['created_at'] ?? 0;
            $timeB = $b['updated_at'] ?? $b['last_message_time'] ?? $b['created_at'] ?? 0;

            return $timeB <=> $timeA;
        });

        return response()->json([
            'status' => true,
            'data' => $userChats,
        ]);
    }

    public function updateLiveLocation(Request $request)
    {
        $this->db->getReference('live_locations/user_'.$request->sender_id)->set([
            'chat_id' => $request->chat_id,
            'lat' => $request->lat,
            'lng' => $request->lng,
            'time' => now()->timestamp,
        ]);

        return response()->json(['status' => true]);
    }

    // Get Users List (MySQL)
    public function users(Request $request)
    {
        $userId = $request->user_id ?? auth()->id();
        $search = $request->search;

        $query = User::query();
        if ($userId) {
            $query->where('id', '!=', $userId);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('phone', 'LIKE', "%{$search}%");
            });
        }

        $users = $query->get();

        return response()->json([
            'status' => true,
            'data' => $users,
        ]);
    }

    // Global Search (Users + Messages)
    public function globalSearch(Request $request)
    {
        $query = $request->query('query');
        if (! $query) {
            return response()->json([
                'status' => false,
                'message' => 'Query parameter is required',
            ], 400);
        }

        $userId = $request->user_id ?? auth()->id();

        // 1. Search Users
        $users = User::where('id', '!=', $userId)
            ->where(function ($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                    ->orWhere('phone', 'LIKE', "%{$query}%");
            })
            ->get();

        // 2. Search Messages in Firebase
        $allMsgResults = [];
        $chats = $this->db->getReference('chats')->getValue();

        // Cache users to avoid repeated DB lookups
        $allUsers = User::all()->keyBy('id');

        if ($chats) {
            foreach ($chats as $chatId => $chatData) {
                if (isset($chatData['messages'])) {
                    // Identify the other user in this chat to provide context in results
                    $otherUser = null;
                    if (isset($chatData['users'])) {
                        foreach ($chatData['users'] as $uId) {
                            if ($uId != $userId && isset($allUsers[$uId])) {
                                $otherUser = $allUsers[$uId];
                                break;
                            }
                        }
                    }

                    foreach ($chatData['messages'] as $msgId => $msg) {
                        if (isset($msg['text']) && stripos($msg['text'], $query) !== false) {
                            $allMsgResults[] = [
                                'chat_id' => $chatId,
                                'message_id' => $msgId,
                                'text' => $msg['text'],
                                'sender_id' => $msg['sender_id'] ?? null,
                                'time' => $msg['time'] ?? null,
                                'type' => $msg['type'] ?? 'text',
                                'user' => $otherUser ? [
                                    'id' => $otherUser->id,
                                    'name' => $otherUser->name,
                                    'avatar' => $otherUser->avatar,
                                ] : null,
                            ];
                        }
                    }
                }
            }
        }

        // Sort messages by time (newest first)
        usort($allMsgResults, function ($a, $b) {
            return ($b['time'] ?? 0) - ($a['time'] ?? 0);
        });

        return response()->json([
            'status' => true,
            'data' => [
                'users' => $users,
                'messages' => $allMsgResults,
            ],
        ]);
    }

    // Create New User (Register via API)
    public function registerUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone ?? null,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'User created successfully',
            'data' => $user,
        ]);
    }

    // Edit Profile API
    public function updateProfile(Request $request)
    {
        $userId = $request->user_id ?? auth()->id();
        $user = User::find($userId);

        if (! $user) {
            return response()->json(['status' => false, 'message' => 'User not found'], 404);
        }

        $data = [];
        if ($request->has('name')) {
            $data['name'] = $request->name;
        }
        if ($request->has('phone')) {
            $data['phone'] = $request->phone;
        }
        if ($request->has('about')) {
            $data['about'] = $request->about;
            // Automatically set dynamic update time on server side if not provided
            if (! $request->has('about_subtitle')) {
                $data['about_subtitle'] = 'UPDATED|'.now()->toIso8601String();
            }
        }
        if ($request->has('about_subtitle')) {
            $data['about_subtitle'] = $request->about_subtitle;
        }

        // 🖼️ Handle Avatar Upload
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $path = $file->store('avatars', 'public');
            $data['avatar'] = url('storage/'.$path);
        }

        if (empty($data)) {
            return response()->json(['status' => false, 'message' => 'No data provided'], 400);
        }

        $user->update($data);

        return response()->json([
            'status' => true,
            'message' => 'Profile updated successfully',
            'data' => $user,
        ]);
    }

    public function checkPhone(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
        ]);

        // Clean phone number (remove spaces, etc) if needed
        $phone = preg_replace('/\s+/', '', $request->phone);

        $user = User::where('phone', $phone)
            ->orWhere('phone', 'like', '%'.$phone)
            ->first();

        if ($user) {
            return response()->json([
                'status' => true,
                'message' => 'This phone number is on WhatsApp.',
                'user' => $user,
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'This phone number is not on WhatsApp. Invite them on your primary device.',
        ]);
    }

    public function saveContact(Request $request)
    {
        $request->validate([
            'contact_user_id' => 'required|exists:users,id',
            'custom_name' => 'nullable|string|max:255',
        ]);

        $userId = auth()->id();
        if (! $userId) {
            return response()->json(['status' => false, 'message' => 'Unauthorized'], 401);
        }

        $contact = Contact::updateOrCreate(
            ['user_id' => $userId, 'contact_user_id' => $request->contact_user_id],
            ['custom_name' => $request->custom_name]
        );

        return response()->json([
            'status' => true,
            'message' => 'Contact saved successfully',
            'contact' => $contact,
        ]);
    }

    public function deleteContact(Request $request)
    {
        $request->validate([
            'contact_user_id' => 'required|exists:users,id',
        ]);

        $userId = auth()->id();
        if (! $userId) {
            return response()->json(['status' => false, 'message' => 'Unauthorized'], 401);
        }

        Contact::where('user_id', $userId)
            ->where('contact_user_id', $request->contact_user_id)
            ->delete();

        return response()->json([
            'status' => true,
            'message' => 'Contact deleted successfully',
        ]);
    }

    //  Initiate Voice / Video Call
    public function initiateCall(Request $request)
    {
        $request->validate([
            'caller_id' => 'required',
            'receiver_id' => 'required',
            'call_type' => 'required|in:voice,video', // voice or video
        ]);

        $callId = 'call_'.time().'_'.uniqid();
        $caller = User::find($request->caller_id);

        $data = [
            'caller_id' => $request->caller_id,
            'receiver_id' => $request->receiver_id,
            'call_type' => $request->call_type,
            'status' => 'calling', // calling, ringing, accepted, rejected, ended
            'time' => now()->timestamp,
        ];

        // Save call info in Firebase
        $this->db->getReference("calls/$callId")->set($data);

        // Send Notification to Receiver
        $receiver = User::find($request->receiver_id);
        if ($receiver && $receiver->fcm_token) {
            $title = 'Incoming '.ucfirst($request->call_type).' Call';
            $body = ($caller ? $caller->name : 'Someone').' is calling you';

            $message = CloudMessage::withTarget('token', $receiver->fcm_token)
                ->withNotification(Notification::create($title, $body))
                ->withData([
                    'type' => 'call',
                    'call_id' => $callId,
                    'caller_id' => $request->caller_id,
                    'call_type' => $request->call_type,
                ]);

            try {
                $this->messaging->send($message);
            } catch (\Exception $e) {
                Log::error('Call FCM Error: '.$e->getMessage());
            }
        }

        return response()->json([
            'status' => true,
            'message' => 'Call initiated',
            'call_id' => $callId,
        ]);
    }

    //  Update Call Status (Accept / Reject / End)
    public function updateCallStatus(Request $request)
    {
        $request->validate([
            'call_id' => 'required',
            'status' => 'required|in:ringing,accepted,rejected,ended',
        ]);

        $this->db->getReference('calls/'.$request->call_id)->update([
            'status' => $request->status,
            'updated_at' => now()->timestamp,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Call status updated to '.$request->status,
        ]);
    }

    // Get Single Contact/User Info
    public function contactInfo($userId)
    {
        $user = User::find($userId);

        if (! $user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found',
            ], 404);
        }

        // Check if current user has saved this contact
        $authId = auth()->id() ?? request('user_id');
        $isSaved = false;
        $customName = null;

        if ($authId) {
            $contact = Contact::where('user_id', $authId)
                ->where('contact_user_id', $userId)
                ->first();

            if ($contact) {
                $isSaved = true;
                $customName = $contact->custom_name;
            }
        }

        return response()->json([
            'status' => true,
            'data' => [
                'user' => $user,
                'is_saved' => $isSaved,
                'saved_name' => $customName,
            ],
        ]);
    }

    // Update Chat Settings (Mute, Lock, Fav, Disappearing)
    public function updateChatSettings(Request $request)
    {
        $request->validate([
            'chat_id' => 'required',
            'setting_key' => 'required|string',
            'setting_value' => 'required',
        ]);

        $userId = auth()->id() ?? $request->user_id;

        $this->db->getReference("chats/{$request->chat_id}/settings/{$userId}/{$request->setting_key}")
            ->set($request->setting_value);

        return response()->json([
            'status' => true,
            'message' => 'Settings updated successfully',
        ]);
    }

    //  Block/Unblock User
    public function toggleBlockUser(Request $request)
    {
        $request->validate([
            'blocked_user_id' => 'required',
            'action' => 'required|in:block,unblock',
        ]);

        $userId = auth()->id() ?? $request->user_id;

        if ($request->action === 'block') {
            $this->db->getReference("users/{$userId}/blocked/{$request->blocked_user_id}")->set(true);
            $message = 'User blocked';
        } else {
            $this->db->getReference("users/{$userId}/blocked/{$request->blocked_user_id}")->remove();
            $message = 'User unblocked';
        }

        return response()->json(['status' => true, 'message' => $message]);
    }

    //  Clear Chat
    public function clearChat(Request $request)
    {
        $request->validate(['chat_id' => 'required']);
        $userId = auth()->id() ?? $request->user_id;

        $this->db->getReference("chats/{$request->chat_id}/settings/{$userId}/cleared_at")
            ->set(now()->timestamp);

        return response()->json(['status' => true, 'message' => 'Chat cleared']);
    }

    //  Delete Chat
    public function deleteChat(Request $request)
    {
        $request->validate(['chat_id' => 'required']);
        $userId = auth()->id() ?? $request->user_id;

        $this->db->getReference("chats/{$request->chat_id}/settings/{$userId}/deleted_at")
            ->set(now()->timestamp);

        return response()->json(['status' => true, 'message' => 'Chat deleted']);
    }

    //  Report User/Chat
    public function reportUser(Request $request)
    {
        $request->validate([
            'reported_id' => 'required',
            'reason' => 'required|string',
        ]);

        $userId = auth()->id() ?? $request->user_id;
        $reportId = 'report_'.time().'_'.uniqid();

        $this->db->getReference("reports/{$reportId}")->set([
            'reporter_id' => $userId,
            'reported_id' => $request->reported_id,
            'chat_id' => $request->chat_id ?? null,
            'reason' => $request->reason,
            'time' => now()->timestamp,
        ]);

        return response()->json(['status' => true, 'message' => 'Report submitted successfully']);
    }
}
