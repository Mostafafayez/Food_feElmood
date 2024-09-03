<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Users;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    // User Signup
    public function signup(Request $request)
    {
        // Validate request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:Users',
            'password' => 'required|string|min:8',
        ]);

        Log::info('Validated User Data:', $validated);
        // Create user with hashed password
        $user = Users::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']), // Ensure password is hashed
        ]);

        // Return response indicating successful registration
        return response()->json([
            'message' => 'User registered successfully',
        ], 201);
    }

    // User Loginuse Illuminate\Support\Facades\Auth;


public function login(Request $request)
{
    // Validate request
    $validated = $request->validate([
        'email' => 'required|string|email',
        'password' => 'required|string',
    ]);

    // Attempt to authenticate
    if (Auth::attempt(['email' => $validated['email'], 'password' => $validated['password']])) {
        // Get authenticated user
        $user = Auth::user();
        Log::info('Validated User Data:', $validated);
        // Generate token
        $token = $user->createToken('personalAccessToken')->plainTextToken;
        // Log::info('Validated User Data:', $token);
        return response()->json([
            'message' => 'Login successful',
            'token' => $token,
        ], 200);
    } else {
        // If authentication fails
        return response()->json([
            'message' => 'Invalid email or password',
        ], 401);
    }
}

    // Update Password
    public function updatePassword(Request $request)
    {
        // Validate request
        $validated = $request->validate([
            'new_password' => 'required|string|min:8',
        ]);

        // Update password
        Auth::user()->update([
            'password' => Hash::make($validated['new_password']),
        ]);

        return response()->json(['message' => 'Password updated successfully'], 200);
    }

}
