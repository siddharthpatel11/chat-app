<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class NotificationService
{
    protected $messaging;

    public function __construct(FirebaseService $firebaseService)
    {
        $this->messaging = $firebaseService->messaging();
    }

    /**
     * Send FCM notifications to an array of user IDs.
     *
     * @param array $userIds
     * @param string $title
     * @param string $body
     * @param array $data
     * @return void
     */
    public function sendToUsers(array $userIds, string $title, string $body, array $data = []): void
    {
        if (empty($userIds)) {
            return;
        }

        $receivers = User::whereIn('id', $userIds)
            ->whereNotNull('fcm_token', 'and')
            ->get();

        foreach ($receivers as $user) {
            $message = CloudMessage::withTarget('token', $user->fcm_token)
                ->withNotification(Notification::create($title, $body))
                ->withData($data);

            try {
                $this->messaging->send($message);
            } catch (\Exception $e) {
                Log::error('FCM Send Error for user '.$user->id.': '.$e->getMessage());
            }
        }
    }
    
    /**
     * Get label for notification based on message type
     */
    public function getNotificationTypeLabel(string $type, ?string $text = null, ?string $callName = null): string
    {
        return match($type) {
            'image' => '📷 Image',
            'video' => '🎥 Video',
            'audio' => '🎧 Audio',
            'document' => '📄 Document',
            'location' => '📍 Location',
            'live_location' => '🔴 Live location',
            'scheduled_call' => '📅 Scheduled call: ' . ($callName ?? 'Call'),
            default => $text ?: 'New message',
        };
    }
}
