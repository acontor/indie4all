<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use App\Models\Juego;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JuegosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $juegos = Juego::all();
        return view('usuario.juegos', ['juegos' => $juegos]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $usuario = User::find(Auth::id())->juegos()->where('juego_id', '=', $id)->first();
        $juego = Juego::find($id);
        return view('usuario.juego', ['juego' => $juego, 'usuario' => $usuario]);
    }

    public function follow($id)
    {
        $user = User::find(Auth::id());
        $user->juegos()->sync([$id => ['notificacion' => true]]);

        return redirect()->route('usuario.juego.show', ['id' => $id]);
    }

    public function unfollow($id)
    {
        $user = User::find(Auth::id());

        $user->juegos()->detach($id);

        return redirect()->route('usuario.juego.show', ['id' => $id]);
    }

    public function notificacion($id, $notificacion)
    {
        $user = User::find(Auth::id());

        $user->juegos()->sync([
            $id => ['notificacion' => $notificacion]
        ], false);

        return redirect()->route('usuario.juego.show', ['id' => $id]);
    }
}
