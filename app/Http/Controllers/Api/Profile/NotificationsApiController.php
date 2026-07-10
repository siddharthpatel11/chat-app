<?php

namespace App\Http\Controllers\Api\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class NotificationsApiController extends Controller
{
    use \App\Traits\ApiResponse;

    /**
     * Get Notifications Settings
     */
    public function getSettings(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $userId = auth()->id();
        $settings = Cache::get("settings_notifications_{$userId}", [
            'user_id' => (int) $userId,
            'conversation_tones' => true,
            'high_priority_notifications' => true,
            'reaction_notifications' => true,
            'group_notifications' => true,
            'ringtone' => 'default',
        ]);

        return $this->successResponse(['success' => true,
            'message' => 'Notification settings retrieved successfully.',
            'data' => $settings], 'Success', 200);
    }

    /**
     * Update Notifications Settings
     */
    public function updateSettings(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'conversation_tones' => 'nullable|boolean',
            'high_priority_notifications' => 'nullable|boolean',
            'reaction_notifications' => 'nullable|boolean',
            'group_notifications' => 'nullable|boolean',
            'ringtone' => 'nullable|string',
        ]);

        $userId = $validatedData['user_id'];
        $settings = Cache::get("settings_notifications_{$userId}", [
            'user_id' => (int) $userId,
            'conversation_tones' => true,
            'high_priority_notifications' => true,
            'reaction_notifications' => true,
            'group_notifications' => true,
            'ringtone' => 'default',
        ]);

        foreach ($validatedData as $key => $value) {
            if ($value !== null) {
                $settings[$key] = $value;
            }
        }

        Cache::put("settings_notifications_{$userId}", $settings);

        return $this->successResponse(['success' => true,
            'message' => 'Notification settings updated successfully.',
            'data' => $settings], 'Success', 200);
    }
}
