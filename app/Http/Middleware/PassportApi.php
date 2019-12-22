<?php

namespace App\Http\Middleware;

use Closure;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class PassportApi
{

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $guard = $request->get('guard');

        if (!$guard) {
            throw new UnauthorizedHttpException('', 'guard not found');
        }
        if (auth($guard)->check()) {
            auth()->shouldUse($guard);
            return $next($request);
        }

        throw new UnauthorizedHttpException('', 'Unauthenticated');
    }
}
