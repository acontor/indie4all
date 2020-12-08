<?php

namespace App\Listeners;

use App\Models\User;

class FollowListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $follows = $user->desarrolladoras->count() + $user->juegos->count() + $user->masters->count();

        if ($follows >= 5) {
            $user->logros()->attach([
                5
            ]);

            event(new LogrosListener($user));
        }
    }
}
