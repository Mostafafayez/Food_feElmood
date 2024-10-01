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
            'email' => 'required|string|email|max:255|unique:users',  // Ensure table name is lowercase
            'password' => 'required|string|min:8',
        ]);

        // Log only non-sensitive information (remove in production)
        Log::info('Validated User Name:', ['name' => $validated['name'],'password' => $validated['password']]);

        // Create user with hashed password
        $user = Users::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']), // Ensure password is hashed
        ]);

        // Return response with user data (excluding password)
        return response()->json([
            'message' => 'User registered successfully',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ],
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
    public function updatePassword(Request $request, $user_id)
    {
        // Find the user by their ID
        $user = Users::find($user_id);

        // Check if the user exists
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Validate the request
        $validated = $request->validate([
            'new_password' => 'required|string|min:8',
        ]);

        // Update the user's password
        $user->update([
            'password' => Hash::make($validated['new_password']),
        ]);

        return response()->json(['message' => 'Password updated successfully'], 200);
    }



}
