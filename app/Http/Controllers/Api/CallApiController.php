<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\FirebaseService;
use App\Services\NotificationService;

class CallApiController extends Controller
{
    use \App\Traits\ApiResponse;
    protected $db;
    protected $notificationService;

    public function __construct(FirebaseService $firebaseService, NotificationService $notificationService)
    {
        $this->db = $firebaseService->database();
        $this->notificationService = $notificationService;
    }

    //  Initiate Voice / Video Call
    public function initiateCall(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required',
            'call_type' => 'required|in:voice,video', // voice or video
        ]);

        $callerId = auth()->id();
        if (!$callerId) {
            return $this->errorResponse('Unauthorized', 401);
        }

        $callId = 'call_'.time().'_'.uniqid();
        $caller = auth()->user();

        $data = [
            'caller_id' => $callerId,
            'receiver_id' => $request->receiver_id,
            'call_type' => $request->call_type,
            'status' => 'calling', // calling, ringing, accepted, rejected, ended
            'time' => now()->timestamp,
        ];

        // Save call info in Firebase
        $this->db->getReference("calls/$callId")->set($data);

        // Send Notification to Receiver using NotificationService
        $title = 'Incoming '.ucfirst($request->call_type).' Call';
        $body = ($caller ? $caller->name : 'Someone').' is calling you';
        $notificationData = [
            'type' => 'call',
            'call_id' => $callId,
            'caller_id' => $callerId,
            'call_type' => $request->call_type,
        ];
        
        $this->notificationService->sendToUsers([$request->receiver_id], $title, $body, $notificationData);

        return $this->successResponse(['call_id' => $callId], 'Call initiated');
    }

    //  Update Call Status (Accept / Reject / End)
    public function updateCallStatus(Request $request)
    {
        $request->validate([
            'call_id' => 'required',
            'status' => 'required|in:ringing,accepted,rejected,ended',
        ]);

        $this->db->getReference('calls/'.$request->call_id)->update([
            'status' => $request->status,
            'updated_at' => now()->timestamp,
        ]);

        return $this->successResponse([], 'Call status updated to '.$request->status);
    }
}
