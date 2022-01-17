<?php

namespace App\Http\Middleware;

use Closure;
use DateInterval;
use DateTimeImmutable;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{

    public function handle($request, Closure $next, ...$guards)
    {
        $accessToken = $request->session()->get('accessToken', false);

        $now = new DateTimeImmutable();
        if (!empty($accessToken)) {
            if ($accessToken['issued_at']->add(new DateInterval("PT{$accessToken['expires_in']}S")) >= $now) {
                return $next($request);
            }
        }

        return redirect('/login');
    }
}
