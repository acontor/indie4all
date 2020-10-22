<?php

namespace App\Http\Controllers\Administrador;

use App\Http\Controllers\Controller;
use App\Models\Desarrolladora;
use App\Models\Solicitud;
use Illuminate\Http\Request;

class DesarrolladorasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $desarrolladoras = Desarrolladora::paginate(10);
        $solicitudes = Solicitud::where('tipo', 'Desarrolladora')->paginate(4);
        return view('admin.desarrolladoras', compact('desarrolladoras', 'solicitudes'));
    }
}
