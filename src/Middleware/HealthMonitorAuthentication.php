<?php

namespace Makeable\HealthMonitorClient\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;

class HealthMonitorAuthentication
{
    /**
     * @param $request
     * @param Closure $next
     * @param null $guard
     * @return mixed
     * @throws AuthenticationException
     * @throws AuthenticationException
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if ($request->token != config('monitor.api-token')) {
            throw new AuthenticationException('Unauthenticated.');
        }

        return $next($request);
    }
}
