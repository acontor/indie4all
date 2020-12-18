<?php

namespace App\Http\Controllers\Administrador;

use App\Http\Controllers\Controller;
use App\Models\Desarrolladora;
use App\Models\Solicitud;
use Illuminate\Http\Request;

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

    public function ban($id, Request $request)
    {

        Desarrolladora::find($id)->update([
            'ban' => true,
            'motivo' => $request->motivo,
        ]);

        return $request->motivo;
    }

    public function unban($id)
    {
        Desarrolladora::find($id)->update([
            'ban' => false,
            'motivo' => null,
        ]);

        return "La desarrolladora ya no está baneado";
    }
}
