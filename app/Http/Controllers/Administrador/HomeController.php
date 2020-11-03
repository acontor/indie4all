<?php

namespace App\Http\Controllers\Administrador;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Juego;
use App\Models\Desarrolladora;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $num_usuarios = User::all()->count();
        $num_juegos = Juego::all()->count();
        $num_desarrolladoras = Desarrolladora::all()->count();
        return view('admin.home', compact('num_usuarios', 'num_juegos', 'num_desarrolladoras'));
    }
}
