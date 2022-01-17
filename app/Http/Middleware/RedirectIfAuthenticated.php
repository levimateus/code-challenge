<?php

namespace App\Http\Middleware;

use Closure;
use DateInterval;
use DateTimeImmutable;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $accessToken = $request->session()->get('accessToken', false);

        $now = new DateTimeImmutable();
        if (!empty($accessToken)) {
            if ($accessToken['issued_at']->add(new DateInterval("PT{$accessToken['expires_in']}S")) >= $now) {
                return redirect('/');
            }
        }

        return $next($request);
    }
}
