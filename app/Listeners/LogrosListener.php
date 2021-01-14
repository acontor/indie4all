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
        if(Auth::user()->logros->where('logro_id', 8)->count() == 0) {

            $logros = $user->logros->count();

            if ($logros == 7) {
                $user->logros()->sync([
                    8
                ], false);
            }
        }
    }
}
