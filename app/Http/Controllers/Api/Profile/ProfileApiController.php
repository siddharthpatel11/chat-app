<?php

namespace App\Http\Controllers\Api\Profile;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileApiController extends Controller
{
    use \App\Traits\ApiResponse;

    public function updateProfile(Request $request, \App\Services\FirebaseService $firebaseService)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $userId = $request->user_id;
        $user = User::find($userId);

        if (! $user) {
            return $this->errorResponse('User not found', 404);
        }

        $data = [];
        if ($request->has('name')) {
            $data['name'] = $request->name;
        }
        if ($request->has('phone')) {
            $data['phone'] = $request->phone;
        }
        if ($request->has('about')) {
            $data['about'] = $request->about;
            // Automatically set dynamic update time on server side if not provided
            if (! $request->has('about_subtitle')) {
                $data['about_subtitle'] = 'UPDATED|'.now()->toIso8601String();
            }
        }
        if ($request->has('about_subtitle')) {
            $data['about_subtitle'] = $request->about_subtitle;
        }

        // 🖼️ Handle Avatar Upload
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $path = $file->store('avatars', 'public');
            $data['avatar'] = '/storage/'.$path;
        }

        if (empty($data)) {
            return $this->errorResponse('No data provided', 400);
        }

        $user->update($data);

        // Sync to Firebase
        try {
            $firebaseData = [];
            if (isset($data['name'])) $firebaseData['name'] = $data['name'];
            if (isset($data['about'])) $firebaseData['about'] = $data['about'];
            if (isset($data['about_subtitle'])) $firebaseData['about_subtitle'] = $data['about_subtitle'];
            if (array_key_exists('avatar', $data)) $firebaseData['avatar'] = $data['avatar'];
            
            if (!empty($firebaseData)) {
                $firebaseService->database()->getReference("users/{$user->id}/profile")->update($firebaseData);
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Firebase profile sync error API: ' . $e->getMessage());
        }

        return response()->json([
            'status' => true,
            'message' => 'Profile updated successfully',
            'data' => $user,
        ]);
    }

    public function getProfile(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $userId = $request->user_id;
        $user = User::find($userId);

        if (! $user) {
            return $this->errorResponse('User not found', 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Profile details retrieved successfully',
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'about' => $user->about,
                'about_subtitle' => $user->about_subtitle,
                'avatar' => $user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=2a3942&color=fff&size=256',
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,
            ],
        ]);
    }
}
