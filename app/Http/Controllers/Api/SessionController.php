<?php

namespace App\Http\Controllers\Api;

use App\Http\Responses\ApiResponse;
use App\Http\Requests\SessionPasswordRequest;
use App\Models\AllowedIp;
use Illuminate\Support\Facades\Auth;

class SessionController extends Controller
{
    public function data()
    {
        $user = Auth::user();
        return response()->json([
            'abilities' => $user->tokens()->first()?->abilities ?? [],
            'limit_password_change' => $user->password_changed_at
                ->copy()
                ->addDays((int) config('app.days_password_change'))
                ->format('Y-m-d H:i:s'),
        ]);
    }

    public function checkIp()
    {
        if (config('app.debug', false)) {
            return response()->json([
                'ip' => request()->ip(),
                'allowed' => true,
                'message' => 'IP allowed (debug mode)'
            ]);
        }
        $exists = AllowedIp::where('ip_address', request()->ip())->exists();
        return response()->json([
            'ip' => request()->ip(),
            'allowed' => $exists,
            'message' => $exists ? 'IP allowed' : 'IP not allowed'
        ]);
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
}
