<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckSolicitudDesarrolladora
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!Auth::user()->cm || !Auth::user()->master || Auth::user()->reportes == 0 || !Auth::user()->ban) {
            return redirect('home');
        }

        return $next($request);
    }
}
