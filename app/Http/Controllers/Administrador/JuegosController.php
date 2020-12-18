<?php

namespace App\Http\Controllers\Administrador;

use App\Http\Controllers\Controller;
use App\Models\Juego;
use Illuminate\Http\Request;

class JuegosController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $juegos = Juego::doesnthave('campania')->get();
        return view('admin.juegos', ['juegos' => $juegos]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $juego = Juego::find($id);
        return view('admin.juego', ['juego' => $juego]);
    }

    public function ban($id, Request $request)
    {
        Juego::find($id)->update([
            'ban' => true,
            'motivo' => $request->motivo,
        ]);

        return $request->motivo;
    }

    public function unban($id)
    {
        Juego::find($id)->update([
            'ban' => false,
            'motivo' => null,
        ]);

        return "El juego ya no está baneado";
    }
}
