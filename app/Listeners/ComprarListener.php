<?php

namespace App\Listeners;

use App\Models\User;

class ComprarListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $compras = $user->compras->count();

        if ($compras >= 5) {
            $user->logros()->attach([
                3
            ]);

            event(new LogrosListener($user));
        }
    }
}
