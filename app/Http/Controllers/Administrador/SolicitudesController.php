<?php

namespace App\Http\Controllers\Administrador;

use App\Http\Controllers\Controller;
use App\Models\Desarrolladora;
use App\Models\Solicitud;
use Illuminate\Http\Request;

class SolicitudesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $desarrolladoras = Solicitud::where('tipo', 'Desarrolladora')->paginate(4);
        $masters = Solicitud::where('tipo', 'Master')->paginate(4);
        return view('admin.solicitudes', compact('desarrolladoras', 'masters'));
    }
}
