<?php

namespace App\Http\Controllers\Api\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HelpFeedbackApiController extends Controller
{
    use \App\Traits\ApiResponse;

    /**
     * Get Help Links
     */
    public function getSettings(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $helpInfo = [
            'user_id' => (int) $request->user_id,
            'help_center_url' => 'https://faq.whatsapp.com',
            'contact_us_url' => 'https://www.whatsapp.com/contact',
            'privacy_policy_url' => 'https://www.whatsapp.com/legal/privacy-policy',
            'app_version' => '1.0.0-stable',
        ];

        return $this->successResponse(['success' => true,
            'message' => 'Help information retrieved successfully.',
            'data' => $helpInfo], 'Success', 200);
    }

    /**
     * Submit Support Feedback
     */
    public function updateSettings(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'feedback_text' => 'required|string|min:5|max:1000',
            'category' => 'nullable|string|in:bug,feature_request,other',
        ]);

        $userId = $validatedData['user_id'];
        
        // Retrieve existing feedback history in cache (if any)
        $feedbackHistory = Cache::get("user_feedback_{$userId}", []);
        
        $newFeedback = [
            'id' => uniqid('fb_'),
            'feedback_text' => $validatedData['feedback_text'],
            'category' => $validatedData['category'] ?? 'other',
            'submitted_at' => now()->toIso8601String(),
        ];

        $feedbackHistory[] = $newFeedback;
        Cache::put("user_feedback_{$userId}", $feedbackHistory);

        return $this->successResponse(['success' => true,
            'message' => 'Feedback submitted successfully.',
            'data' => [
                'user_id' => (int) $userId,
                'feedback' => $newFeedback
            ]], 'Success', 200);
    }
}
