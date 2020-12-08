<?php

namespace App\Listeners;

use App\Models\User;

class MensajesListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $mensajes = $user->mensajes->count();

        if ($mensajes >= 5) {
            $user->logros()->attach([
                1
            ]);

            event(new LogrosListener($user));
        }
    }
}
