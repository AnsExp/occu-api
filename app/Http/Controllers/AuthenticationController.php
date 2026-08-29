<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\LoginAttempt;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found.'
            ], 401);
        }

        $limit = config('auth.failed_attempts_limit', 5);

        if ($user->blocked_at || $user->failed_attempts >= $limit) {

            if (!$user->blocked_at) {
                $user->update(['blocked_at' => now()]);

                LoginAttempt::create([
                    'user_id' => $user->id,
                    'success' => false,
                    'ip_address' => $request->ip(),
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Account is blocked due to too many failed login attempts.'
            ], 403);
        }

        if (!Auth::attempt($credentials)) {

            Auth::setUser($user);

            LoginAttempt::create([
                'user_id' => $user->id,
                'success' => false,
                'ip_address' => $request->ip(),
            ]);

            $user->increment('failed_attempts');

            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 401);
        }

        LoginAttempt::create([
            'user_id' => $user->id,
            'success' => true,
            'ip_address' => $request->ip(),
        ]);

        $user->update(['failed_attempts' => 0]);

        $user->tokens()->delete();

        $abilities = $user->getAllPermissions()->pluck('name')->toArray();
        $token = $user->createToken('auth_token', $abilities)->plainTextToken;

        return response()->json([
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

    public function changePasswordPerUser(Request $request, User $user)
    {
        $request->validate([
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user->password = \Hash::make($request->input('new_password'));
        $user->save();

        return response()->json(['message' => 'Password changed successfully.'], 200);
    }
}
