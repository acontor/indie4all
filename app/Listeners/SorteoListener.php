<?php

namespace App\Listeners;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SorteoListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        if(Auth::user()->logros->where('logro_id', 7)->count() == 0) {

            $sorteos = $user->sorteos->count();

            if ($sorteos >= 5) {
                $user->logros()->sync([
                    7
                ], false);

                event(new LogrosListener($user));
            }
        }
    }
}
