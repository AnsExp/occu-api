<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FormToken
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->input('_token');

        if (!$token) {
            abort(419, 'Token CSRF inválido');
        }

        if (!hash_equals($request->session()->token(), $token)) {
            abort(419, 'Token CSRF inválido');
        }

        return $next($request);
    }
}
