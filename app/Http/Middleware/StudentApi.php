<?php

namespace App\Http\Middleware;

use Closure;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class StudentApi
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
        if (auth('teacher')->check()) {
            auth()->shouldUse('teacher');
            return $next($request);
        }

        throw new UnauthorizedHttpException('', 'Unauthenticated');
    }
}
