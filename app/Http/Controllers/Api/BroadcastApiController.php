<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class BroadcastApiController extends Controller
{
    protected $db;
    protected $messaging;

    public function __construct()
    {
        $firebaseService = app(\App\Services\FirebaseService::class);
        $this->db = $firebaseService->database();
        $this->messaging = $firebaseService->messaging();
    }

    // 1. Create Broadcast List
    public function create(Request $request)
    {
        if (is_string($request->users)) {
            $request->merge(['users' => json_decode($request->users, true)]);
        }

        $request->validate([
            'name' => 'required|string',
            'users' => 'required|array', // array of recipient user IDs
        ]);

        $userId = auth()->id() ?? $request->user_id;
        if (!$userId) {
            return response()->json(['status' => false, 'message' => 'User ID is required'], 400);
        }

        $recipients = array_values(array_unique($request->users));
        $broadcastId = 'bcast_' . time() . '_' . uniqid();

        // Fetch recipient user details so web can display names/avatars
        $recipientUsers = User::whereIn('id', $recipients)->get(['id', 'name', 'avatar', 'phone']);
        $recipientsInfo = $recipientUsers->map(fn($u) => [
            'id'     => $u->id,
            'name'   => $u->name,
            'avatar' => $u->avatar ?? '',
        ])->values()->toArray();

        $data = [
            'id'              => $broadcastId,
            'name'            => $request->name,
            'users'           => $recipients,
            'recipients_info' => $recipientsInfo,  // ← web reads this for display
            'created_by'      => $userId,
            'created_at'      => now()->timestamp,
            'updated_at'      => now()->timestamp,
        ];

        $this->db->getReference("broadcasts/$broadcastId")->set($data);

        return response()->json([
            'status'       => true,
            'broadcast_id' => $broadcastId,
            'message'      => 'Broadcast list created successfully',
            'data'         => $data
        ]);
    }

    // 2. Get User's Broadcast Lists
    public function list(Request $request)
    {
        $userId = auth()->id() ?? $request->user_id;
        if (!$userId) {
            return response()->json(['status' => false, 'message' => 'User ID is required'], 400);
        }

        $allBroadcasts = $this->db->getReference('broadcasts')->getValue();
        $userLists = [];

        if ($allBroadcasts) {
            foreach ($allBroadcasts as $id => $data) {
                if (isset($data['created_by']) && $data['created_by'] == $userId) {
                    // Fetch recipient user details
                    $recipientIds = $data['users'] ?? [];
                    $recipients = User::whereIn('id', $recipientIds)->get(['id', 'name', 'avatar', 'phone']);
                    $data['recipients'] = $recipients;
                    $userLists[] = $data;
                }
            }
        }

        return response()->json([
            'status' => true,
            'data' => $userLists
        ]);
    }

    // 3. Add Recipients
    public function addRecipients(Request $request, $broadcastId)
    {
        if (is_string($request->users)) {
            $request->merge(['users' => json_decode($request->users, true)]);
        }

        $request->validate([
            'users' => 'required|array'
        ]);

        $userId = auth()->id() ?? $request->user_id;
        if (!$userId) {
            return response()->json(['status' => false, 'message' => 'User ID is required'], 400);
        }

        $bcastRef = $this->db->getReference("broadcasts/$broadcastId");
        $broadcast = $bcastRef->getValue();

        if (!$broadcast) {
            return response()->json(['status' => false, 'message' => 'Broadcast list not found'], 404);
        }

        if ($broadcast['created_by'] != $userId) {
            return response()->json(['status' => false, 'message' => 'Unauthorized'], 403);
        }

        $currentUsers = $broadcast['users'] ?? [];
        $newUsers = array_merge($currentUsers, $request->users);
        $newUsers = array_values(array_unique($newUsers));

        // Rebuild recipients_info for the web
        $recipientUsers = User::whereIn('id', $newUsers)->get(['id', 'name', 'avatar']);
        $recipientsInfo = $recipientUsers->map(fn($u) => [
            'id'     => $u->id,
            'name'   => $u->name,
            'avatar' => $u->avatar ?? '',
        ])->values()->toArray();

        $bcastRef->update([
            'users'           => $newUsers,
            'recipients_info' => $recipientsInfo,
            'updated_at'      => now()->timestamp
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Recipients added successfully'
        ]);
    }

    // 4. Remove Recipient
    public function removeRecipient(Request $request, $broadcastId)
    {
        $request->validate([
            'remove_user_id' => 'required'
        ]);

        $userId = auth()->id() ?? $request->user_id;
        if (!$userId) {
            return response()->json(['status' => false, 'message' => 'User ID is required'], 400);
        }
        $removeUserId = $request->remove_user_id;

        $bcastRef = $this->db->getReference("broadcasts/$broadcastId");
        $broadcast = $bcastRef->getValue();

        if (!$broadcast) {
            return response()->json(['status' => false, 'message' => 'Broadcast list not found'], 404);
        }

        if ($broadcast['created_by'] != $userId) {
            return response()->json(['status' => false, 'message' => 'Unauthorized'], 403);
        }

        $currentUsers = $broadcast['users'] ?? [];
        $currentUsers = array_filter($currentUsers, function($uid) use ($removeUserId) {
            return $uid != $removeUserId;
        });
        $currentUsers = array_values($currentUsers);

        // Rebuild recipients_info for the web
        $recipientUsers = User::whereIn('id', $currentUsers)->get(['id', 'name', 'avatar']);
        $recipientsInfo = $recipientUsers->map(fn($u) => [
            'id'     => $u->id,
            'name'   => $u->name,
            'avatar' => $u->avatar ?? '',
        ])->values()->toArray();

        $bcastRef->update([
            'users'           => $currentUsers,
            'recipients_info' => $recipientsInfo,
            'updated_at'      => now()->timestamp
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Recipient removed successfully'
        ]);
    }

    // 5. Delete Broadcast List
    public function delete(Request $request, $broadcastId)
    {
        $userId = auth()->id() ?? $request->user_id;
        if (!$userId) {
            return response()->json(['status' => false, 'message' => 'User ID is required'], 400);
        }

        $bcastRef = $this->db->getReference("broadcasts/$broadcastId");
        $broadcast = $bcastRef->getValue();

        if (!$broadcast) {
            return response()->json(['status' => false, 'message' => 'Broadcast list not found'], 404);
        }

        if ($broadcast['created_by'] != $userId) {
            return response()->json(['status' => false, 'message' => 'Unauthorized'], 403);
        }

        $bcastRef->remove();

        return response()->json([
            'status' => true,
            'message' => 'Broadcast list deleted successfully'
        ]);
    }

    // 6. Get Broadcast Messages
    public function getMessages(Request $request, $broadcastId)
    {
        $userId = auth()->id() ?? $request->user_id;
        if (!$userId) {
            return response()->json(['status' => false, 'message' => 'User ID is required'], 400);
        }

        $broadcast = $this->db->getReference("broadcasts/$broadcastId")->getValue();

        if (!$broadcast) {
            return response()->json(['status' => false, 'message' => 'Broadcast list not found'], 404);
        }

        if ($broadcast['created_by'] != $userId) {
            return response()->json(['status' => false, 'message' => 'Unauthorized'], 403);
        }

        $messages = $this->db->getReference("broadcasts/$broadcastId/messages")->getValue();

        return response()->json([
            'status' => true,
            'data' => $messages ?: []
        ]);
    }

    // 7. Send Broadcast Message (Saves to history & forwards to recipients' 1-to-1 chats)
    public function sendMessage(Request $request, $broadcastId)
    {
        $senderId = $request->sender_id ?? auth()->id();
        if (!$senderId) {
            return response()->json(['status' => false, 'message' => 'Sender ID is required'], 400);
        }

        $broadcast = $this->db->getReference("broadcasts/$broadcastId")->getValue();
        if (!$broadcast) {
            return response()->json(['status' => false, 'message' => 'Broadcast list not found'], 404);
        }

        if ($broadcast['created_by'] != $senderId) {
            return response()->json(['status' => false, 'message' => 'Unauthorized'], 403);
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
            $fileUrl = url('storage/'.$path);
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
            'lat' => $lat,
            'lng' => $lng,
            'time' => now()->timestamp,
            'status' => 'sent',
            'is_broadcast' => true,
        ];

        // 1. Save to Broadcast history
        $this->db->getReference("broadcasts/$broadcastId/messages")->push($data);
        $this->db->getReference("broadcasts/$broadcastId")->update([
            'last_message' => $request->message ?: ucfirst($type),
            'last_message_time' => $data['time'],
            'updated_at' => now()->timestamp,
        ]);

        // 2. Forward message to each recipient's 1-to-1 chat session
        $recipients = $broadcast['users'] ?? [];
        foreach ($recipients as $recipientId) {
            // Find or create 1-to-1 chat session ID
            $chatId = $this->getOrCreateOneToOneChat($senderId, $recipientId);
            if ($chatId) {
                // Check if blocked by receiver
                $isBlocked = $this->db->getReference("users/{$recipientId}/blocked/{$senderId}")->getValue();
                if (!$isBlocked) {
                    // Push to the 1-to-1 chat
                    $this->db->getReference("chats/$chatId/messages")->push($data);
                    
                    // Update 1-to-1 chat metadata
                    $this->db->getReference("chats/$chatId")->update([
                        'last_message' => $request->message ?: ucfirst($type),
                        'last_message_time' => $data['time'],
                        'updated_at' => now()->timestamp,
                    ]);

                    // Send FCM notification
                    $user = User::find($recipientId);
                    if ($user && $user->fcm_token) {
                        $notifyText = $request->message ?: ucfirst($type);
                        $message = CloudMessage::withTarget('token', $user->fcm_token)
                            ->withNotification(Notification::create('New Message', $notifyText))
                            ->withData(['chat_id' => $chatId]);
                        try {
                            $this->messaging->send($message);
                        } catch (\Exception $e) {
                            Log::error('Broadcast FCM Error for user '.$recipientId.': '.$e->getMessage());
                        }
                    }
                }
            }
        }

        return response()->json([
            'status' => true,
            'message' => 'Broadcast message sent successfully',
            'data' => $data,
        ]);
    }

    private function getOrCreateOneToOneChat($userA, $userB)
    {
        $chatId = 'chat_' . min($userA, $userB) . '_' . max($userA, $userB);
        $chatRef = $this->db->getReference("chats/$chatId");
        $chatData = $chatRef->getValue();

        if (!$chatData) {
            $data = [
                'users' => [ (int)$userA, (int)$userB ],
                'created_at' => now()->timestamp,
                'updated_at' => now()->timestamp,
            ];
            $chatRef->set($data);
        }

        return $chatId;
    }
}
