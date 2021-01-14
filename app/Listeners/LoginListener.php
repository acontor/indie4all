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
        if (Auth::check()) {

            $usuario = User::find(Auth::id());

            $date = Carbon::now();

            $timestamp = $date->toDateTimeString();

            $usuario->update(['last_activity' => $timestamp]);

            if (Auth::user()->logros->where('logro_id', 2)->count() == 0 && $date->diffInDays($usuario->created_at) >= 365) {
                $usuario->logros()->sync([
                    2
                ], false);

                event(new LogrosListener($usuario));
            }
        }
    }
}
