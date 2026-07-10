<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Services\FirebaseService;

class SettingsApiController extends Controller
{
    use \App\Traits\ApiResponse;
    protected $db;
    protected $disappearingMessageService;

    public function __construct(FirebaseService $firebaseService, \App\Services\DisappearingMessageService $disappearingMessageService)
    {
        $this->db = $firebaseService->database();
        $this->disappearingMessageService = $disappearingMessageService;
    }

    // Update Chat Settings (Mute, Lock, Fav, Disappearing)
    public function updateChatSettings(Request $request)
    {
        $request->validate([
            'chat_id' => 'required',
            'setting_key' => 'required|string',
            'setting_value' => 'required',
        ]);

        $userId = auth()->id();

        $this->db->getReference("chats/{$request->chat_id}/settings/{$userId}/{$request->setting_key}")
            ->set($request->setting_value);

        return $this->successResponse([], 'Settings updated successfully');
    }

    // Update Wallpaper (Global or Chat Specific)
    public function updateWallpaper(Request $request)
    {
        $request->validate([
            'chat_id' => 'nullable|string',
            'chat_type' => 'nullable|in:private,group',
            'color' => 'nullable|string',
            'doodles' => 'nullable|in:true,false,1,0,"true","false"',
        ]);

        $userId = auth()->id();

        $wallpaperSettings = [];
        if ($request->has('color')) $wallpaperSettings['color'] = $request->color;
        if ($request->has('doodles')) $wallpaperSettings['doodles'] = filter_var($request->doodles, FILTER_VALIDATE_BOOLEAN);

        if ($request->hasFile('global_image')) {
            $file = $request->file('global_image');
            $path = $file->store('wallpapers', 'public');
            $wallpaperSettings['global_image'] = url('storage/' . $path);
        } elseif ($request->has('global_image') && is_string($request->global_image)) {
            $wallpaperSettings['global_image'] = $request->global_image;
        }

        if ($request->chat_id) {
            $type = $request->chat_type ?? 'private';
            $node = $type === 'group' ? 'groups' : 'chats';

            $this->db->getReference("{$node}/{$request->chat_id}/settings/{$userId}/wallpaper")
                ->update($wallpaperSettings);
            
            $msg = ucfirst($type) . ' chat wallpaper updated successfully';
        } else {
            $this->db->getReference("users/{$userId}/settings/wallpaper")
                ->update($wallpaperSettings);
            $msg = 'Global wallpaper updated successfully';
        }

        return $this->successResponse([], $msg);
    }

    //  Block/Unblock User
    public function toggleBlockUser(Request $request)
    {
        $request->validate([
            'blocked_user_id' => 'required|exists:users,id',
            'action' => 'required|in:block,unblock',
        ]);

        $userId = auth()->id();

        if ($request->action === 'block') {
            $this->db->getReference("users/{$userId}/blocked/{$request->blocked_user_id}")->set(true);
            $msg = 'User blocked';
        } else {
            $this->db->getReference("users/{$userId}/blocked/{$request->blocked_user_id}")->remove();
            $msg = 'User unblocked';
        }

        return $this->successResponse([], $msg);
    }

    // Report User
    public function reportUser(Request $request)
    {
        $request->validate([
            'reported_user_id' => 'required|exists:users,id',
            'reason' => 'required|string',
        ]);

        $userId = auth()->id();

        $data = [
            'reported_by' => $userId,
            'reported_user' => $request->reported_user_id,
            'reason' => $request->reason,
            'time' => now()->timestamp,
        ];

        $this->db->getReference("reports/users")->push($data);

        return $this->successResponse([], 'User reported successfully');
    }
    
    // Get Hide Chat Settings
    public function getHideChatSettings(Request $request)
    {
        $userId = auth()->id();
        if (!$userId) {
            return $this->errorResponse('User ID is required', 400);
        }
        
        $settings = $this->db->getReference("users/{$userId}/hide_chat_settings")->getValue() ?: [
            'hidden_chats' => [],
            'password_hash' => null
        ];

        // Ensure backward compatibility if someone still has plain text password
        if (isset($settings['password']) && !isset($settings['password_hash'])) {
            $settings['password_hash'] = Hash::make($settings['password']);
        }
        unset($settings['password']); // don't expose plain text password to API
        unset($settings['password_hash']); // don't expose hashed password to API

        return $this->successResponse($settings);
    }

    // Save Hide Chat Settings
    public function saveHideChatSettings(Request $request)
    {
        $request->validate([
            'password' => 'nullable|string',
            'password_hash' => 'nullable|string',
            'hidden_chats' => 'nullable|array'
        ]);

        $userId = auth()->id();
        if (!$userId) {
            return $this->errorResponse('User ID is required', 400);
        }
        
        $pwd = $request->input('password') ?? $request->input('password_hash');
        $hashedPwd = $pwd ? Hash::make($pwd) : null;

        $settings = [
            'password_hash' => $hashedPwd,
            'hidden_chats' => $request->input('hidden_chats', [])
        ];

        $this->db->getReference("users/{$userId}/hide_chat_settings")->set($settings);

        return $this->successResponse([], 'Hide chat settings saved successfully');
    }

    // Set Default Message Timer
    public function setDefaultMessageTimer(Request $request)
    {
        $request->validate([
            'duration' => 'required|integer'
        ]);

        $userId = auth()->id();
        $this->disappearingMessageService->setDefaultTimer($userId, $request->duration);

        return $this->successResponse([], 'Default message timer updated');
    }

    // Set Disappearing Message Timer for a specific chat
    public function setDisappearingMessageTimer(Request $request)
    {
        $request->validate([
            'chat_id' => 'required|string',
            'duration' => 'required|integer'
        ]);

        $this->disappearingMessageService->setChatTimer($request->chat_id, $request->duration);

        return $this->successResponse([], 'Disappearing message timer updated for this chat');
    }
}
