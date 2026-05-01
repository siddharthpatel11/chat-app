<?php

namespace App\Http\Controllers;

use Kreait\Firebase\Factory;
use Illuminate\Http\Request;
use App\Events\MessageSent;

class ChatController extends Controller
{
    public function index()
    {
        $users = \App\Models\User::where('id', '!=', auth()->id())->get();
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
        $name = $request->query('name', 'User');
        $avatar = $request->query('avatar');
        if (empty($avatar)) {
            $avatar = 'https://ui-avatars.com/api/?name=' . urlencode($name) . '&background=202c33&color=fff&size=280';
        }
        $role = $request->query('role', 'caller');
        $callId = $request->query('call_id', null);
        $calleeId = $request->query('callee_id', null);
        $groupCallId = $request->query('group_call_id', null);
        $myUserId = auth()->id();
        $myName = auth()->user()->name ?? 'Me';
        $myAvatar = auth()->user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($myName) . '&background=202c33&color=fff&size=280';
        $users = \App\Models\User::where('id', '!=', auth()->id())->get(['id', 'name', 'avatar', 'phone']);
        return view('chat.calls.voice_call', compact('name', 'avatar', 'role', 'callId', 'calleeId', 'groupCallId', 'myUserId', 'myName', 'myAvatar', 'users'));
    }

    public function videoCall(Request $request)
    {
        $name = $request->query('name', 'User');
        $avatar = $request->query('avatar');
        if (empty($avatar)) {
            $avatar = 'https://ui-avatars.com/api/?name=' . urlencode($name) . '&background=202c33&color=fff&size=280';
        }
        $role = $request->query('role', 'caller');
        $callId = $request->query('call_id', null);
        $calleeId = $request->query('callee_id', null);
        $groupCallId = $request->query('group_call_id', null);
        $myUserId = auth()->id();
        $myName = auth()->user()->name ?? 'Me';
        $myAvatar = auth()->user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($myName) . '&background=202c33&color=fff&size=280';
        $users = \App\Models\User::where('id', '!=', auth()->id())->get(['id', 'name', 'avatar', 'phone']);
        return view('chat.calls.video_call', compact('name', 'avatar', 'role', 'callId', 'calleeId', 'groupCallId', 'myUserId', 'myName', 'myAvatar', 'users'));
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
}
