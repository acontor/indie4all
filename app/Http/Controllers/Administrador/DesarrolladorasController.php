<?php

namespace App\Http\Controllers\Administrador;

use App\Http\Controllers\Controller;
use App\Models\Desarrolladora;
use App\Models\Solicitud;

class DesarrolladorasController extends Controller
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
        $desarrolladoras = Desarrolladora::all();
        $numSolicitudes = Solicitud::where('tipo', 'Desarrolladora')->count();
        return view('admin.desarrolladoras', ['desarrolladoras' => $desarrolladoras, 'numSolicitudes' => $numSolicitudes]);
    }
}
