<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckSolicitud
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
        if (Auth::user()->cm || Auth::user()->master || Auth::user()->ban || Auth::user()->reportes > 0 || Auth::user()->solicitud) {
            return redirect('home');
        }

        return $next($request);
    }
}
