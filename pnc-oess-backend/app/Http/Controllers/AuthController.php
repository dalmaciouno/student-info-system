<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

// NO-SECURITY VERSION: login only looks the user up by username so the
// frontend knows who is "logged in". No password check, no status check.
class AuthController extends Controller
{
    public function login(Request $request)
    {
        $data = $request->validate([
            'username' => 'required|string',
            'password' => 'nullable|string',
        ]);

        $user = User::where('username', strtolower(trim($data['username'])))->first();

        if (! $user) {
            return response()->json(['message' => 'Invalid username or password. Please try again.'], 401);
        }

        return response()->json([
            'user' => $user,
            'token' => $user->createToken('oess')->plainTextToken,
        ]);
    }

    public function me(Request $request)
    {
        return $request->user();
    }

    public function logout(Request $request)
    {
        $request->user()?->currentAccessToken()?->delete();
        return response()->json(['message' => 'Logged out.']);
    }
}
