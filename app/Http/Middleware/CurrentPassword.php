<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CurrentPassword
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

        $user = $request->user();

        if (!$user) {
            abort(403, 'Por favor, inicia sesión.');
        }

        if ($user->password_changed_at->lessThan($this->datetimeLimit())) {
            abort(403, 'Tu contraseña ha expirado. Debes cambiarla para continuar.');
        }

        return $next($request);
    }

    private function datetimeLimit(): \DateTime
    {
        $daysLimit = (int) config('app.days_password_change');
        $limit = new \DateTime();
        $limit->modify("-{$daysLimit} days");
        return $limit;
    }
}
