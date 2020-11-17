<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use App\Models\Genero;
use App\Models\Logro;
use App\Models\User;

class CuentaController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usuario = User::find(Auth()->id());
        $logros = Logro::all();
        $generos = Genero::all();
        return view('usuario.cuenta', ['usuario' => $usuario, 'logros' => $logros, 'generos' => $generos]);
    }
}
