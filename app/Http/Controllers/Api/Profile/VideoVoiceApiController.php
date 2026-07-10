<?php

namespace App\Http\Controllers\Api\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class VideoVoiceApiController extends Controller
{
    use \App\Traits\ApiResponse;

    /**
     * Get Video & Voice Settings
     */
    public function getSettings(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $userId = auth()->id();
        $settings = Cache::get("settings_video_voice_{$userId}", [
            'user_id' => (int) $userId,
            'camera' => 'default',
            'microphone' => 'default',
            'speakers' => 'default',
            'incoming_call_ring' => true,
        ]);

        return $this->successResponse(['success' => true,
            'message' => 'Video & voice settings retrieved successfully.',
            'data' => $settings], 'Success', 200);
    }

    /**
     * Update Video & Voice Settings
     */
    public function updateSettings(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'camera' => 'nullable|string',
            'microphone' => 'nullable|string',
            'speakers' => 'nullable|string',
            'incoming_call_ring' => 'nullable|boolean',
        ]);

        $userId = $validatedData['user_id'];
        $settings = Cache::get("settings_video_voice_{$userId}", [
            'user_id' => (int) $userId,
            'camera' => 'default',
            'microphone' => 'default',
            'speakers' => 'default',
            'incoming_call_ring' => true,
        ]);

        foreach ($validatedData as $key => $value) {
            if ($value !== null) {
                $settings[$key] = $value;
            }
        }

        Cache::put("settings_video_voice_{$userId}", $settings);

        return $this->successResponse(['success' => true,
            'message' => 'Video & voice settings updated successfully.',
            'data' => $settings], 'Success', 200);
    }
}
