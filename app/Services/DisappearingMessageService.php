<?php

namespace App\Services;

class DisappearingMessageService
{
    protected $db;

    public function __construct(FirebaseService $firebaseService)
    {
        $this->db = $firebaseService->database();
    }

    /**
     * Set default message timer for a user.
     * $duration in seconds (0 = Off).
     */
    public function setDefaultTimer($userId, $duration)
    {
        $this->db->getReference("users/{$userId}/settings/default_disappearing_timer")->set((int)$duration);
    }

    public function getDefaultTimer($userId)
    {
        $val = $this->db->getReference("users/{$userId}/settings/default_disappearing_timer")->getValue();
        return $val !== null ? (int)$val : 0;
    }

    public function setChatTimer($chatId, $duration)
    {
        $node = $this->getNodeFromChatId($chatId);
        $firebaseChatId = $this->getFirebaseChatId($chatId);

        $this->applyTimerToPath($node, $firebaseChatId, $duration, $chatId);
    }

    private function applyTimerToPath($node, $firebaseChatId, $duration, $originalChatId)
    {
        // 1. Set the chat timer
        $this->db->getReference("{$node}/{$firebaseChatId}/disappearingTimer")->set((int)$duration);

        // Disappearing messages should only apply to NEW messages, so we do not update existing messages.

        // Send a system message to the chat
        $durationText = 'Off';
        if ($duration === 120) {
            $durationText = '2 minutes';
        } else if ($duration === 86400) {
            $durationText = '24 hours';
        } else if ($duration === 604800) {
            $durationText = '7 days';
        } else if ($duration === 7776000) {
            $durationText = '90 days';
        }

        $userName = auth()->user()->name ?? auth()->user()->phone ?? 'Someone';

        if ($duration > 0) {
            $systemText = "{$userName} updated the disappearing messages timer. New messages will disappear from this chat after {$durationText}.";
        } else {
            $systemText = "{$userName} turned off disappearing messages.";
        }

        $systemMsg = [
            'type' => 'system',
            'text' => $systemText,
            'time' => time(),
            'sender_id' => auth()->id() ?? 'system'
        ];

        $this->db->getReference("{$node}/{$firebaseChatId}/messages")->push($systemMsg);
    }

    public function getChatTimer($chatId)
    {
        $node = $this->getNodeFromChatId($chatId);
        $firebaseChatId = $this->getFirebaseChatId($chatId);
        $val = $this->db->getReference("{$node}/{$firebaseChatId}/disappearingTimer")->getValue();
        return $val !== null ? (int)$val : null;
    }

    public function attachExpirationData($chatId, $userId, &$messageData)
    {
        $duration = $this->getChatTimer($chatId);

        if ($duration === null) {
            $duration = $this->getDefaultTimer($userId);
        }

        if ($duration > 0) {
            $messageData['expires_at'] = microtime(true) + $duration;
            $messageData['is_disappearing'] = true;
            return true;
        }

        return false;
    }

    public function logExpiringMessage($chatId, $messageId, $expiresAt)
    {
        $node = $this->getNodeFromChatId($chatId);
        $firebaseChatId = $this->getFirebaseChatId($chatId);

        $this->logExpiringMessageToPath($node, $firebaseChatId, $messageId, $expiresAt);
    }

    private function logExpiringMessageToPath($node, $firebaseChatId, $messageId, $expiresAt)
    {
        $indexData = [
            'node' => $node,
            'chat_id' => $firebaseChatId,
            'message_id' => $messageId,
            'expires_at' => $expiresAt,
        ];

        $this->db->getReference("disappearing_messages_index")->push($indexData);
    }

    public function processExpiredMessages()
    {
        $currentTime = microtime(true);
        $indexRef = $this->db->getReference("disappearing_messages_index");

        $expiredMessages = $indexRef->orderByChild('expires_at')
                                    ->endAt($currentTime)
                                    ->getValue();

        if ($expiredMessages) {
            foreach ($expiredMessages as $key => $data) {
                // Verify the message still exists and its expiration time hasn't been extended
                $msgRef = $this->db->getReference("{$data['node']}/{$data['chat_id']}/messages/{$data['message_id']}");
                $msg = $msgRef->getValue();

                if ($msg && isset($msg['expires_at']) && $msg['expires_at'] <= $currentTime) {
                    $msgRef->remove();
                }

                // Always remove the expired index entry
                $indexRef->getChild($key)->remove();
            }
        }
    }

    private function getNodeFromChatId($chatId)
    {
        if (str_starts_with($chatId, 'group_')) {
            return 'groups';
        } elseif (str_starts_with($chatId, 'community_')) {
            return 'communities';
        }
        return 'chats';
    }

    private function getFirebaseChatId($chatId)
    {
        $id = $chatId;
        
        // For groups, we only strip 'group_group_' to 'group_', keeping ONE 'group_' prefix
        if (str_starts_with($id, 'group_group_')) {
            return substr($id, 6); // returns group_...
        }
        
        // If it already starts with 'group_', keep it!
        if (str_starts_with($id, 'group_')) {
            return $id;
        }

        // For private chats and communities, just return exactly what we have, e.g., chat_1_2
        return $id;
    }
}
