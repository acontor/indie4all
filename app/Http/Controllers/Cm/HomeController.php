<?php

namespace App\Http\Controllers\Cm;

use App\Http\Controllers\Controller;
use App\Models\Campania;
use App\Models\Encuesta;
use App\Models\Juego;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('cm');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $encuestasList = Encuesta::where('desarrolladora_id', Auth::user()->cm->desarrolladora->id)->get();
        $juegosList = Juego::where('desarrolladora_id', Auth::user()->cm->desarrolladora->id)->doesntHave('campania')->get();
        $campaniasList = Juego::where('desarrolladora_id', Auth::user()->cm->desarrolladora->id)->has('campania')->get();

        $juegos = [];
        $campanias = [];
        $encuestas = [];
        $datosVentas = [];
        $datosEncuestas = [];
        $datosCampania = [];

        foreach ($juegosList as $juego) {
            array_push($juegos, $juego->nombre);
            array_push($datosVentas, $juego->compras->count());
        }
        foreach ($campaniasList as $juego) {
            array_push($campanias, $juego->nombre);
            array_push($datosCampania, $juego->campania->compras->count());
        }
        foreach ($encuestasList as $encuesta) {
            array_push($encuestas, $encuesta->pregunta);
            $participantes = 0;
            foreach ($encuesta->opciones as $opcion) {
                $participantes += $opcion->participantes->count();
            }
            array_push($datosEncuestas, $participantes);
        }
        return view('cm.home', ['juegos' => $juegos, 'datosVentas' => $datosVentas, 'encuestas' => $encuestas, 'datosEncuestas' => $datosEncuestas, 'campanias' => $campanias, 'datosCampania' => $datosCampania]);
    }
}
