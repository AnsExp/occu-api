<?php

namespace App\Http\Controllers;

use App\Models\AllowedIp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionController extends Controller
{
    public function abilities(User $user)
    {
        return response()->json($user->tokens()->first()?->abilities ?? []);
    }

    public function checkIp(Request $request)
    {
        $ip = $request->ip();

        if (config('app.debug', false)) {
            return $this->response($ip, true, 'IP address is allowed (debug mode).');
        }

        $allowedIp = AllowedIp::where('ip', $ip)->first();

        if (!$allowedIp) {
            return $this->response($ip, false, 'IP address is not allowed.', 403);
        }

        if ($allowedIp->expires_at && now()->greaterThan($allowedIp->expires_at)) {
            return $this->response($ip, false, 'IP address is not allowed. The allowed period has expired.', 403);
        }

        return $this->response($ip, true, 'IP address is allowed.');
    }

    /**
     * Cambiar mi contraseña
     *
     * Cambia la contraseña del usuario autenticado. La nueva contraseña debe confirmarse.
     *
     * @authenticated
     * @bodyParam current_password string required Contraseña actual del usuario. Example: password123
     * @bodyParam new_password string required Nueva contraseña, mínimo 8 caracteres. Example: nuevaPassword123
     * @bodyParam new_password_confirmation string required Confirmación idéntica de la nueva contraseña. Example: nuevaPassword123
     * @response 200 {
     *   "message": "Password changed successfully."
     * }
     * @response 400 scenario="Contraseña actual incorrecta" {
     *   "message": "Current password is incorrect."
     * }
     */
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

    private function response(string $ip, bool $allowed, string $message, int $status = 200)
    {
        return response()->json([
            'ip' => $ip,
            'allowed' => $allowed,
            'message' => $message,
        ], $status);
    }
}
