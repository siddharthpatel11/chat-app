<?php

namespace App\Services;

class PinnedMessageService
{
    protected $db;

    public function __construct(FirebaseService $firebaseService)
    {
        $this->db = $firebaseService->database();
    }

    public function processExpiredPins()
    {
        $currentTime = time();
        $indexRef = $this->db->getReference("pinned_messages_index");

        $allPins = $indexRef->getValue();

        if ($allPins) {
            $expiredPins = array_filter($allPins, function($pin) use ($currentTime) {
                return isset($pin['expires_at']) && $pin['expires_at'] <= $currentTime;
            });

            if (empty($expiredPins)) {
                return;
            }
            foreach ($expiredPins as $key => $data) {
                // Verify if the pin still exists in the chat's pinned_msgs node
                $node = $data['node'] ?? 'chats';
                $chatId = $data['chat_id'] ?? null;
                $messageId = $data['message_id'] ?? null;

                if ($chatId && $messageId) {
                    $pinRef = $this->db->getReference("{$node}/{$chatId}/pinned_msgs/{$messageId}");
                    $pin = $pinRef->getValue();

                    if ($pin) {
                        $pinRef->remove();
                    }
                }

                // Always remove the expired index entry
                $indexRef->getChild($key)->remove();
            }
        }
    }
}
