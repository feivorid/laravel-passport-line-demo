<?php

namespace App\Http\Middleware;

use Closure;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class TeacherApi
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
        if (auth('student')->check()) {
            auth()->shouldUse('student');
            return $next($request);
        }

        throw new UnauthorizedHttpException('', 'Unauthenticated');
    }
}
