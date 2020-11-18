<?php

namespace App\Listeners;

use App\Models\Logro;
use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Carbon\Carbon;

class LogSuccessfulLogin
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Login  $event
     * @return void
     */
    public function handle()
    {
        if (Auth::check()) {
            $usuario = User::find(Auth::id());

            $date = Carbon::now();

            $timestamp = $date->toDateTimeString();

            $usuario->update(['last_activity' => $timestamp]);

            if ($date->diffInDays($usuario->created_at) >= 365 && !$usuario->logros->find(2)) {
                $usuario->logros()->attach([
                    2
                ]);
            }
        }
    }
}
