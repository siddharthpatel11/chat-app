<?php

namespace App\Http\Controllers;

use Kreait\Firebase\Factory;
use Illuminate\Http\Request;
use App\Events\MessageSent;
use Illuminate\Support\Facades\Schema;

class ChatController extends Controller
{
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
        $factory = (new Factory)
            ->withServiceAccount(storage_path('app/firebase.json'))
            ->withDatabaseUri(env('FIREBASE_DATABASE_URL'));

        $db = $factory->createDatabase();
        $messaging = $factory->createMessaging();

        $chatId = $request->chat_id;
        $senderId = auth()->id() ?? 1;

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
            'reply_to_name' => $request->reply_to_name ?? null,
            'lat' => $lat,
            'lng' => $lng,
            'duration' => $request->duration ?? null,
            'time' => now()->timestamp,
            'status' => 'sent',
        ];

        // Push to Realtime Database
        $db->getReference("chats/$chatId/messages")->push($data);

        // Send FCM Notification to all other users with a token
        $receivers = \App\Models\User::where('id', '!=', $senderId)
            ->whereNotNull('fcm_token')
            ->get();

        $senderName = auth()->user()->name ?? 'Someone';
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
        }

        foreach ($receivers as $user) {
            $message = \Kreait\Firebase\Messaging\CloudMessage::withTarget('token', $user->fcm_token)
                ->withNotification(\Kreait\Firebase\Messaging\Notification::create($senderName, $notificationBody))
                ->withData([
                    'chat_id' => $chatId,
                    'type' => $type,
                    'sender_name' => $senderName,
                    'sender_id' => (string)$senderId,
                    'click_action' => 'FLUTTER_NOTIFICATION_CLICK' // For mobile apps if any
                ]);

            try {
                $messaging->send($message);
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('FCM Send Error: ' . $e->getMessage());
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
        $factory = (new Factory)
            ->withServiceAccount(storage_path('app/firebase.json'))
            ->withDatabaseUri(env('FIREBASE_DATABASE_URL'));

        $db = $factory->createDatabase();

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
        $factory = (new Factory)
            ->withServiceAccount(storage_path('app/firebase.json'))
            ->withDatabaseUri(env('FIREBASE_DATABASE_URL'));

        $db = $factory->createDatabase();
        $messaging = $factory->createMessaging();

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
            ->whereNotNull('fcm_token')
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

        foreach ($receivers as $user) {
            $message = \Kreait\Firebase\Messaging\CloudMessage::withTarget('token', $user->fcm_token)
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
                $messaging->send($message);
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Group FCM Send Error: ' . $e->getMessage());
            }
        }

        return response()->json(['status' => true]);
    }
}
