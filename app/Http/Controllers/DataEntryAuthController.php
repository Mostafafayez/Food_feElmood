<?php

namespace App\Http\Controllers;

use App\Models\DataEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class DataEntryAuthController extends Controller
{
    // Data Entry Sign-Up Function
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:data_entries',
            'password' => 'required|string|min:8',
        ]);

        $dataEntry = DataEntry::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json(['message' => 'Data Entry User registered successfully!'], 201);
    }

    // Data Entry Login Function
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (!Auth::guard('data_entry')->attempt($credentials)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $dataEntry = Auth::guard('data_entry')->user();
        $token = $dataEntry->createToken('personalAccessToken')->plainTextToken;
        return response()->json(['token' => $token, 'data_entry' => $dataEntry], 200);
    }
}
