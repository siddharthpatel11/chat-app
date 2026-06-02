<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Kreait\Firebase\Factory;

class GroupApiController extends Controller
{
    protected $db;

    public function __construct()
    {
        $factory = (new Factory)
            ->withServiceAccount(storage_path('app/firebase.json'))
            ->withDatabaseUri(env('FIREBASE_DATABASE_URL'));

        $this->db = $factory->createDatabase();
    }

    // 1. Create Group
    public function createGroup(Request $request)
    {
        if (is_string($request->users)) {
            $request->merge(['users' => json_decode($request->users, true)]);
        }

        $request->validate([
            'name' => 'required|string',
            'users' => 'required|array', // array of user IDs
        ]);

        $userId = auth()->id() ?? $request->user_id;
        if (!$userId) {
            return response()->json(['status' => false, 'message' => 'User ID is required'], 400);
        }
        
        $users = $request->users;

        // Ensure creator is in the group
        if (!in_array($userId, $users)) {
            $users[] = $userId;
        }

        $avatarUrl = null;
        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('groups', 'public');
            $avatarUrl = url('storage/' . $path);
        }

        $groupId = 'group_' . time() . '_' . uniqid();

        $data = [
            'id' => $groupId,
            'isGroup' => true,
            'is_group' => true, // backward compatibility for API methods
            'name' => $request->name,
            'avatar' => $avatarUrl,
            'users' => array_values(array_unique($users)),
            'admins' => [$userId],
            'createdBy' => $userId,
            'created_by' => $userId,
            'createdAt' => now()->timestamp,
            'created_at' => now()->timestamp,
            'updated_at' => now()->timestamp,
            'last_message' => 'Group created',
            'last_message_time' => now()->timestamp,
            'disappearingTimer' => 0,
            'permissions' => [
                'send_messages' => 'all',
                'edit_group_info' => 'admins'
            ]
        ];

        $this->db->getReference("groups/$groupId")->set($data);

        $initialMsg = [
            'text' => "Group created",
            'sender_id' => $userId,
            'time' => now()->timestamp,
            'type' => 'text',
            'status' => 'read'
        ];
        $this->db->getReference("groups/$groupId/messages")->push($initialMsg);

        return response()->json([
            'status' => true,
            'group_id' => $groupId,
            'message' => 'Group created successfully',
            'data' => $data
        ]);
    }

    // 2. Add Members
    public function addMembers(Request $request, $groupId)
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
        $groupRef = $this->db->getReference("groups/$groupId");
        $group = $groupRef->getValue();

        if (!$group || !isset($group['is_group'])) {
            return response()->json(['status' => false, 'message' => 'Group not found'], 404);
        }

        if (!in_array($userId, $group['admins'] ?? [])) {
            return response()->json(['status' => false, 'message' => 'Only admins can add members'], 403);
        }

        $currentUsers = $group['users'] ?? [];
        $newUsers = array_merge($currentUsers, $request->users);
        $newUsers = array_values(array_unique($newUsers));

        $groupRef->update(['users' => $newUsers, 'updated_at' => now()->timestamp]);

        return response()->json(['status' => true, 'message' => 'Members added successfully']);
    }

    // 3. Remove Member
    public function removeMember(Request $request, $groupId)
    {
        $request->validate([
            'remove_user_id' => 'required'
        ]);

        $userId = auth()->id() ?? $request->user_id;
        if (!$userId) {
            return response()->json(['status' => false, 'message' => 'User ID is required'], 400);
        }
        $removeUserId = $request->remove_user_id;

        $groupRef = $this->db->getReference("groups/$groupId");
        $group = $groupRef->getValue();

        if (!$group || !isset($group['is_group'])) {
            return response()->json(['status' => false, 'message' => 'Group not found'], 404);
        }

        if (!in_array($userId, $group['admins'] ?? [])) {
            return response()->json(['status' => false, 'message' => 'Only admins can remove members'], 403);
        }

        $currentUsers = $group['users'] ?? [];
        $currentUsers = array_filter($currentUsers, function($uid) use ($removeUserId) {
            return $uid != $removeUserId;
        });

        // Also remove from admins if they were admin
        $admins = $group['admins'] ?? [];
        $admins = array_filter($admins, function($uid) use ($removeUserId) {
            return $uid != $removeUserId;
        });

        $groupRef->update([
            'users' => array_values($currentUsers),
            'admins' => array_values($admins),
            'updated_at' => now()->timestamp
        ]);

        return response()->json(['status' => true, 'message' => 'Member removed']);
    }

    // 4. Make Admin
    public function makeAdmin(Request $request, $groupId)
    {
        $request->validate([
            'admin_user_id' => 'required'
        ]);

        $userId = auth()->id() ?? $request->user_id;
        if (!$userId) {
            return response()->json(['status' => false, 'message' => 'User ID is required'], 400);
        }
        $newAdminId = $request->admin_user_id;

        $groupRef = $this->db->getReference("groups/$groupId");
        $group = $groupRef->getValue();

        if (!$group || !isset($group['is_group'])) {
            return response()->json(['status' => false, 'message' => 'Group not found'], 404);
        }

        if (!in_array($userId, $group['admins'] ?? [])) {
            return response()->json(['status' => false, 'message' => 'Only admins can make other admins'], 403);
        }

        $admins = $group['admins'] ?? [];
        if (!in_array($newAdminId, $admins)) {
            $admins[] = $newAdminId;
            $groupRef->update(['admins' => array_values($admins)]);
        }

        return response()->json(['status' => true, 'message' => 'User is now an admin']);
    }

    // 5. Leave Group
    public function leaveGroup(Request $request, $groupId)
    {
        $userId = auth()->id() ?? $request->user_id;
        if (!$userId) {
            return response()->json(['status' => false, 'message' => 'User ID is required'], 400);
        }

        $groupRef = $this->db->getReference("groups/$groupId");
        $group = $groupRef->getValue();

        if (!$group || !isset($group['is_group'])) {
            return response()->json(['status' => false, 'message' => 'Group not found'], 404);
        }

        $currentUsers = $group['users'] ?? [];
        $currentUsers = array_filter($currentUsers, function($uid) use ($userId) {
            return $uid != $userId;
        });

        $admins = $group['admins'] ?? [];
        $admins = array_filter($admins, function($uid) use ($userId) {
            return $uid != $userId;
        });

        $groupRef->update([
            'users' => array_values($currentUsers),
            'admins' => array_values($admins),
            'updated_at' => now()->timestamp
        ]);

        return response()->json(['status' => true, 'message' => 'You left the group']);
    }

    // 6. Group Info
    public function groupInfo(Request $request, $groupId)
    {
        $group = $this->db->getReference("groups/$groupId")->getValue();

        if (!$group || !isset($group['is_group'])) {
            return response()->json(['status' => false, 'message' => 'Group not found'], 404);
        }

        // Fetch users details
        $userIds = $group['users'] ?? [];
        $users = \App\Models\User::whereIn('id', $userIds)->get(['id', 'name', 'avatar', 'phone']);

        $group['members'] = $users;

        return response()->json([
            'status' => true,
            'data' => $group
        ]);
    }
    // 7. Send Group Message
    public function sendMessage(Request $request, $groupId)
    {
        $senderId = $request->sender_id ?? auth()->id();
        if (!$senderId) {
            return response()->json(['status' => false, 'message' => 'Sender ID is required'], 400);
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

        $groupData = $this->db->getReference("groups/$groupId")->getValue();

        if (!$groupData || !isset($groupData['is_group'])) {
            return response()->json(['status' => false, 'message' => 'Group not found'], 404);
        }

        if (!in_array($senderId, $groupData['users'] ?? [])) {
            return response()->json(['status' => false, 'message' => 'You are not a member of this group'], 403);
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
        $this->db->getReference("groups/$groupId/messages")->push($data);

        // Update chat metadata with last message info
        $this->db->getReference("groups/$groupId")->update([
            'last_message' => $request->message ?: ucfirst($type),
            'last_message_time' => $data['time'],
            'updated_at' => now()->timestamp,
        ]);

        $notifyText = $request->message;
        if ($type == 'image') $notifyText = '📷 Image';
        if ($type == 'video') $notifyText = '🎥 Video';
        if ($type == 'audio') $notifyText = '🎧 Audio';
        if ($type == 'document') $notifyText = '📄 Document';
        if ($type == 'location') $notifyText = '📍 Location';
        if ($type == 'live_location') $notifyText = '🔴 Live location';

        $receiversList = array_filter($groupData['users'] ?? [], function($uid) use ($senderId) {
            return $uid != $senderId;
        });

        if (!empty($receiversList)) {
            $receivers = \App\Models\User::whereIn('id', $receiversList)
                ->whereNotNull('fcm_token')
                ->get();

            $messaging = (new Factory)
                ->withServiceAccount(storage_path('app/firebase.json'))
                ->createMessaging();

            $groupName = $groupData['name'] ?? 'Group';

            foreach ($receivers as $user) {
                $message = \Kreait\Firebase\Messaging\CloudMessage::withTarget('token', $user->fcm_token)
                    ->withNotification(\Kreait\Firebase\Messaging\Notification::create($groupName, $notifyText))
                    ->withData(['chat_id' => $groupId, 'is_group' => 'true']);

                try {
                    $messaging->send($message);
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error('Group FCM Send Error: '.$e->getMessage());
                }
            }
        }

        return response()->json([
            'status' => true,
            'message' => 'Group message sent',
            'data' => $data,
        ]);
    }

    // 8. Initiate Group Call
    public function initiateCall(Request $request, $groupId)
    {
        $request->validate([
            'caller_id' => 'required',
            'call_type' => 'required|in:voice,video',
        ]);

        $groupData = $this->db->getReference("groups/$groupId")->getValue();

        if (!$groupData || !isset($groupData['is_group'])) {
            return response()->json(['status' => false, 'message' => 'Group not found'], 404);
        }

        $callerId = $request->caller_id;

        if (!in_array($callerId, $groupData['users'] ?? [])) {
            return response()->json(['status' => false, 'message' => 'You are not a member of this group'], 403);
        }

        $callId = 'call_'.time().'_'.uniqid();
        $caller = \App\Models\User::find($callerId);

        $data = [
            'caller_id' => $callerId,
            'call_type' => $request->call_type,
            'is_group' => true,
            'chat_id' => $groupId,
            'status' => 'calling',
            'time' => now()->timestamp,
        ];

        // Save call info in Firebase
        $this->db->getReference("calls/$callId")->set($data);

        $receiversList = array_filter($groupData['users'] ?? [], function($uid) use ($callerId) {
            return $uid != $callerId;
        });

        if (!empty($receiversList)) {
            $receivers = \App\Models\User::whereIn('id', $receiversList)->whereNotNull('fcm_token')->get();
            $messaging = (new Factory)
                ->withServiceAccount(storage_path('app/firebase.json'))
                ->createMessaging();

            $groupName = $groupData['name'] ?? 'Group';

            foreach ($receivers as $receiver) {
                $title = 'Incoming Group '.ucfirst($request->call_type).' Call';
                $body = ($caller ? $caller->name : 'Someone').' is calling the group '.$groupName;

                $message = \Kreait\Firebase\Messaging\CloudMessage::withTarget('token', $receiver->fcm_token)
                    ->withNotification(\Kreait\Firebase\Messaging\Notification::create($title, $body))
                    ->withData([
                        'type' => 'call',
                        'call_id' => $callId,
                        'caller_id' => $callerId,
                        'call_type' => $request->call_type,
                        'is_group' => 'true',
                        'chat_id' => $groupId
                    ]);

                try {
                    $messaging->send($message);
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error('Group Call FCM Error: '.$e->getMessage());
                }
            }
        }

        return response()->json([
            'status' => true,
            'message' => 'Group Call initiated',
            'call_id' => $callId,
        ]);
    }

    // 9. Get Group Messages
    public function getMessages(Request $request, $groupId)
    {
        $userId = auth()->id() ?? $request->user_id;
        if (!$userId) {
            return response()->json(['status' => false, 'message' => 'User ID is required'], 400);
        }

        $groupData = $this->db->getReference("groups/$groupId")->getValue();

        if (!$groupData || !isset($groupData['is_group'])) {
            return response()->json(['status' => false, 'message' => 'Group not found'], 404);
        }

        if (!in_array($userId, $groupData['users'] ?? [])) {
            return response()->json(['status' => false, 'message' => 'You are not a member of this group'], 403);
        }

        $messages = $this->db->getReference("groups/$groupId/messages")->getValue();

        // Optionally, handle "cleared_at" logic for groups if you want users to be able to clear group chat history for themselves
        $clearedAt = $this->db->getReference("groups/$groupId/settings/$userId/cleared_at")->getValue();

        if ($messages && $clearedAt) {
            $filteredMessages = [];
            foreach ($messages as $msgId => $msg) {
                if (isset($msg['time']) && $msg['time'] >= $clearedAt) {
                    $filteredMessages[$msgId] = $msg;
                }
            }
            $messages = $filteredMessages;
        }

        return response()->json([
            'status' => true,
            'data' => $messages ?: []
        ]);
    }
}
