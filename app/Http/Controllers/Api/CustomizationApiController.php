<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\FirebaseService;

class CustomizationApiController extends Controller
{
    use \App\Traits\ApiResponse;

    protected $db;

    public function __construct(FirebaseService $firebaseService)
    {
        $this->db = $firebaseService->database();
    }

    /**
     * Save global app appearance settings (App Icon, Theme Color, Dark Mode)
     */
    public function saveAppAppearance(Request $request)
    {
        $request->validate([
            'app_icon_index' => 'nullable|integer|min:0',
            'app_theme_color_index' => 'nullable|integer|min:0',
            'app_dark_mode' => 'nullable|string|in:system,light,dark',
        ]);

        $userId = auth()->id();
        if (!$userId) {
            return $this->errorResponse('User ID is required', 400);
        }

        $settings = [];
        if ($request->has('app_icon_index')) {
            $settings['app_icon_index'] = (int) $request->app_icon_index;
        }
        if ($request->has('app_theme_color_index')) {
            $settings['app_theme_color_index'] = (int) $request->app_theme_color_index;
        }
        if ($request->has('app_dark_mode')) {
            $settings['app_dark_mode'] = $request->app_dark_mode;
        }

        if (!empty($settings)) {
            $this->db->getReference("users/{$userId}/settings/appearance")->update($settings);
        }

        return $this->successResponse($settings, 'App appearance settings saved successfully');
    }

    /**
     * Save default global chat theme
     */
    public function saveDefaultChatTheme(Request $request)
    {
        $request->validate([
            'theme_id' => 'nullable|string|max:100',
            'bubble_color' => 'nullable|string|max:50',
            'wallpaper_dim' => 'nullable|integer|min:0|max:100',
        ]);

        $userId = auth()->id();
        if (!$userId) {
            return $this->errorResponse('User ID is required', 400);
        }

        $settings = [];
        if ($request->has('theme_id')) {
            $settings['theme_id'] = $request->theme_id;
        }
        if ($request->has('bubble_color')) {
            $settings['bubble_color'] = $request->bubble_color;
        }
        if ($request->has('wallpaper_dim')) {
            $settings['wallpaper_dim'] = (int) $request->wallpaper_dim;
        }

        if (!empty($settings)) {
            $this->db->getReference("users/{$userId}/settings/default_chat_theme")->update($settings);
        }

        return $this->successResponse($settings, 'Default chat theme settings saved successfully');
    }

    /**
     * Save chat-specific theme
     */
    public function saveChatSpecificTheme(Request $request, $chatId)
    {
        $request->validate([
            'theme_id' => 'nullable|string|max:100',
            'bubble_color' => 'nullable|string|max:50',
            'wallpaper_dim' => 'nullable|integer|min:0|max:100',
        ]);

        $userId = auth()->id();
        if (!$userId) {
            return $this->errorResponse('User ID is required', 400);
        }

        $settings = [];
        if ($request->has('theme_id')) {
            $settings['theme_id'] = $request->theme_id;
        }
        if ($request->has('bubble_color')) {
            $settings['bubble_color'] = $request->bubble_color;
        }
        if ($request->has('wallpaper_dim')) {
            $settings['wallpaper_dim'] = (int) $request->wallpaper_dim;
        }

        if (!empty($settings)) {
            // Store under specific chat settings for the user
            $this->db->getReference("chats/{$chatId}/settings/{$userId}/theme")->update($settings);
        }

        return $this->successResponse($settings, 'Chat-specific theme settings saved successfully');
    }
}
