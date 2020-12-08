<?php

namespace App\Listeners;

use App\Models\User;

class InvertirListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $inversiones = $user->compras->count();

        if ($inversiones >= 5) {
            $user->logros()->attach([
                4
            ]);

            event(new LogrosListener($user));
        }
    }
}
