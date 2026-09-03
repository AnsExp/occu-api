<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiResponse;
use App\Models\AllowedIp;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\SessionPasswordRequest;
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

        $allowedIp = AllowedIp::where('ip_address', $ip)->first();

        if (!$allowedIp) {
            return $this->response($ip, false, 'IP address is not allowed.', 403);
        }

        $timezoneIp = occu_ip_timezone($ip);

        if ($allowedIp->expires_at && now()->setTimezone($timezoneIp)->format('Y-m-d H:i:s') > $allowedIp->expires_at->format('Y-m-d H:i:s')) {
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
    public function changePassword(SessionPasswordRequest $request)
    {
        $user = Auth::user();

        $user->password = \Hash::make($request->input('new_password'));
        $user->save();

        return ApiResponse::formResponse([], true, 'Password changed successfully.', 200);
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
