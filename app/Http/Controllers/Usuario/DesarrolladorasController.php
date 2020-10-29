<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use App\Models\Desarrolladora;
use Illuminate\Http\Request;

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
        $desarrolladora = Desarrolladora::find($id);
        return view('usuario.desarrolladora', compact('desarrolladora'));
    }
}
