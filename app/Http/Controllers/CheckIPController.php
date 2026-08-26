<?php

namespace App\Http\Controllers;

use App\Models\AllowedIp;
use Illuminate\Http\Request;

class CheckIPController extends Controller
{
    public function __invoke(Request $request)
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

    private function response(string $ip, bool $allowed, string $message, int $status = 200)
    {
        return response()->json([
            'ip' => $ip,
            'allowed' => $allowed,
            'message' => $message,
        ], $status);
    }
}
