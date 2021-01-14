<?php

namespace App\Listeners;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class EncuestaListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        if(Auth::user()->logros->where('logro_id', 6)->count() == 0) {

            $encuestas = $user->opciones->count();

            if ($encuestas >= 5) {
                $user->logros()->sync([
                    6
                ], false);

                event(new LogrosListener($user));
            }
        }
    }
}
