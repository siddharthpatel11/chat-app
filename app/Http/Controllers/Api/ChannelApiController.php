<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Kreait\Firebase\Factory;

class ChannelApiController extends Controller
{
    protected $db;

    public function __construct()
    {
        $factory = (new Factory)
            ->withServiceAccount(storage_path('app/firebase.json'))
            ->withDatabaseUri(env('FIREBASE_DATABASE_URL'));

        $this->db = $factory->createDatabase();
    }

    // 1. Upload Channel Avatar (To bypass CORS on Firebase Storage)
    public function uploadAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image'
        ]);

        $path = $request->file('avatar')->store('channels', 'public');
        return response()->json([
            'status' => true,
            'url' => url('storage/'.$path)
        ]);
    }

    // 1b. Upload Channel Message Media (To bypass CORS on Firebase Storage)
    public function uploadMessageMedia(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:51200' // 50MB max
        ]);

        $path = $request->file('file')->store('channels/media', 'public');
        return response()->json([
            'status' => true,
            'url' => url('storage/'.$path)
        ]);
    }

    // 2. Create Channel
    public function createChannel(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string',
        ]);

        $userId = auth()->id() ?? $request->user_id;
        if (! $userId) {
            return response()->json(['status' => false, 'message' => 'User ID is required'], 400);
        }

        $avatarUrl = null;
        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('channels', 'public');
            $avatarUrl = url('storage/'.$path);
        }

        $channelId = 'channel_'.time().'_'.uniqid();

        $channelData = [
            'id' => $channelId,
            'name' => $request->name,
            'description' => $request->description ?? '',
            'avatar' => $avatarUrl,
            'created_by' => $userId,
            'created_at' => now()->timestamp,
            'updated_at' => now()->timestamp,
            'followers_count' => 0,
            'admins' => [$userId => true],
            'is_channel' => true,
        ];

        // Write channel to Realtime DB
        $this->db->getReference("channels/$channelId")->set($channelData);

        // Push initial message (Channel creation)
        $this->db->getReference("channels/$channelId/messages")->push([
            'text' => 'Channel created',
            'sender_id' => $userId,
            'time' => now()->timestamp,
            'type' => 'system',
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Channel created successfully',
            'channel_id' => $channelId,
            'data' => $channelData,
        ]);
    }

    // 3. Follow Channel
    public function followChannel(Request $request, $channelId)
    {
        $userId = auth()->id() ?? $request->user_id;
        if (! $userId) {
            return response()->json(['status' => false, 'message' => 'User ID is required'], 400);
        }

        $channelRef = $this->db->getReference("channels/$channelId");
        $channel = $channelRef->getValue();

        if (! $channel) {
            return response()->json(['status' => false, 'message' => 'Channel not found'], 404);
        }

        $followers = $channel['followers'] ?? [];
        if (isset($followers[$userId])) {
            return response()->json(['status' => false, 'message' => 'Already following'], 400);
        }

        $followers[$userId] = true;
        $followersCount = isset($channel['followers_count']) ? $channel['followers_count'] + 1 : count($followers);

        $channelRef->update([
            'followers' => $followers,
            'followers_count' => $followersCount,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Successfully followed the channel',
            'followers_count' => $followersCount,
        ]);
    }

    // 4. Unfollow Channel
    public function unfollowChannel(Request $request, $channelId)
    {
        $userId = auth()->id() ?? $request->user_id;
        if (! $userId) {
            return response()->json(['status' => false, 'message' => 'User ID is required'], 400);
        }

        $channelRef = $this->db->getReference("channels/$channelId");
        $channel = $channelRef->getValue();

        if (! $channel) {
            return response()->json(['status' => false, 'message' => 'Channel not found'], 404);
        }

        $followers = $channel['followers'] ?? [];
        if (!isset($followers[$userId])) {
            return response()->json(['status' => false, 'message' => 'Not following'], 400);
        }

        // Remove follower
        $this->db->getReference("channels/$channelId/followers/$userId")->remove();
        
        $followersCount = isset($channel['followers_count']) ? max(0, $channel['followers_count'] - 1) : max(0, count($followers) - 1);

        $channelRef->update([
            'followers_count' => $followersCount,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Successfully unfollowed the channel',
            'followers_count' => $followersCount,
        ]);
    }

    // 5. Update Channel
    public function updateChannel(Request $request, $channelId)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string',
        ]);

        $userId = auth()->id() ?? $request->user_id;
        if (! $userId) {
            return response()->json(['status' => false, 'message' => 'User ID is required'], 400);
        }

        $channelRef = $this->db->getReference("channels/$channelId");
        $channel = $channelRef->getValue();

        if (! $channel) {
            return response()->json(['status' => false, 'message' => 'Channel not found'], 404);
        }

        $admins = $channel['admins'] ?? [];
        if (!isset($admins[$userId])) {
            return response()->json(['status' => false, 'message' => 'Only admins can update the channel'], 403);
        }

        $updateData = [
            'name' => $request->name,
            'description' => $request->description ?? '',
            'updated_at' => now()->timestamp,
        ];

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('channels', 'public');
            $updateData['avatar'] = url('storage/'.$path);
        }

        $channelRef->update($updateData);

        return response()->json([
            'status' => true,
            'message' => 'Channel updated successfully',
            'data' => $updateData,
        ]);
    }
    
    // 7. Invite Admins
    public function inviteAdmins(Request $request, $channelId)
    {
        $request->validate([
            'users' => 'required|array', // array of user IDs
        ]);

        $userId = auth()->id() ?? $request->user_id;
        if (! $userId) return response()->json(['status' => false, 'message' => 'User ID is required'], 400);

        $channelRef = $this->db->getReference("channels/$channelId");
        $channel = $channelRef->getValue();

        if (! $channel) return response()->json(['status' => false, 'message' => 'Channel not found'], 404);

        if (!isset($channel['admins'][$userId])) {
            return response()->json(['status' => false, 'message' => 'Only admins can invite other admins'], 403);
        }

        $pendingAdmins = $channel['pending_admins'] ?? [];
        foreach ($request->users as $uid) {
            if (!isset($channel['admins'][$uid])) {
                $pendingAdmins[$uid] = true;
            }
        }

        $channelRef->update(['pending_admins' => $pendingAdmins]);
        return response()->json(['status' => true, 'message' => 'Admins invited successfully']);
    }

    // 8. Accept Admin Invite
    public function acceptAdminInvite(Request $request, $channelId)
    {
        $userId = auth()->id() ?? $request->user_id;
        if (! $userId) return response()->json(['status' => false, 'message' => 'User ID is required'], 400);

        $channelRef = $this->db->getReference("channels/$channelId");
        $channel = $channelRef->getValue();

        if (! $channel) return response()->json(['status' => false, 'message' => 'Channel not found'], 404);

        if (!isset($channel['pending_admins'][$userId])) {
            return response()->json(['status' => false, 'message' => 'No pending invite found'], 404);
        }

        $this->db->getReference("channels/$channelId/pending_admins/$userId")->remove();
        
        $admins = $channel['admins'] ?? [];
        $admins[$userId] = true;
        
        $followers = $channel['followers'] ?? [];
        if (!isset($followers[$userId])) {
            $followers[$userId] = true;
            $channelRef->update(['followers_count' => count($followers)]);
        }

        $channelRef->update([
            'admins' => $admins,
            'followers' => $followers
        ]);

        return response()->json(['status' => true, 'message' => 'Admin invite accepted']);
    }

    // 9. Dismiss Admin (Only Owner)
    public function dismissAdmin(Request $request, $channelId)
    {
        $request->validate(['admin_user_id' => 'required']);
        $dismissUserId = $request->admin_user_id;
        
        $userId = auth()->id() ?? $request->user_id;
        if (! $userId) return response()->json(['status' => false, 'message' => 'User ID is required'], 400);

        $channelRef = $this->db->getReference("channels/$channelId");
        $channel = $channelRef->getValue();

        if (! $channel) return response()->json(['status' => false, 'message' => 'Channel not found'], 404);

        if ($channel['created_by'] != $userId) {
            return response()->json(['status' => false, 'message' => 'Only the owner can dismiss admins'], 403);
        }

        $this->db->getReference("channels/$channelId/admins/$dismissUserId")->remove();
        return response()->json(['status' => true, 'message' => 'Admin dismissed']);
    }

    // 10. Dismiss Self Admin
    public function dismissSelfAdmin(Request $request, $channelId)
    {
        $userId = auth()->id() ?? $request->user_id;
        if (! $userId) return response()->json(['status' => false, 'message' => 'User ID is required'], 400);

        $channelRef = $this->db->getReference("channels/$channelId");
        $channel = $channelRef->getValue();

        if (! $channel) return response()->json(['status' => false, 'message' => 'Channel not found'], 404);
        
        if ($channel['created_by'] == $userId) {
            return response()->json(['status' => false, 'message' => 'Owner cannot dismiss themselves'], 400);
        }

        $this->db->getReference("channels/$channelId/admins/$userId")->remove();
        return response()->json(['status' => true, 'message' => 'Dismissed self from admin']);
    }

    // 11. Delete Channel
    public function deleteChannel(Request $request, $channelId)
    {
        $userId = auth()->id() ?? $request->user_id;
        if (! $userId) return response()->json(['status' => false, 'message' => 'User ID is required'], 400);

        $channelRef = $this->db->getReference("channels/$channelId");
        $channel = $channelRef->getValue();

        if (! $channel) return response()->json(['status' => false, 'message' => 'Channel not found'], 404);

        if ($channel['created_by'] != $userId) {
            return response()->json(['status' => false, 'message' => 'Only the owner can delete the channel'], 403);
        }

        $channelRef->remove();
        return response()->json(['status' => true, 'message' => 'Channel deleted successfully']);
    }

    // 12. Remove Follower
    public function removeFollower(Request $request, $channelId)
    {
        $request->validate(['follower_user_id' => 'required']);
        $followerId = $request->follower_user_id;

        $userId = auth()->id() ?? $request->user_id;
        if (! $userId) return response()->json(['status' => false, 'message' => 'User ID is required'], 400);

        $channelRef = $this->db->getReference("channels/$channelId");
        $channel = $channelRef->getValue();

        if (! $channel) return response()->json(['status' => false, 'message' => 'Channel not found'], 404);

        if (!isset($channel['admins'][$userId])) {
            return response()->json(['status' => false, 'message' => 'Only admins can remove followers'], 403);
        }
        
        if ($channel['created_by'] == $followerId) {
             return response()->json(['status' => false, 'message' => 'Cannot remove the owner'], 400);
        }

        $this->db->getReference("channels/$channelId/followers/$followerId")->remove();
        $this->db->getReference("channels/$channelId/admins/$followerId")->remove();
        
        $followers = $channel['followers'] ?? [];
        $followersCount = max(0, count($followers) - 1);
        if (isset($channel['followers_count'])) {
            $followersCount = max(0, $channel['followers_count'] - 1);
        }
        
        $channelRef->update(['followers_count' => $followersCount]);

        return response()->json(['status' => true, 'message' => 'Follower removed']);
    }

    // 13. Search Messages
    public function searchMessages(Request $request, $channelId)
    {
        $query = strtolower($request->input('query', ''));
        if (!$query) return response()->json([]);

        $messages = $this->db->getReference("channels/$channelId/messages")->getValue();
        if (!$messages) return response()->json([]);

        $results = [];
        foreach ($messages as $id => $msg) {
            if (isset($msg['text']) && str_contains(strtolower($msg['text']), $query)) {
                $msg['id'] = $id;
                $results[] = $msg;
            }
        }
        return response()->json(array_values($results));
    }

    // 14. Get Messages
    public function getMessages(Request $request, $channelId)
    {
        $messages = $this->db->getReference("channels/$channelId/messages")->getValue();
        if (!$messages) return response()->json([]);

        $formatted = [];
        foreach ($messages as $id => $msg) {
            $msg['id'] = $id;
            $formatted[] = $msg;
        }
        return response()->json($formatted);
    }

    // 15. Send Message
    public function sendMessage(Request $request, $channelId)
    {
        $request->validate([
            'text' => 'nullable|string',
            'type' => 'nullable|string',
            'fileUrl' => 'nullable|string',
            'fileName' => 'nullable|string',
            'fileSize' => 'nullable|string',
        ]);

        $userId = auth()->id() ?? $request->user_id;
        if (! $userId) return response()->json(['status' => false, 'message' => 'User ID is required'], 400);

        $channelRef = $this->db->getReference("channels/$channelId");
        $channel = $channelRef->getValue();

        if (! $channel) return response()->json(['status' => false, 'message' => 'Channel not found'], 404);

        if (!isset($channel['admins'][$userId])) {
            return response()->json(['status' => false, 'message' => 'Only admins can send messages'], 403);
        }

        $msgData = [
            'sender_id' => $userId,
            'time' => now()->timestamp,
            'type' => $request->type ?? 'text',
            'text' => $request->text ?? '',
        ];

        if ($request->fileUrl) {
            $msgData['fileUrl'] = $request->fileUrl;
            $msgData['fileName'] = $request->fileName ?? '';
            $msgData['fileSize'] = $request->fileSize ?? '';
        }

        $this->db->getReference("channels/$channelId/messages")->push($msgData);
        
        $lastMsgText = 'Update';
        if ($request->type === 'image') $lastMsgText = '📸 Photo';
        elseif ($request->type === 'video') $lastMsgText = '🎥 Video';
        elseif ($request->type === 'audio') $lastMsgText = '🎵 Audio';
        elseif ($request->type === 'document') $lastMsgText = '📄 Document';
        
        if ($request->text) $lastMsgText = substr($request->text, 0, 50);

        $channelRef->update(['last_message' => $lastMsgText]);

        return response()->json(['status' => true, 'message' => 'Message sent successfully']);
    }

    // 16. Get Users Details (For Followers list)
    public function getUsersDetails(Request $request)
    {
        if ($request->input('all')) {
            $users = User::get(['id', 'name', 'avatar', 'about', 'phone']);
            return response()->json($users);
        }

        $ids = $request->input('ids'); // array or comma-separated string
        if(is_string($ids)) {
            $ids = explode(',', $ids);
        }
        
        if(!$ids || !is_array($ids)) {
            return response()->json([]);
        }

        $users = User::whereIn('id', $ids)->get(['id', 'name', 'avatar', 'about', 'phone']);
        return response()->json($users);
    }

    // 17. Toggle Mute
    public function toggleMute(Request $request, $channelId)
    {
        $request->validate([
            'type' => 'required|in:follower,admin',
            'is_muted' => 'required|boolean'
        ]);

        $userId = auth()->id() ?? $request->user_id;
        if (! $userId) return response()->json(['status' => false, 'message' => 'User ID is required'], 400);

        $type = $request->type;
        $isMuted = $request->is_muted;
        
        $key = "mute_$type";
        $this->db->getReference("users/$userId/channel_settings/$channelId")->update([
            $key => $isMuted
        ]);

        return response()->json(['status' => true, 'message' => 'Mute settings updated']);
    }

    // 18. Report Channel
    public function reportChannel(Request $request, $channelId)
    {
        $userId = auth()->id() ?? $request->user_id;
        if (! $userId) return response()->json(['status' => false, 'message' => 'User ID is required'], 400);
        
        $reason = $request->input('reason', 'spam');

        $this->db->getReference("channel_reports/$channelId/$userId")->set([
            'time' => now()->timestamp,
            'reason' => $reason
        ]);

        return response()->json(['status' => true, 'message' => 'Channel reported successfully']);
    }

    public function reactMessage(Request $request, $channelId)
    {
        $request->validate([
            'message_id' => 'required|string',
            'emoji' => 'required|string',
        ]);

        $userId = auth()->id() ?? $request->user_id;

        if (!$userId) {
            return response()->json(['status' => false, 'message' => 'User ID is required'], 400);
        }

        $messageId = $request->message_id;
        $emoji = $request->emoji;

        try {
            $messageRef = $this->db->getReference("channels/$channelId/messages/$messageId");
            $message = $messageRef->getValue();

            if (!$message) {
                return response()->json(['status' => false, 'message' => 'Message not found'], 404);
            }

            $reactionsPath = "channels/$channelId/messages/$messageId/reactions/$userId";
            
            $currentReaction = $this->db->getReference($reactionsPath)->getValue();
            if ($currentReaction === $emoji) {
                $this->db->getReference($reactionsPath)->remove();
                return response()->json(['status' => true, 'message' => 'Reaction removed']);
            } else {
                $this->db->getReference($reactionsPath)->set($emoji);
                return response()->json(['status' => true, 'message' => 'Reaction added']);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    public function deleteMessage(Request $request, $channelId)
    {
        $request->validate([
            'message_id' => 'required|string',
        ]);

        $userId = auth()->id() ?? $request->user_id;

        if (!$userId) {
            return response()->json(['status' => false, 'message' => 'User ID is required'], 400);
        }

        $messageId = $request->message_id;

        try {
            $channelData = $this->db->getReference("channels/$channelId")->getValue();
            if (!$channelData || !isset($channelData['admins'][$userId])) {
                return response()->json(['status' => false, 'message' => 'Unauthorized: Only admins can delete channel messages'], 403);
            }

            $messageRef = $this->db->getReference("channels/$channelId/messages/$messageId");
            if (!$messageRef->getValue()) {
                return response()->json(['status' => false, 'message' => 'Message not found'], 404);
            }

            $messageRef->remove();

            return response()->json(['status' => true, 'message' => 'Message deleted']);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    public function deleteMessages(Request $request, $channelId)
    {
        $request->validate([
            'message_ids' => 'required|array',
            'message_ids.*' => 'string',
        ]);

        $userId = auth()->id() ?? $request->user_id;

        if (!$userId) {
            return response()->json(['status' => false, 'message' => 'User ID is required'], 400);
        }

        $messageIds = $request->message_ids;

        try {
            $channelData = $this->db->getReference("channels/$channelId")->getValue();
            if (!$channelData || !isset($channelData['admins'][$userId])) {
                return response()->json(['status' => false, 'message' => 'Unauthorized: Only admins can delete channel messages'], 403);
            }

            $updates = [];
            foreach ($messageIds as $msgId) {
                $updates["channels/$channelId/messages/$msgId"] = null;
            }

            $this->db->getReference('/')->update($updates);

            return response()->json(['status' => true, 'message' => 'Messages deleted']);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
        }
    }
}
