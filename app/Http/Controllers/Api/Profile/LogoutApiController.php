<?php

namespace App\Http\Controllers\Api\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LogoutApiController extends Controller
{
    use \App\Traits\ApiResponse;

    /**
     * Log out user
     */
    public function logout(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $user = auth()->user();
        
        // Clear FCM token on logout
        $user->update(['fcm_token' => null]);

        // Revoke all Sanctum tokens for the user
        $user->tokens()->delete();

        // If it's a web-session request, invalidate it
        if (Auth::check() && Auth::id() == $user->id) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        return $this->successResponse(['success' => true,
            'message' => 'User logged out successfully.'], 'Success', 200);
    }
}
