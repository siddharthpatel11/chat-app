<?php

namespace App\Http\Controllers\Api\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class AccountApiController extends Controller
{
    /**
     * Get Account Settings
     */
    public function getSettings(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $userId = $request->user_id;
        $settings = Cache::get("settings_account_{$userId}", [
            'user_id' => (int) $userId,
            'security_notifications' => true,
            'two_step_verification' => false,
            'change_number' => null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Account settings retrieved successfully.',
            'data' => $settings
        ]);
    }

    /**
     * Update Account Settings
     */
    public function updateSettings(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'security_notifications' => 'nullable|boolean',
            'two_step_verification' => 'nullable|boolean',
            'change_number' => 'nullable|string',
        ]);

        $userId = $validatedData['user_id'];
        $settings = Cache::get("settings_account_{$userId}", [
            'user_id' => (int) $userId,
            'security_notifications' => true,
            'two_step_verification' => false,
            'change_number' => null,
        ]);

        foreach ($validatedData as $key => $value) {
            if ($value !== null) {
                $settings[$key] = $value;
            }
        }

        Cache::put("settings_account_{$userId}", $settings);

        return response()->json([
            'success' => true,
            'message' => 'Account settings updated successfully.',
            'data' => $settings
        ]);
    }
}
