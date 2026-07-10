<?php

namespace App\Http\Controllers\Api\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class GeneralApiController extends Controller
{
    use \App\Traits\ApiResponse;

    /**
     * Get General Settings
     */
    public function getSettings(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $userId = auth()->id();
        $settings = Cache::get("settings_general_{$userId}", [
            'user_id' => (int) $userId,
            'theme' => 'system',
            'startup_behavior' => 'default',
        ]);

        return $this->successResponse(['success' => true,
            'message' => 'General settings retrieved successfully.',
            'data' => $settings], 'Success', 200);
    }

    /**
     * Update General Settings
     */
    public function updateSettings(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'theme' => 'nullable|string',
            'startup_behavior' => 'nullable|string',
        ]);

        $userId = $validatedData['user_id'];
        $settings = Cache::get("settings_general_{$userId}", [
            'user_id' => (int) $userId,
            'theme' => 'system',
            'startup_behavior' => 'default',
        ]);

        foreach ($validatedData as $key => $value) {
            if ($value !== null) {
                $settings[$key] = $value;
            }
        }

        Cache::put("settings_general_{$userId}", $settings);

        return $this->successResponse(['success' => true,
            'message' => 'General settings updated successfully.',
            'data' => $settings], 'Success', 200);
    }
}
