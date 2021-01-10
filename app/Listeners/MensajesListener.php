<?php

namespace App\Listeners;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class MensajesListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        if(Auth::user()->logros->where('logro_id', 1)->count() == 0) {

            $mensajes = $user->mensajes->count();

            if ($mensajes >= 5) {
                $user->logros()->attach([
                    1
                ]);

                event(new LogrosListener($user));
            }
        }
    }
}
