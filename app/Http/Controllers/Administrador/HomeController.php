<?php

namespace App\Http\Controllers\Administrador;

use App\Http\Controllers\Controller;
use App\Models\Campania;
use App\Models\Desarrolladora;
use App\Models\Genero;
use App\Models\Juego;
use App\Models\Logro;
use App\Models\Reporte;
use App\Models\Solicitud;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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
        $this->middleware('admin');
    }

    /**
     * Muestra datos interesantes de la plataforma.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $numUsuarios = User::count();
        $numJuegos = Juego::count();
        $numDesarrolladoras = Desarrolladora::count();
        $numCampanias = Campania::count();
        $numGeneros = Genero::count();
        $numLogros = Logro::count();

        // Número de posts últimos 5 días
        $dia = Carbon::now();

        $arrayPosts = [];
        $numPosts = DB::table('posts')->select(DB::raw('*'))->whereRaw('date(created_at) = ?', [$dia->format('Y-m-d')])->count();
        array_unshift($arrayPosts, $numPosts);
        for ($i = 0; $i < 4; $i++) {
            $numPosts = DB::table('posts')->select(DB::raw('*'))->whereRaw('date(created_at) = ?', [$dia->subDay()->format('Y-m-d')])->count();
            array_unshift($arrayPosts, $numPosts);
        }

        $dia->addDays(4);

        // Número de mensajes últimos 5 días
        $arrayMensajes = [];
        $numMensajes = DB::table('mensajes')->select(DB::raw('*'))->whereRaw('date(created_at) = ?', [$dia->format('Y-m-d')])->count();
        array_unshift($arrayMensajes, $numMensajes);
        for ($i = 0; $i < 4; $i++) {
            $numMensajes = DB::table('mensajes')->select(DB::raw('*'))->whereRaw('date(created_at) = ?', [$dia->subDay()->format('Y-m-d')])->count();
            array_unshift($arrayMensajes, $numMensajes);
        }

        // Notificación de solicitudes y reportes
        $solicitudes = Solicitud::count();
        $reportes = Reporte::all()->groupBy('campania_id', 'desarrolladora_id', 'juego_id', 'master_id', 'mensaje_id', 'post_id')->count();

        if ($solicitudes > 0) {
            session()->flash('solicitudes', 'Hay pendientes ' . $solicitudes . ' solicitudes');
        }
        if ($reportes > 0) {
            session()->flash('reportes', 'Hay pendientes ' . $reportes . ' reportes');
        }

        return view('admin.home', ['numUsuarios' => $numUsuarios, 'numJuegos' => $numJuegos, 'numCampanias' => $numCampanias, 'numGeneros' => $numGeneros, 'numLogros' => $numLogros, 'numDesarrolladoras' => $numDesarrolladoras, 'numPosts' => $arrayPosts, 'numMensajes' => $arrayMensajes]);
    }
}
