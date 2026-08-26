<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AllowedIp
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (config('app.debug', false)) {
            return $next($request);
        }

        if (!auth()->check()) {
            abort(403, 'Por favor, inicia sesión.');
        }

        $ip = $request->ip();
        $allowedIp = \App\Models\AllowedIp::where('ip', $ip)->first();

        if (!$allowedIp) {
            abort(403, 'Tu IP no está autorizada. Si lo crees un error, contacta al área de sistemas.');
        }

        if ($allowedIp->expires_at && now()->greaterThan($allowedIp->expires_at)) {
            abort(403, 'Tu IP estaba autorizada, pero el periodo ha expirado.');
        }

        return $next($request);
    }
}
