<?php

namespace App\Http\Controllers\Api;

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
        $credentials = $this->validateCredentials($request);

        $user = User::findByEmail($credentials['email']);
        if (!$user) {
            return $this->errorResponse('User not found.', 401);
        }

        if ($this->isBlocked($user, $request)) {
            return $this->errorResponse('Account is blocked due to too many failed login attempts.', 403);
        }

        if ($this->isPasswordExpired($user, $request)) {
            return $this->errorResponse('Account is blocked because the password has expired.', 403);
        }

        if (!Auth::attempt($credentials)) {
            $this->registerFailedAttempt($user, $request);
            return $this->errorResponse('Unauthorized', 401);
        }

        return $this->successLogin($user, $request);
    }

    private function validateCredentials(Request $request): array
    {
        return $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);
    }

    private function isBlocked(User $user, Request $request): bool
    {
        $limit = config('auth.failed_attempts_limit', 5);

        if ($user->blocked_at || $user->failed_attempts >= $limit) {
            if (!$user->blocked_at) {
                $user->update(['blocked_at' => now()]);
                $this->logAttempt($user, false, $request->ip());
            }
            return true;
        }
        return false;
    }

    private function isPasswordExpired(User $user, Request $request): bool
    {
        $expiryDate = $user->password_changed_at
            ->copy()
            ->addDays((int) config('app.days_password_change'));

        if (now()->greaterThan($expiryDate)) {
            $user->update(['blocked_at' => now()]);
            $this->logAttempt($user, false, $request->ip());
            return true;
        }
        return false;
    }

    private function registerFailedAttempt(User $user, Request $request): void
    {
        Auth::setUser($user);
        $this->logAttempt($user, false, $request->ip());
        $user->increment('failed_attempts');
    }

    private function successLogin(User $user, Request $request)
    {
        $this->logAttempt($user, true, $request->ip());
        $user->update(['failed_attempts' => 0]);
        $user->tokens()->delete();

        $abilities = $user->getAllPermissions()->pluck('name')->toArray();
        $token = $user->createToken('auth_token', $abilities)->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Authorization complete.',
            'token' => $token,
            'user' => [
                'name' => $user->name,
                'email' => $user->email,
                'roles' => $user->roles()->pluck('name')->toArray(),
            ],
        ], 200);
    }

    private function logAttempt(User $user, bool $success, string $ip): void
    {
        LoginAttempt::create([
            'user_id' => $user->id,
            'success' => $success,
            'ip_address' => $ip,
        ]);
    }

    private function errorResponse(string $message, int $status)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
        ], $status);
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
