<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Api\RegisterUserRequest;
use App\Http\Requests\Api\LoginUserRequest;

class AuthApiController extends Controller
{
    use \App\Traits\ApiResponse;

    // Create New User (Register via API)
    public function registerUser(RegisterUserRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return $this->successResponse([
            'token' => $token,
            'user' => $user,
        ], 'User created successfully');
    }

    // Login User via API (Get Sanctum Token)
    public function loginUser(LoginUserRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return $this->errorResponse('Invalid credentials', 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return $this->successResponse([
            'token' => $token,
            'user' => $user,
        ], 'Login successful');
    }
}
