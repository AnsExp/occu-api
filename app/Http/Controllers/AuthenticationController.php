<?php

namespace App\Http\Controllers;

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
        // $user->tokens()->delete();
        $abilities = $user->getAllPermissions()->pluck('name')->toArray();
        $token = $user->createToken('auth_token', $abilities)->plainTextToken;

        return response()
            ->json([
                'success' => true,
                'message' => 'Authorization complete.',
                'token' => $token,
                'abilities' => $abilities,
                'user' => [
                    'name' => $user->name,
                    'email' => $user->email,
                    'roles' => $user->roles()->pluck('name')->toArray(),
                ],
            ], 200);
    }

    public function logout(Request $request)
    {
        $user = Auth::user();
        $user->tokens()->delete();
        return response()->json(['message' => 'Logged out successfully.'], 200);
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'string'],
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = Auth::user();

        if (!\Hash::check($request->input('current_password', ''), $user->password)) {
            return response()->json(['message' => 'Current password is incorrect.'], 400);
        }

        $user->password = \Hash::make($request->input('new_password'));
        $user->save();

        return response()->json(['message' => 'Password changed successfully.'], 200);
    }
}
