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
        return view('admin.home', ['numUsuarios' => $numUsuarios, 'numJuegos' => $numJuegos, 'numDesarrolladoras' => $numDesarrolladoras, 'numSolicitudes' => $numSolicitudes]);
    }
}
