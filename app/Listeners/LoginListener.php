<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Carbon\Carbon;

class LoginListener
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
     */
    public function handle()
    {
        if (Auth::check() && Auth::user()->logros->where('logro_id', 6)->count() != 0) {

            $usuario = User::find(Auth::id());

            $date = Carbon::now();

            $timestamp = $date->toDateTimeString();

            $usuario->update(['last_activity' => $timestamp]);

            if ($date->diffInDays($usuario->created_at) >= 365 && !$usuario->logros->find(2)) {
                $usuario->logros()->attach([
                    2
                ]);

                event(new LogrosListener($usuario));
            }
        }
    }
}
