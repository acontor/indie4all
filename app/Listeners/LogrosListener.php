<?php

namespace App\Listeners;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LogrosListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        if(Auth::user()->logros->where('logro_id', 6)->count() == 0) {

            $logros = $user->logros->count();

            if ($logros == 5) {
                $user->logros()->attach([
                    6
                ]);
            }
        }
    }
}
