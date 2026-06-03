<?php

namespace App\Http\Controllers\Api\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class KeyboardShortcutsApiController extends Controller
{
    /**
     * Get Keyboard Shortcuts Settings
     */
    public function getSettings(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $userId = $request->user_id;
        $settings = Cache::get("settings_keyboard_shortcuts_{$userId}", [
            'user_id' => (int) $userId,
            'enabled' => true,
            'mute_notifications_shortcut' => 'Ctrl+Alt+M',
            'archive_chat_shortcut' => 'Ctrl+Alt+A',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Keyboard shortcuts settings retrieved successfully.',
            'data' => $settings
        ]);
    }

    /**
     * Update Keyboard Shortcuts Settings
     */
    public function updateSettings(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'enabled' => 'nullable|boolean',
            'mute_notifications_shortcut' => 'nullable|string',
            'archive_chat_shortcut' => 'nullable|string',
        ]);

        $userId = $validatedData['user_id'];
        $settings = Cache::get("settings_keyboard_shortcuts_{$userId}", [
            'user_id' => (int) $userId,
            'enabled' => true,
            'mute_notifications_shortcut' => 'Ctrl+Alt+M',
            'archive_chat_shortcut' => 'Ctrl+Alt+A',
        ]);

        foreach ($validatedData as $key => $value) {
            if ($value !== null) {
                $settings[$key] = $value;
            }
        }

        Cache::put("settings_keyboard_shortcuts_{$userId}", $settings);

        return response()->json([
            'success' => true,
            'message' => 'Keyboard shortcuts settings updated successfully.',
            'data' => $settings
        ]);
    }
}
