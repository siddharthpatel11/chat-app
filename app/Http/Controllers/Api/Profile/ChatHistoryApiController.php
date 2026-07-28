<?php

namespace App\Http\Controllers\Api\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ChatHistoryApiController extends Controller
{
    use \App\Traits\ApiResponse;

    protected $db;

    public function __construct()
    {
        $firebaseService = app(\App\Services\FirebaseService::class);
        $this->db = $firebaseService->database();
    }

    /**
     * Export Chat
     * Returns chat details and messages for the selected chat
     */
    public function exportChat(Request $request)
    {
        $request->validate([
            'chat_id' => 'required|string'
        ]);

        $userId = auth()->id() ?? $request->user_id;
        $chatId = $request->chat_id;
        $isGroup = str_starts_with($chatId, 'group_');

        $basePath = $isGroup ? "groups/$chatId" : "chats/$chatId";
        
        $chatData = $this->db->getReference($basePath)->getValue();

        if (!$chatData) {
            return $this->errorResponse('Chat not found', 404);
        }

        // Verify user is part of the chat
        $users = $chatData['users'] ?? [];
        if (!in_array($userId, $users)) {
             return $this->errorResponse('You do not have access to this chat', 403);
        }

        $messages = $chatData['messages'] ?? [];
        
        $clearedAt = $chatData['settings'][$userId]['cleared_at'] ?? 0;

        // Exclude deleted messages
        $filteredMessages = [];
        foreach ($messages as $msgId => $msg) {
             // Skip messages older than cleared_at if chat was cleared
             $msgTime = $msg['time'] ?? $msg['timestamp'] ?? 0;
             if ($msgTime >= $clearedAt) {
                 $filteredMessages[$msgId] = $msg;
             }
        }

        return $this->successResponse([
            'success' => true,
            'message' => 'Chat exported successfully',
            'data' => [
                'chat_info' => [
                    'id' => $chatId,
                    'is_group' => $isGroup,
                    'created_at' => $chatData['created_at'] ?? null,
                ],
                'messages' => array_values($filteredMessages)
            ]
        ], 'Success');
    }

    /**
     * Archive All Chats
     */
    public function archiveAllChats(Request $request)
    {
        $userId = auth()->id() ?? $request->user_id;

        // Archive personal chats
        $chats = $this->db->getReference('chats')->getValue() ?? [];
        foreach ($chats as $chatId => $chatData) {
            if (isset($chatData['users']) && in_array($userId, $chatData['users'])) {
                $this->db->getReference("chats/{$chatId}/settings/{$userId}/archived")
                    ->set(true);
            }
        }

        // Archive groups
        $groups = $this->db->getReference('groups')->getValue() ?? [];
        foreach ($groups as $groupId => $groupData) {
            if (isset($groupData['users']) && in_array($userId, $groupData['users'])) {
                $this->db->getReference("groups/{$groupId}/settings/{$userId}/archived")
                    ->set(true);
            }
        }

        return $this->successResponse([
            'success' => true,
            'message' => 'All chats archived successfully'
        ], 'Success');
    }

    /**
     * Clear All Chats
     */
    public function clearAllChats(Request $request)
    {
        $userId = auth()->id() ?? $request->user_id;
        
        $deleteMedia = $request->boolean('delete_media', false);
        $deleteStarred = $request->boolean('delete_starred', false);

        $timestamp = now()->timestamp;

        // Clear personal chats
        $chats = $this->db->getReference('chats')->getValue() ?? [];
        foreach ($chats as $chatId => $chatData) {
            if (isset($chatData['users']) && in_array($userId, $chatData['users'])) {
                $this->db->getReference("chats/{$chatId}/settings/{$userId}/cleared_at")
                    ->set($timestamp);
                    
                if ($deleteMedia) {
                     $this->db->getReference("chats/{$chatId}/settings/{$userId}/media_cleared_at")
                        ->set($timestamp);
                }
                if ($deleteStarred) {
                     $this->db->getReference("chats/{$chatId}/settings/{$userId}/starred_cleared_at")
                        ->set($timestamp);
                }
            }
        }

        // Clear groups
        $groups = $this->db->getReference('groups')->getValue() ?? [];
        foreach ($groups as $groupId => $groupData) {
            if (isset($groupData['users']) && in_array($userId, $groupData['users'])) {
                $this->db->getReference("groups/{$groupId}/settings/{$userId}/cleared_at")
                    ->set($timestamp);
                    
                if ($deleteMedia) {
                     $this->db->getReference("groups/{$groupId}/settings/{$userId}/media_cleared_at")
                        ->set($timestamp);
                }
                if ($deleteStarred) {
                     $this->db->getReference("groups/{$groupId}/settings/{$userId}/starred_cleared_at")
                        ->set($timestamp);
                }
            }
        }

        return $this->successResponse([
            'success' => true,
            'message' => 'All chats cleared successfully'
        ], 'Success');
    }

    /**
     * Delete All Chats
     */
    public function deleteAllChats(Request $request)
    {
        $userId = auth()->id() ?? $request->user_id;
        $exitGroups = $request->boolean('exit_groups', false);
        $timestamp = now()->timestamp;

        // Delete personal chats
        $chats = $this->db->getReference('chats')->getValue() ?? [];
        foreach ($chats as $chatId => $chatData) {
            if (isset($chatData['users']) && in_array($userId, $chatData['users'])) {
                $this->db->getReference("chats/{$chatId}/settings/{$userId}/deleted_at")
                    ->set($timestamp);
            }
        }

        // Handle groups
        $groups = $this->db->getReference('groups')->getValue() ?? [];
        foreach ($groups as $groupId => $groupData) {
            if (isset($groupData['users']) && in_array($userId, $groupData['users'])) {
                
                if ($exitGroups) {
                    // Remove user from group users and admins
                    $currentUsers = $groupData['users'] ?? [];
                    $currentUsers = array_filter($currentUsers, function($uid) use ($userId) {
                        return $uid != $userId;
                    });

                    $admins = $groupData['admins'] ?? [];
                    $admins = array_filter($admins, function($uid) use ($userId) {
                        return $uid != $userId;
                    });

                    $this->db->getReference("groups/{$groupId}")->update([
                        'users' => array_values($currentUsers),
                        'admins' => array_values($admins),
                        'updated_at' => $timestamp
                    ]);
                }
                
                $this->db->getReference("groups/{$groupId}/settings/{$userId}/deleted_at")
                    ->set($timestamp);
            }
        }

        return $this->successResponse([
            'success' => true,
            'message' => 'All chats deleted successfully'
        ], 'Success');
    }
}
