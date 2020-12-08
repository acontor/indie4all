<?php

namespace App\Http\Controllers\Administrador;

use App\Http\Controllers\Controller;
use App\Models\Campania;
use App\Models\Desarrolladora;
use App\Models\Cm;
use App\Models\Juego;
use App\Models\Master;
use App\Models\Mensaje;
use App\Models\Post;
use App\Models\Solicitud;
use App\Models\User;

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
        $desarrolladoras = Desarrolladora::where('reportes', '>=', 3)->get();
        $posts = Post::where('reportes', '>=', 3)->get();
        $mensajes = Mensaje::where('reportes', '>=', 3)->get();
        $juegos = Juego::where('reportes', '>=', 3)->get();
        $campanias = Campania::where('reportes', '>=', 3)->get();
        $usuarios = User::where('reportes', '>=', 3)->get();
        return view('admin.reportes', ['desarrolladoras' => $desarrolladoras, 'posts' => $posts, 'mensajes' => $mensajes, 'juegos' => $juegos, 'campanias' => $campanias, 'usuarios' => $usuarios]);
    }
}
