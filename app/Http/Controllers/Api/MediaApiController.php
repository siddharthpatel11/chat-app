<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\FirebaseService;
use App\Models\User;

class MediaApiController extends Controller
{
    use \App\Traits\ApiResponse;

    protected $db;

    public function __construct(FirebaseService $firebaseService)
    {
        $this->db = $firebaseService->database();
    }

    public function getGlobalMedia(Request $request)
    {
        $userId = auth()->id();

        if (!$userId) {
            return $this->errorResponse('User ID is required', 400);
        }

        try {
            $globalMediaCache = [];
            $urlRegex = '/(https?:\/\/[^\s]+)/i';

            // 1. Fetch personal chats using user_chats index
            $userChatIndex = $this->db->getReference("user_chats/{$userId}")->getValue() ?: [];
            
            foreach ($userChatIndex as $chatId => $v) {
                if ($chatId === '_migrated' || str_starts_with($chatId, 'group_')) {
                    continue;
                }

                $clearedAt = $this->db->getReference("chats/{$chatId}/settings/{$userId}/cleared_at")->getValue();
                $deletedAt = $this->db->getReference("chats/{$chatId}/settings/{$userId}/deleted_at")->getValue();

                $messagesRef = $this->db->getReference("chats/{$chatId}/messages")->getValue() ?? [];
                
                foreach ($messagesRef as $key => $data) {
                    if (isset($data['deleted_for'][$userId])) {
                        continue;
                    }
                    if ($clearedAt && isset($data['time']) && $data['time'] < $clearedAt) {
                        continue;
                    }
                    if ($deletedAt && isset($data['time']) && $data['time'] < $deletedAt) {
                        continue;
                    }
                    $this->processMessageForMedia($data, $key, $chatId, $userId, $globalMediaCache, $urlRegex);
                }
            }

            // 2. Fetch groups
            $groupsRef = $this->db->getReference("groups")->getValue() ?? [];
            foreach ($groupsRef as $groupId => $groupData) {
                $groupUsers = $groupData['users'] ?? [];
                if (in_array((int)$userId, $groupUsers)) {
                    $clearedAt = $this->db->getReference("chats/{$groupId}/settings/{$userId}/cleared_at")->getValue();
                    $deletedAt = $this->db->getReference("chats/{$groupId}/settings/{$userId}/deleted_at")->getValue();

                    $messagesRef = $this->db->getReference("groups/{$groupId}/messages")->getValue() ?? [];
                    
                    foreach ($messagesRef as $key => $data) {
                        if (isset($data['deleted_for'][$userId])) {
                            continue;
                        }
                        if ($clearedAt && isset($data['time']) && $data['time'] < $clearedAt) {
                            continue;
                        }
                        if ($deletedAt && isset($data['time']) && $data['time'] < $deletedAt) {
                            continue;
                        }
                        $this->processMessageForMedia($data, $key, $groupId, $userId, $globalMediaCache, $urlRegex);
                    }
                }
            }

            // 3. Fallback for legacy group formats in chats node (if any)
            $allChats = $this->db->getReference("chats")->getValue() ?? [];
            foreach ($allChats as $chatId => $chatData) {
                if (str_starts_with($chatId, 'group_')) {
                    // Check if we already processed it
                    if (isset($groupsRef[$chatId])) continue;
                    
                    // We don't have user list, so we have to guess if the user sent a message or received one
                    // To be safe, if we find any message from the user, we assume they are in the group
                    $messagesRef = $chatData['messages'] ?? [];
                    $userIsInvolved = false;
                    foreach ($messagesRef as $msg) {
                        if (isset($msg['sender_id']) && $msg['sender_id'] == $userId) {
                            $userIsInvolved = true;
                            break;
                        }
                    }

                    if ($userIsInvolved) {
                        $clearedAt = $this->db->getReference("chats/{$chatId}/settings/{$userId}/cleared_at")->getValue();
                        $deletedAt = $this->db->getReference("chats/{$chatId}/settings/{$userId}/deleted_at")->getValue();

                        foreach ($messagesRef as $key => $data) {
                            if (isset($data['deleted_for'][$userId])) {
                                continue;
                            }
                            if ($clearedAt && isset($data['time']) && $data['time'] < $clearedAt) {
                                continue;
                            }
                            if ($deletedAt && isset($data['time']) && $data['time'] < $deletedAt) {
                                continue;
                            }
                            $this->processMessageForMedia($data, $key, $chatId, $userId, $globalMediaCache, $urlRegex);
                        }
                    }
                }
            }

            // Sort by time descending
            usort($globalMediaCache, function($a, $b) {
                return $b['time'] <=> $a['time'];
            });

            // Apply search filter if provided
            $searchQuery = $request->input('search');
            if (!empty($searchQuery)) {
                $searchQuery = strtolower($searchQuery);
                $globalMediaCache = array_filter($globalMediaCache, function($item) use ($searchQuery) {
                    $fileName = strtolower($item['fileName'] ?? '');
                    $senderName = strtolower($item['senderName'] ?? '');
                    return str_contains($fileName, $searchQuery) || str_contains($senderName, $searchQuery);
                });
                $globalMediaCache = array_values($globalMediaCache);
            }

            // Format grouped response
            $media = [];
            $docs = [];
            $links = [];

            foreach ($globalMediaCache as $item) {
                if ($item['type'] === 'image' || $item['type'] === 'video') {
                    $media[] = $item;
                } elseif ($item['type'] === 'document') {
                    $docs[] = $item;
                } elseif ($item['type'] === 'link') {
                    $links[] = $item;
                }
            }

            return $this->successResponse(['data' => [
                    'media' => $media,
                    'docs' => $docs,
                    'links' => $links,
                    'all' => $globalMediaCache
                ]], 'Success', 200);

        } catch (\Exception $e) {
            return $this->errorResponse('Error fetching media: ' . $e->getMessage(), 500);
        }
    }

    private function processMessageForMedia($data, $key, $chatId, $userId, &$globalMediaCache, $urlRegex)
    {
        $type = $data['type'] ?? 'text';
        $senderId = $data['sender_id'] ?? null;
        
        if (!$senderId) return;

        $sName = 'Someone';
        if ($senderId == $userId) {
            $sName = 'You';
        } else {
            $senderUser = User::find($senderId);
            if ($senderUser) {
                $sName = $senderUser->name ?? $senderUser->phone ?? 'Someone';
            }
        }

        // Check for media
        if ($type !== 'text' && !empty($data['file_url'])) {
            $globalMediaCache[] = [
                'key' => $key,
                'type' => $type,
                'url' => $data['file_url'],
                'senderName' => $sName,
                'time' => $data['time'] ?? 0,
                'chatId' => $chatId,
                'fileName' => $data['file_name'] ?? 'Media',
                'fileSize' => $data['file_size'] ?? ''
            ];
        }

        // Check for links in text
        if ($type === 'text' && !empty($data['text'])) {
            if (preg_match_all($urlRegex, $data['text'], $matches)) {
                foreach ($matches[0] as $idx => $url) {
                    $linkKey = $key . '_link_' . $idx;
                    $globalMediaCache[] = [
                        'key' => $linkKey,
                        'type' => 'link',
                        'url' => $url,
                        'senderName' => $sName,
                        'time' => $data['time'] ?? 0,
                        'chatId' => $chatId,
                        'fileName' => 'Link',
                        'fileSize' => ''
                    ];
                }
            }
        }
    }
    public function deleteMedia(Request $request)
    {
        $userId = auth()->id();
        $messages = $request->input('messages', []); // Expecting array of ['chat_id' => '', 'message_id' => '']

        if (empty($messages) || !is_array($messages)) {
            return $this->errorResponse('No media items provided', 400);
        }

        try {
            foreach ($messages as $msg) {
                if (isset($msg['chat_id']) && isset($msg['message_id'])) {
                    $chatId = $msg['chat_id'];
                    $msgId = $msg['message_id'];
                    
                    if (str_starts_with($chatId, 'group_')) {
                        $this->db->getReference("groups/{$chatId}/messages/{$msgId}")->remove();
                    } else {
                        $this->db->getReference("chats/{$chatId}/messages/{$msgId}")->remove();
                    }
                }
            }
            return $this->successResponse([], 'Media deleted successfully', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Error deleting media: ' . $e->getMessage(), 500);
        }
    }

    public function forwardMedia(Request $request)
    {
        $userId = auth()->id();
        $messages = $request->input('messages', []);
        $targetChatIds = $request->input('target_chat_ids', []);

        if (empty($messages) || empty($targetChatIds)) {
            return $this->errorResponse('Media items and target chats are required', 400);
        }

        try {
            $messagesToForward = [];
            foreach ($messages as $msg) {
                if (isset($msg['chat_id']) && isset($msg['message_id'])) {
                    $chatId = $msg['chat_id'];
                    $msgId = $msg['message_id'];
                    
                    $msgData = null;
                    if (str_starts_with($chatId, 'group_')) {
                        $msgData = $this->db->getReference("groups/{$chatId}/messages/{$msgId}")->getValue();
                    } else {
                        $msgData = $this->db->getReference("chats/{$chatId}/messages/{$msgId}")->getValue();
                    }

                    if ($msgData) {
                        $msgData['sender_id'] = $userId;
                        $msgData['time'] = time();
                        $msgData['status'] = 'sent';
                        $messagesToForward[] = $msgData;
                    }
                }
            }

            foreach ($targetChatIds as $targetChatId) {
                foreach ($messagesToForward as $newMsg) {
                    if (str_starts_with($targetChatId, 'group_')) {
                        $this->db->getReference("groups/{$targetChatId}/messages")->push($newMsg);
                    } else {
                        $this->db->getReference("chats/{$targetChatId}/messages")->push($newMsg);
                    }
                }
            }

            return $this->successResponse([], 'Media forwarded successfully', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Error forwarding media: ' . $e->getMessage(), 500);
        }
    }
}
