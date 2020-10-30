<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use App\Models\Desarrolladora;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

class DesarrolladorasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $desarrolladoras = Desarrolladora::all();
        return view('usuario.desarrolladoras', compact('desarrolladoras'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('usuario.solicitud.desarrolladora');
        // Form para solicitar una desarrolladora
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Se crea una tupla en Solicitudes
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $usuario = User::find(Auth::id())->desarrolladoras()->where('desarrolladora_id','=', $id)->first();
        $desarrolladora = Desarrolladora::find($id);
        return view('usuario.desarrolladora', compact('desarrolladora', 'usuario'));
    }

    public function follow($id)
    {
        $user = User::find(Auth::id());

        $user->desarrolladoras()->attach([
            $id => ['notificacion' => true]
        ]);

        return redirect()->route('usuario.desarrolladora.show', ['id' => $id]);
    }

    public function unfollow($id)
    {
        $user = User::find(Auth::id());

        $user->desarrolladoras()->detach($id);

        return redirect()->route('usuario.desarrolladora.show', ['id' => $id]);
    }

    public function notificacion($id, $notificacion)
    {
        $user = User::find(Auth::id());

        $user->desarrolladoras()->sync([
            $id => ['notificacion' => $notificacion]
        ], false);

        return redirect()->route('usuario.desarrolladora.show', ['id' => $id]);
    }
}
