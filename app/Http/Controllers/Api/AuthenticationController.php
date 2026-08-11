<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;

class AuthenticationController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 401);
        }

        $user = Auth::user();
        $user->tokens()->delete();
        $abilities = $user->getAllPermissions()->pluck('name')->toArray();
        $role = $user->roles()->first()?->name;
        $token = $user->createToken('auth_token', $abilities)->plainTextToken;

        return response()
            ->json([
                'success' => true,
                'message' => 'Authorization complete.',
                'token' => $token,
                'abilities' => $abilities,
                'user' => [
                    'role' => $role,
                    'name' => $user->name,
                    'email' => $user->email,
                ],
            ], 200);
    }

    public function logout(Request $request)
    {
        $user = Auth::user();
        $user->tokens()->delete();
        return response()->json(['message' => 'Logged out successfully.'], 200);
    }
}
