<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Master;

class CheckMaster
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
        if (Master::where('user_id', $request->user()->id)->count() == 0) {
            return redirect('home');
        }

        return $next($request);
    }
}
