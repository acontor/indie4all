<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use App\Models\Desarrolladora;
use App\Models\Solicitud;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        return view('usuario.desarrolladoras', ['desarrolladoras' => $desarrolladoras]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('usuario.solicitud_desarrolladora');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'email' => 'required',
            'direccion' => 'required',
            'telefono' => 'required',
            'url' => 'required',
        ]);

        Solicitud::create([
            'nombre' => $request->nombre,
            'email' => $request->email,
            'direccion' => $request->direccion,
            'telefono' => $request->telefono,
            'url' => $request->url,
            'tipo' => 'Desarrolladora',
            'user_id' => Auth::id(),
        ]);

        return redirect('/desarrolladoras');
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
        return view('usuario.desarrolladora', ['desarrolladora' => $desarrolladora, 'usuario' => $usuario]);
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
