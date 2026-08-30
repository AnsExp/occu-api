<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\LoginAttempt;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * @group Autenticación
 *
 * Inicio y cierre de sesión, emisión de tokens Sanctum y administración de contraseñas.
 */
class AuthenticationController extends Controller
{
    /**
    * Iniciar sesión
    *
    * Valida las credenciales, registra el intento de acceso y devuelve un token personal de Sanctum.
    * El token queda limitado a las habilidades asignadas al usuario y debe enviarse como
    * `Authorization: Bearer {token}` en los endpoints protegidos.
    *
    * Tras alcanzar el límite configurado de intentos fallidos, la cuenta queda bloqueada.
    * Un inicio de sesión exitoso reinicia el contador de intentos y revoca los tokens previos.
    *
    * @bodyParam email string required Correo electrónico registrado del usuario. Example: usuario@occumaster.test
    * @bodyParam password string required Contraseña del usuario. Example: password123
    *
    * @response 200 scenario="Acceso concedido" {
    *   "success": true,
    *   "message": "Authorization complete.",
    *   "token": "1|token-personal-de-sanctum",
    *   "abilities": ["read.patients", "create.medical_dates"],
    *   "user": {
    *     "name": "María Pérez",
    *     "email": "usuario@occumaster.test",
    *     "roles": ["doctor"]
    *   }
    * }
    * @response 401 scenario="Usuario inexistente o credenciales inválidas" {
    *   "success": false,
    *   "message": "Unauthorized"
    * }
    * @response 403 scenario="Cuenta bloqueada" {
    *   "success": false,
    *   "message": "Account is blocked due to too many failed login attempts."
    * }
     */
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

    /**
     * Cerrar sesión
     *
     * Revoca todos los tokens personales activos del usuario autenticado.
     *
     * @authenticated
     * @response 200 {
     *   "message": "Logged out successfully."
     * }
     */
    public function logout(Request $request)
    {
        $user = Auth::user();
        $user->tokens()->delete();
        return response()->json(['message' => 'Logged out successfully.'], 200);
    }
}
