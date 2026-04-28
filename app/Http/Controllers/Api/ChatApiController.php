<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Kreait\Firebase\Factory;

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
            $fileUrl = url('storage/' . $path);
        }

        // 📍 Location support
        if ($request->type === 'location' || $request->type === 'live_location') {
            $type = $request->type;
            $lat = $request->lat;
            $lng = $request->lng;
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
            'status' => 'sent'
        ];

        // Push to Realtime Database
        $this->db->getReference("chats/$chatId/messages")->push($data);

        // 🔔 Better notification text
        $notifyText = $request->message;

        if ($type == 'image') $notifyText = '📷 Image';
        if ($type == 'video') $notifyText = '🎥 Video';
        if ($type == 'audio') $notifyText = '🎧 Audio';
        if ($type == 'document') $notifyText = '📄 Document';
        if ($type == 'location') $notifyText = '📍 Location';
        if ($type == 'live_location') $notifyText = '🔴 Live location';


        // Send FCM Notification to all other users in system with a token
        // In a real app, you'd filter by users in this specific chat
        $receivers = \App\Models\User::where('id', '!=', $senderId)
            ->whereNotNull('fcm_token')
            ->get();

        foreach ($receivers as $user) {
            $message = \Kreait\Firebase\Messaging\CloudMessage::withTarget('token', $user->fcm_token)
                ->withNotification(\Kreait\Firebase\Messaging\Notification::create('New Message', $request->message))
                ->withData(['chat_id' => $chatId]);

            try {
                $this->messaging->send($message);
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('API FCM Send Error: ' . $e->getMessage());
            }
        }

        return response()->json([
            'status' => true,
            'message' => 'Message sent',
            'data' => $data
        ]);
    }

    // Save FCM Token via API
    public function saveToken(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'token' => 'required'
        ]);

        $user = \App\Models\User::find($request->user_id);
        if ($user) {
            $user->update(['fcm_token' => $request->token]);
            return response()->json(['status' => true, 'message' => 'Token saved']);
        }

        return response()->json(['status' => false, 'message' => 'User not found'], 404);
    }

    //Get message
    public function messages($chatId)
    {
        $messages = $this->db->getReference("chats/$chatId/messages")->getValue();

        return response()->json([
            'status' => true,
            'data'=> $messages
        ]);
    }

    //Create chat
    public function createChat(Request $request)
    {
        $chatId = 'chat_' . time();

        $data = [
            'users' => $request->users
        ];

        $this->db->getReference("chats/$chatId")->set($data);

        return response()->json([
            'chat_id' => $chatId
        ]);
    }

    //Chat List
    public function chatList()
    {
        $chats = $this->db->getReference("chats")->getValue();

        return response()->json([
            'status' => true,
            'data' => $chats
        ]);
    }

    public function updateLiveLocation(Request $request)
    {
        $this->db->getReference("live_locations/user_" . $request->sender_id)->set([
            'chat_id' => $request->chat_id,
            'lat' => $request->lat,
            'lng' => $request->lng,
            'time' => now()->timestamp
        ]);

        return response()->json(['status' => true]);
    }

    // Get Users List (MySQL)
    public function users(Request $request)
    {
        $userId = $request->user_id ?? auth()->id();
        
        $query = \App\Models\User::query();
        if ($userId) {
            $query->where('id', '!=', $userId);
        }
        
        $users = $query->get();

        return response()->json([
            'status' => true,
            'data' => $users
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

        $user = \App\Models\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
            'phone' => $request->phone ?? null,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'User created successfully',
            'data' => $user
        ]);
    }
    // Edit Profile API
    public function updateProfile(Request $request)
    {
        $userId = $request->user_id ?? auth()->id();
        $user = \App\Models\User::find($userId);

        if (!$user) {
            return response()->json(['status' => false, 'message' => 'User not found'], 404);
        }

        $data = [];
        if ($request->has('name')) $data['name'] = $request->name;
        if ($request->has('phone')) $data['phone'] = $request->phone;
        if ($request->has('about')) {
            $data['about'] = $request->about;
            // Automatically set dynamic update time on server side if not provided
            if (!$request->has('about_subtitle')) {
                $data['about_subtitle'] = 'UPDATED|' . now()->toIso8601String();
            }
        }
        if ($request->has('about_subtitle')) $data['about_subtitle'] = $request->about_subtitle;

        // 🖼️ Handle Avatar Upload
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $path = $file->store('avatars', 'public');
            $data['avatar'] = url('storage/' . $path);
        }

        if (empty($data)) {
            return response()->json(['status' => false, 'message' => 'No data provided'], 400);
        }

        $user->update($data);

        return response()->json([
            'status' => true,
            'message' => 'Profile updated successfully',
            'data' => $user
        ]);
    }
}
