<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Kreait\Firebase\Factory;

class WebChannelController extends Controller
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

        $userId = auth()->id();
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

    // 2. Follow Channel
    public function followChannel(Request $request, $channelId)
    {
        $userId = auth()->id();
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

    // 3. Unfollow Channel
    public function unfollowChannel(Request $request, $channelId)
    {
        $userId = auth()->id();
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

    // 4. Update Channel
    public function updateChannel(Request $request, $channelId)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string',
        ]);

        $userId = auth()->id();
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
    // 5. Get Users Details (For Followers list)
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
}
