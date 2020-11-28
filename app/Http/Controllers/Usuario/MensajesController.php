<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use App\Listeners\MensajesListener;
use App\Models\Mensaje;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MensajesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        $user = User::find(Auth::id());

        $mensaje = Mensaje::create([
            'contenido' => $request->mensaje,
            'post_id' => $request->id,
            'user_id' => Auth::id(),
        ]);

        event(new MensajesListener($user));

        return $mensaje = [
            'contenido' => $mensaje->contenido,
            'created_at' => $mensaje->created_at,
            'autor' => Auth::user()->name,
        ];
    }
}
