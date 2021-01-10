<?php

namespace App\Listeners;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class FollowListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        if(Auth::user()->logros->where('logro_id', 5)->count() == 0) {

            $follows = $user->desarrolladoras->count() + $user->juegos->count() + $user->masters->count();

            if ($follows >= 5) {
                $user->logros()->attach([
                    5
                ]);

                event(new LogrosListener($user));
            }
        }
    }
}
