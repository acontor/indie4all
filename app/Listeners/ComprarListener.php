<?php

namespace App\Listeners;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ComprarListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        if(Auth::user()->logros->where('logro_id', 3)->count() == 0) {

            $compras = $user->compras->count();

            if ($compras >= 5) {
                $user->logros()->sync([
                    3
                ], false);

                event(new LogrosListener($user));
            }
        }
    }
}
