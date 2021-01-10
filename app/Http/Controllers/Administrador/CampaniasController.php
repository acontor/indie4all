<?php

namespace App\Http\Controllers\Administrador;

use App\Http\Controllers\Controller;
use App\Models\Campania;
use App\Models\Juego;
use Illuminate\Http\Request;

class CampaniasController extends Controller
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
     * Muestra una vista con todas las campañas.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $juegos = Juego::has('campania')->get();

        return view('admin.campanias', ['juegos' => $juegos]);
    }

    /**
     * Desactiva una campaña.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return String
     */
    public function ban($id, Request $request)
    {
        $campania = Campania::find($id);

        $campania->update([
            'ban' => true,
            'motivo' => $request->motivo,
        ]);

        return 'La campaña de ' . $campania->juego->nombre . ' ha sido desactivada';
    }

    /**
     * Activa una campaña.
     *
     * @param  int  $id
     * @return String
     */
    public function unban($id)
    {
        $campania = Campania::find($id);

        $campania->update([
            'ban' => false,
            'motivo' => null,
        ]);

        return 'La campaña de ' . $campania->juego->nombre . ' ha vuelto a activarse';
    }
}
