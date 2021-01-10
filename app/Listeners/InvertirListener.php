<?php

namespace App\Listeners;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class InvertirListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        if(Auth::user()->logros->where('logro_id', 4)->count() == 0) {

            $inversiones = $user->compras->count();

            if ($inversiones >= 5) {
                $user->logros()->attach([
                    4
                ]);

                event(new LogrosListener($user));
            }
        }
    }
}
