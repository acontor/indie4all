<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use App\Models\Campania;
use App\Models\Mensaje;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CampaniasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $campanias = Campania::all();
        return view('usuario.campanias', ['campanias' => $campanias]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $campania = Campania::find($id);
        return view('usuario.campania', ['campania' => $campania]);
    }

    public function store(Request $request)
    {
        $mensaje = Mensaje::create([
            'contenido' => $request->mensaje,
            'campania_id' => $request->id,
            'user_id' => Auth::id(),
        ]);

        return $mensaje = [
            'contenido' => $mensaje->contenido,
            'created_at' => $mensaje->created_at,
            'autor' => Auth::user()->name,
        ];
    }
}
