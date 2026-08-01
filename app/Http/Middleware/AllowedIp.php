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
        $user = auth()->user();

        if (!$user) {
            abort(403, 'Por favor, inicia sesión.');
        }

        if ($user->hasRole('administrator')) {
            return $next($request);
        }

        if (\App\Models\AllowedIp::where('ip', $request->ip())->exists()) {
            return $next($request);
        }

        abort(403, 'Tu IP no está autorizada. Si lo crees un error, contacta al area de sistemas');
    }
}
