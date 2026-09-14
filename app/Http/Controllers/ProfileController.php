<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Update profile via Web AJAX
     */
    public function updateWebProfile(Request $request, \App\Services\FirebaseService $firebaseService)
    {
        $user = $request->user();

        \Illuminate\Support\Facades\Log::info('Profile Update Request:', [
            'method' => $request->method(),
            'content' => $request->getContent(),
            'all' => $request->all()
        ]);

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

        // Handle Avatar Upload
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $path = $file->store('avatars', 'public');
            $data['avatar'] = '/storage/'.$path;
        }

        // Handle Avatar Removal
        if ($request->has('avatar_remove') && $request->avatar_remove == 'true') {
            $data['avatar'] = null;
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
            \Illuminate\Support\Facades\Log::error('Firebase profile sync error: ' . $e->getMessage());
        }

        // Optionally update other details if provided
        return response()->json([
            'status' => true,
            'message' => 'Profile updated successfully',
            'data' => [
                'name' => $user->name,
                'about' => $user->about,
                'about_subtitle' => $user->about_subtitle,
                'avatar' => $user->avatar,
                'phone' => $user->phone
            ]
        ]);
    }
}
