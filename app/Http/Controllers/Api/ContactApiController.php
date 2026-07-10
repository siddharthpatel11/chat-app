<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Http\Request;

class ContactApiController extends Controller
{
    use \App\Traits\ApiResponse;
    public function checkPhone(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
        ]);

        // Clean phone number (remove spaces, etc) if needed
        $phone = preg_replace('/\s+/', '', $request->phone);

        $user = User::where('phone', $phone)
            ->orWhere('phone', 'like', '%'.$phone)
            ->first();

        if ($user) {
            return $this->successResponse(['user' => $user], 'This phone number is on WhatsApp.');
        }

        return $this->errorResponse('This phone number is not on WhatsApp. Invite them on your primary device.', 404);
    }

    public function saveContact(Request $request)
    {
        $request->validate([
            'contact_user_id' => 'required|exists:users,id',
            'custom_name' => 'nullable|string|max:255',
        ]);

        $userId = auth()->id();
        if (! $userId) {
            return $this->errorResponse('Unauthorized', 401);
        }

        $contact = Contact::updateOrCreate(
            ['user_id' => $userId, 'contact_user_id' => $request->contact_user_id],
            ['custom_name' => $request->custom_name]
        );

        return $this->successResponse(['contact' => $contact], 'Contact saved successfully');
    }

    public function deleteContact(Request $request)
    {
        $request->validate([
            'contact_user_id' => 'required|exists:users,id',
        ]);

        $userId = auth()->id();
        if (! $userId) {
            return $this->errorResponse('Unauthorized', 401);
        }

        Contact::where('user_id', $userId)
            ->where('contact_user_id', $request->contact_user_id)
            ->delete();

        return $this->successResponse([], 'Contact deleted successfully');
    }

    // Get Single Contact/User Info
    public function contactInfo($userId)
    {
        $user = User::find($userId);

        if (! $user) {
            return $this->errorResponse('User not found', 404);
        }

        // Check if current user has saved this contact
        $authId = auth()->id() ?? request('user_id');
        $isSaved = false;
        $customName = null;

        if ($authId) {
            $contact = Contact::where('user_id', $authId)
                ->where('contact_user_id', $userId)
                ->first();

            if ($contact) {
                $isSaved = true;
                $customName = $contact->custom_name;
            }
        }

        return $this->successResponse([
            'user' => $user,
            'is_saved' => $isSaved,
            'saved_name' => $customName,
        ]);
    }
}
