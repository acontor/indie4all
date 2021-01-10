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
     * Muestra el listado de todos los juegos.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $juegos = Juego::doesnthave('campania')->get();

        return view('admin.juegos', ['juegos' => $juegos]);
    }

    /**
     * Muestra el juego seleccionado.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $juego = Juego::find($id);

        return view('admin.juego', ['juego' => $juego]);
    }

    /**
     * Banea un juego.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return String
     */
    public function ban($id, Request $request)
    {
        $juego = Juego::find($id);

        $juego->update([
            'ban' => true,
            'motivo' => $request->motivo,
        ]);

        return 'El juego ' . $juego->nombre . ' ha sido baneado';
    }

    /**
     * Elimina el ban a un juego.
     *
     * @param  int  $id
     * @return String
     */
    public function unban($id)
    {
        $juego = Juego::find($id);

        $juego->update([
            'ban' => false,
            'motivo' => null,
            'reportes' => $juego->reportes + 1,
        ]);

        return 'El juego ' . $juego->nombre . ' ya no está baneado';
    }
}
