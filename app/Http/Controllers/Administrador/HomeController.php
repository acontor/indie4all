<?php

namespace App\Http\Controllers\Administrador;

use App\Http\Controllers\Controller;
use App\Mail\Actualizaciones\CorreoDiario;
use App\Models\Campania;
use App\Models\Desarrolladora;
use App\Models\Genero;
use App\Models\Juego;
use App\Models\Logro;
use App\Models\Post;
use App\Models\Solicitud;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

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

    public function actualizacionDiaria()
    {
        $usuario = User::find(1);

        $juegos = $usuario->select('juego_user.juego_id as id')
            ->join('juego_user', 'users.id', 'juego_user.user_id')
            ->where('juego_user.notificacion', 1)
            ->where('juego_user.user_id', $usuario->id)
            ->get();

        $juegos_id = [];

        foreach ($juegos as $juego) {
            array_push($juegos_id, $juego->id);
        }

        $estrenos = Juego::whereIn('id', $juegos_id)
            ->whereDate('fecha_lanzamiento', '=', date('Y-m-d'))
            ->get();

        $desarrolladoras = $usuario->select('desarrolladora_user.desarrolladora_id as id')
            ->join('desarrolladora_user', 'users.id', 'desarrolladora_user.user_id')
            ->where('desarrolladora_user.notificacion', 1)
            ->where('desarrolladora_user.user_id', $usuario->id)
            ->get();

        $desarrolladoras_id = [];

        foreach ($desarrolladoras as $desarrolladora) {
            array_push($desarrolladoras_id, $desarrolladora->id);
        }

        $masters = $usuario->select('master_user.master_id as id')
            ->join('master_user', 'users.id', 'master_user.user_id')
            ->where('master_user.notificacion', 1)
            ->where('master_user.user_id', $usuario->id)
            ->get();

        $masters_id = [];

        foreach ($masters as $master) {
            array_push($masters_id, $master->id);
        }

        $postsJuegos = Post::whereDate('created_at', '=', date('Y-m-d'))
            ->whereIn('juego_id', $juegos_id)
            ->where('master_id', null)
            ->withCount('comentarios')
            ->orderByDesc('comentarios_count')
            ->get();

        $postsDesarrolladoras = Post::whereDate('created_at', '=', date('Y-m-d'))
            ->whereIn('desarrolladora_id', $desarrolladoras_id)
            ->withCount('comentarios')
            ->orderByDesc('comentarios_count')
            ->get();

        $postsMasters = Post::whereDate('created_at', '=', date('Y-m-d'))
            ->whereIn('master_id', $masters_id)
            ->where('juego_id', '!=', null)
            ->withCount('comentarios')
            ->orderByDesc('comentarios_count')
            ->get();

        if ($postsJuegos->count() + $postsDesarrolladoras->count() + $postsMasters->count() > 0 + $estrenos->count()) {
            Mail::to($usuario->email)->send(new CorreoDiario($usuario->name, $postsJuegos, $postsDesarrolladoras, $postsMasters, $estrenos));
        }

        session()->flash('success', 'Resumen diario enviado');

        return redirect('/admin');
    }
}
