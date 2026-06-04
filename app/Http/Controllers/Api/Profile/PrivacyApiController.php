<?php

namespace App\Http\Controllers\Api\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PrivacyApiController extends Controller
{
    protected $db;

    public function __construct()
    {
        if (file_exists(storage_path('app/firebase.json'))) {
            $factory = (new Factory)
                ->withServiceAccount(storage_path('app/firebase.json'))
                ->withDatabaseUri(env('FIREBASE_DATABASE_URL'));

            $this->db = $factory->createDatabase();
        }
    }

    /**
     * Get Privacy Settings
     */
    public function getSettings(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $userId = $request->user_id;
        $settings = Cache::get("settings_privacy_{$userId}", [
            'user_id' => (int) $userId,
            'last_seen' => 'everyone', // everyone, contacts, nobody
            'profile_photo' => 'everyone',
            'about' => 'everyone',
            'groups' => 'everyone',
            'blocked_contacts_count' => 0,
            'disappearing_messages_timer' => 'off', // off, 24h, 7d, 90d
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Privacy settings retrieved successfully.',
            'data' => $settings,
        ]);
    }

    /**
     * Update Privacy Settings
     */
    public function updateSettings(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'last_seen' => 'nullable|string|in:everyone,contacts,nobody',
            'profile_photo' => 'nullable|string|in:everyone,contacts,nobody',
            'about' => 'nullable|string|in:everyone,contacts,nobody',
            'groups' => 'nullable|string|in:everyone,contacts,nobody',
            'blocked_contacts_count' => 'nullable|integer',
            'disappearing_messages_timer' => 'nullable|string|in:off,24h,7d,90d',
        ]);

        $userId = $validatedData['user_id'];
        $settings = Cache::get("settings_privacy_{$userId}", [
            'user_id' => (int) $userId,
            'last_seen' => 'everyone', // everyone, contacts, nobody
            'profile_photo' => 'everyone',
            'about' => 'everyone',
            'groups' => 'everyone',
            'blocked_contacts_count' => 0,
            'disappearing_messages_timer' => 'off', // off, 24h, 7d, 90d
        ]);

        foreach ($validatedData as $key => $value) {
            if ($value !== null) {
                $settings[$key] = $value;
            }
        }

        Cache::put("settings_privacy_{$userId}", $settings);

        if ($this->db) {
            $privacyData = [];
            if (isset($settings['profile_photo'])) {
                $val = 'My contacts';
                if ($settings['profile_photo'] === 'everyone') $val = 'Everyone';
                elseif ($settings['profile_photo'] === 'nobody') $val = 'Nobody';
                elseif ($settings['profile_photo'] === 'contacts') $val = 'My contacts';
                $privacyData['profile_photo'] = $val;
            }
            if (isset($settings['about'])) {
                $val = 'Everyone';
                if ($settings['about'] === 'everyone') $val = 'Everyone';
                elseif ($settings['about'] === 'nobody') $val = 'Nobody';
                elseif ($settings['about'] === 'contacts') $val = 'My contacts';
                $privacyData['about'] = $val;
            }
            if (isset($settings['last_seen'])) {
                $val = 'Everyone';
                if ($settings['last_seen'] === 'everyone') $val = 'Everyone';
                elseif ($settings['last_seen'] === 'nobody') $val = 'Nobody';
                elseif ($settings['last_seen'] === 'contacts') $val = 'My contacts';
                $privacyData['last_seen'] = $val;
            }
            if (!empty($privacyData)) {
                $this->db->getReference("users/{$userId}/privacy")->update($privacyData);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Privacy settings updated successfully.',
            'data' => $settings,
        ]);
    }
}
