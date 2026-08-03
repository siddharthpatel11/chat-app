<?php

namespace App\Http\Controllers\Api\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TransferChatApiController extends Controller
{
    use \App\Traits\ApiResponse;

    protected $db;

    public function __construct()
    {
        $firebaseService = app(\App\Services\FirebaseService::class);
        $this->db = $firebaseService->database();
    }

    /**
     * Initiate a transfer session (Called by Old Phone)
     */
    public function initiate(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $userId = $request->user_id;
        
        // Ensure user is authenticated
        if (auth()->check() && auth()->id() != $userId) {
            return $this->errorResponse('Unauthorized', 403);
        }

        try {
            $sessionId = (string) \Illuminate\Support\Str::uuid();
            $authCode = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
            $formattedCode = substr($authCode, 0, 3) . '-' . substr($authCode, 3, 3);
            
            // Register intent in Firebase
            $this->db->getReference("transfer_intents/{$userId}")->set([
                'status' => 'waiting_for_receiver',
                'timestamp' => now()->timestamp * 1000
            ]);

            // Create transfer session in Firebase
            $this->db->getReference("transfer_sessions/{$sessionId}")->set([
                'status' => 'waiting',
                'progress' => 0,
                'auth_code' => $authCode,
                'created_at' => now()->timestamp * 1000
            ]);

            // QR Code Data format (matching web UI logic)
            // e.g. whatsapp_transfer_demo_123
            $qrData = $sessionId;

            return $this->successResponse([
                'session_id' => $sessionId,
                'auth_code' => $authCode,
                'formatted_code' => $formattedCode,
                'qr_data' => $qrData,
                'status' => 'waiting'
            ], 'Transfer session initiated successfully.');

        } catch (\Exception $e) {
            \Log::error('Transfer API Error (initiate): ' . $e->getMessage());
            return $this->errorResponse('Failed to initiate transfer session', 500);
        }
    }

    /**
     * Link/Scan a transfer session (Called by New Phone)
     */
    public function scan(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'session_id' => 'required|string',
            'auth_code' => 'nullable|string', // Optional if scanning QR code directly
        ]);

        $userId = $request->user_id;
        $sessionId = $request->session_id;

        if (auth()->check() && auth()->id() != $userId) {
            return $this->errorResponse('Unauthorized', 403);
        }

        try {
            $sessionRef = $this->db->getReference("transfer_sessions/{$sessionId}");
            $session = $sessionRef->getValue();

            if (!$session) {
                return $this->errorResponse('Transfer session not found or expired', 404);
            }

            // Verify Auth Code if provided
            if ($request->filled('auth_code')) {
                $code = str_replace('-', '', $request->auth_code);
                if (isset($session['auth_code']) && $session['auth_code'] !== $code) {
                    return $this->errorResponse('Invalid authentication code', 400);
                }
            }

            // Update session status to authorized
            $sessionRef->update([
                'status' => 'authorized'
            ]);

            return $this->successResponse([
                'session_id' => $sessionId,
                'status' => 'authorized'
            ], 'Device linked successfully.');

        } catch (\Exception $e) {
            \Log::error('Transfer API Error (scan): ' . $e->getMessage());
            return $this->errorResponse('Failed to scan transfer session', 500);
        }
    }

    /**
     * Update transfer progress (Called by Old Phone usually)
     */
    public function updateProgress(Request $request)
    {
        $request->validate([
            'session_id' => 'required|string',
            'progress' => 'required|integer|min:0|max:100',
            'status' => 'required|in:transferring,completed,failed',
        ]);

        $sessionId = $request->session_id;

        try {
            $sessionRef = $this->db->getReference("transfer_sessions/{$sessionId}");
            
            if (!$sessionRef->getValue()) {
                return $this->errorResponse('Transfer session not found', 404);
            }

            $sessionRef->update([
                'progress' => (int) $request->progress,
                'status' => $request->status
            ]);

            return $this->successResponse([
                'session_id' => $sessionId,
                'status' => $request->status,
                'progress' => (int) $request->progress
            ], 'Progress updated successfully.');

        } catch (\Exception $e) {
            \Log::error('Transfer API Error (updateProgress): ' . $e->getMessage());
            return $this->errorResponse('Failed to update progress', 500);
        }
    }

    /**
     * Complete the transfer
     */
    public function complete(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'session_id' => 'required|string',
        ]);

        $userId = $request->user_id;
        $sessionId = $request->session_id;

        if (auth()->check() && auth()->id() != $userId) {
            return $this->errorResponse('Unauthorized', 403);
        }

        try {
            // Update session to completed if not already
            $this->db->getReference("transfer_sessions/{$sessionId}")->update([
                'progress' => 100,
                'status' => 'completed'
            ]);

            // Clear intent
            $this->db->getReference("transfer_intents/{$userId}")->remove();

            return $this->successResponse([
                'session_id' => $sessionId,
                'status' => 'completed',
                'completed_at' => now()->toDateTimeString()
            ], 'Transfer completed successfully.');

        } catch (\Exception $e) {
            \Log::error('Transfer API Error (complete): ' . $e->getMessage());
            return $this->errorResponse('Failed to complete transfer', 500);
        }
    }

    /**
     * Cancel the transfer
     */
    public function cancel(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'session_id' => 'required|string',
        ]);

        $userId = $request->user_id;
        $sessionId = $request->session_id;

        if (auth()->check() && auth()->id() != $userId) {
            return $this->errorResponse('Unauthorized', 403);
        }

        try {
            // Clear session and intent
            $this->db->getReference("transfer_sessions/{$sessionId}")->remove();
            $this->db->getReference("transfer_intents/{$userId}")->remove();

            return $this->successResponse([
                'session_id' => $sessionId,
                'status' => 'cancelled',
                'cancelled_at' => now()->toDateTimeString()
            ], 'Transfer cancelled successfully.');

        } catch (\Exception $e) {
            \Log::error('Transfer API Error (cancel): ' . $e->getMessage());
            return $this->errorResponse('Failed to cancel transfer', 500);
        }
    }
}
