<?php

namespace App\Http\Controllers\Api\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ChatsApiController extends Controller
{
    use \App\Traits\ApiResponse;

    /**
     * Get Chat Settings
     */
    public function getSettings(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $userId = auth()->id();
        $settings = Cache::get("settings_chats_{$userId}", [
            'user_id' => (int) $userId,
            'theme' => 'system', // light, dark, system
            'wallpaper' => 'default',
            'enter_is_send' => true,
            'media_visibility' => true,
            'font_size' => 'medium', // small, medium, large
        ]);

        return $this->successResponse(['success' => true,
            'message' => 'Chat settings retrieved successfully.',
            'data' => $settings], 'Success', 200);
    }

    /**
     * Update Chat Settings
     */
    public function updateSettings(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'theme' => 'nullable|string|in:light,dark,system',
            'wallpaper' => 'nullable|string',
            'enter_is_send' => 'nullable|boolean',
            'media_visibility' => 'nullable|boolean',
            'font_size' => 'nullable|string|in:small,medium,large',
        ]);

        $userId = $validatedData['user_id'];
        $settings = Cache::get("settings_chats_{$userId}", [
            'user_id' => (int) $userId,
            'theme' => 'system', // light, dark, system
            'wallpaper' => 'default',
            'enter_is_send' => true,
            'media_visibility' => true,
            'font_size' => 'medium', // small, medium, large
        ]);

        foreach ($validatedData as $key => $value) {
            if ($value !== null) {
                $settings[$key] = $value;
            }
        }

        Cache::put("settings_chats_{$userId}", $settings);

        return $this->successResponse(['success' => true,
            'message' => 'Chat settings updated successfully.',
            'data' => $settings], 'Success', 200);
    }
}
