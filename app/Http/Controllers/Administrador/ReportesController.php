<?php

namespace App\Http\Controllers\Administrador;

use App\Http\Controllers\Controller;
use App\Models\Reporte;

class ReportesController extends Controller
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
        $desarrolladoras = Reporte::select('desarrolladora_id')
            ->where('desarrolladora_id', '!=', null)
            ->groupBy('desarrolladora_id')
            ->havingRaw('COUNT(*) >= 3')
            ->get();
        $posts = Reporte::select('post_id')
            ->where('post_id', '!=', null)
            ->groupBy('post_id')
            ->havingRaw('COUNT(*) >= 3')
            ->get();
        $mensajes = Reporte::select('mensaje_id')
            ->where('mensaje_id', '!=', null)
            ->groupBy('mensaje_id')
            ->havingRaw('COUNT(*) >= 3')
            ->get();
        $juegos = Reporte::select('juego_id')
            ->where('juego_id', '!=', null)
            ->groupBy('juego_id')
            ->havingRaw('COUNT(*) >= 3')
            ->get();
        $campanias = Reporte::select('campania_id')
            ->where('campania_id', '!=', null)
            ->groupBy('campania_id')
            ->havingRaw('COUNT(*) >= 3')
            ->get();
        $sorteos = Reporte::select('sorteo_id')
            ->where('sorteo_id', '!=', null)
            ->groupBy('sorteo_id')
            ->havingRaw('COUNT(*) >= 3')
            ->get();
        $encuestas = Reporte::select('encuesta_id')
            ->where('encuesta_id', '!=', null)
            ->groupBy('encuesta_id')
            ->havingRaw('COUNT(*) >= 3')
            ->get();
        $masters = Reporte::select('master_id')
            ->where('master_id', '!=', null)
            ->groupBy('master_id')
            ->havingRaw('COUNT(*) >= 3')
            ->get();
        $reportes = Reporte::all();
        return view('admin.reportes', ['desarrolladoras' => $desarrolladoras, 'posts' => $posts, 'mensajes' => $mensajes, 'juegos' => $juegos, 'campanias' => $campanias, 'reportes' => $reportes, 'sorteos' => $sorteos, 'encuestas' => $encuestas, 'masters' => $masters]);
    }
}

// DESARROLLADORA, MASTER Y USUARIOS (EN CASO DE LOS MENSAJES) SE LE SUMA 1 REPORTE A SU CUENTA
// POSTS Y MENSAJES SE BORRAN
// DESARROLLADORA, MASTER, USUARIOS, SORTEOS Y ENCUESTAS SOFT DELETE
