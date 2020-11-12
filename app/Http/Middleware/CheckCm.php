<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Cm;

class CheckCm
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
        if (Cm::where('user_id', $request->user()->id)->count() == 0) {
            return redirect('home');
        }

        return $next($request);
    }
}
