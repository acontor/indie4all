<?php

namespace App\Http\Controllers\Administrador;

use App\Http\Controllers\Controller;
use App\Models\Desarrolladora;
use App\Models\Juego;
use App\Models\Solicitud;
use App\Models\User;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $num_usuarios = User::count();
        $num_juegos = Juego::count();
        $num_desarrolladoras = Desarrolladora::count();
        $num_solicitudes = Solicitud::count();
        return view('admin.home', compact('num_usuarios', 'num_juegos', 'num_desarrolladoras', 'num_solicitudes'));
    }
}
