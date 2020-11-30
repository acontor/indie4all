<?php

namespace App\Http\Controllers\Administrador;

use App\Http\Controllers\Controller;
use App\Models\Desarrolladora;
use App\Models\Juego;
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $numUsuarios = User::count();
        $numJuegos = Juego::count();
        $numDesarrolladoras = Desarrolladora::count();
        $numSolicitudes = Solicitud::count();

        $dia = Carbon::now();

        $arrayPosts = [];

        $numPosts = DB::table('posts')->select(DB::raw('*'))->whereRaw('date(created_at) = ?', [$dia->format('Y-m-d')])->count();

        array_unshift($arrayPosts, $numPosts);

        for ($i = 0; $i < 4; $i++) {

            $numPosts = DB::table('posts')->select(DB::raw('*'))->whereRaw('date(created_at) = ?', [$dia->subDay()->format('Y-m-d')])->count();

            array_unshift($arrayPosts, $numPosts);
        }

        $dia->addDays(4);

        $arrayMensajes = [];

        $numMensajes = DB::table('mensajes')->select(DB::raw('*'))->whereRaw('date(created_at) = ?', [$dia->format('Y-m-d')])->count();

        array_unshift($arrayMensajes, $numMensajes);

        for ($i = 0; $i < 4; $i++) {

            $numMensajes = DB::table('mensajes')->select(DB::raw('*'))->whereRaw('date(created_at) = ?', [$dia->subDay()->format('Y-m-d')])->count();

            array_unshift($arrayMensajes, $numMensajes);
        }

        return view('admin.home', ['numUsuarios' => $numUsuarios, 'numJuegos' => $numJuegos, 'numDesarrolladoras' => $numDesarrolladoras, 'numSolicitudes' => $numSolicitudes, 'numPosts' => $arrayPosts, 'numMensajes' => $arrayMensajes]);
    }
}
