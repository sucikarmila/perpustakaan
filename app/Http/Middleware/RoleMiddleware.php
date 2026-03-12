<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle($request, Closure $next, ...$roles)
{
    if (!in_array(auth()->user()->Role, $roles)) {
        abort(403, 'Anda tidak memiliki akses ke halaman ini.');
    }
    return $next($request);
}
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
   
}
