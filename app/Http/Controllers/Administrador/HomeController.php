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
        $numJuegos = Juego::doesntHave('campania')->count();
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
        $reportes = DB::table('reportes')->select('desarrolladora_id')->where('desarrolladora_id', '!=', null)->where('deleted_at', null)->groupBy('desarrolladora_id')->havingRaw('COUNT(*) >= 3')->get()->count() + DB::table('reportes')->select('post_id')->where('post_id', '!=', null)->where('deleted_at', null)->groupBy('post_id')->havingRaw('COUNT(*) >= 3')->get()->count() + DB::table('reportes')->select('mensaje_id')->where('mensaje_id', '!=', null)->where('deleted_at', null)->groupBy('mensaje_id')->havingRaw('COUNT(*) >= 3')->get()->count() + DB::table('reportes')->select('juego_id')->where('juego_id', '!=', null)->where('deleted_at', null)->groupBy('juego_id')->havingRaw('COUNT(*) >= 3')->get()->count() + DB::table('reportes')->select('campania_id')->where('campania_id', '!=', null)->where('deleted_at', null)->groupBy('campania_id')->havingRaw('COUNT(*) >= 3')->get()->count() + DB::table('reportes')->select('master_id')->where('master_id', '!=', null)->where('deleted_at', null)->groupBy('master_id')->havingRaw('COUNT(*) >= 3')->get()->count();
        if ($solicitudes > 0) {
            session()->flash('solicitudes', 'Hay pendientes ' . $solicitudes . ' solicitudes');
        }
        if ($reportes > 0) {
            session()->flash('reportes', 'Hay pendientes ' . $reportes . ' reportes');
        }

        return view('admin.home', ['numUsuarios' => $numUsuarios, 'numJuegos' => $numJuegos, 'numCampanias' => $numCampanias, 'numGeneros' => $numGeneros, 'numLogros' => $numLogros, 'numDesarrolladoras' => $numDesarrolladoras, 'numPosts' => $arrayPosts, 'numMensajes' => $arrayMensajes]);
    }
}
