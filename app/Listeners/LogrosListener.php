<?php

namespace App\Listeners;

use App\Models\User;

class LogrosListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $logros = $user->logros->count();

        if($logros == 5) {
            $user->logros()->attach([
                6
            ]);
        }
    }
}
