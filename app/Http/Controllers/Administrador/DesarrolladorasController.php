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
     * Muestra el listado de todas las desarrolladoras.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $desarrolladoras = Desarrolladora::all();
        $numSolicitudes = Solicitud::where('tipo', 'Desarrolladora')->count();

        return view('admin.desarrolladoras', ['desarrolladoras' => $desarrolladoras, 'numSolicitudes' => $numSolicitudes]);
    }

    /**
     * Banea una desarrolladora.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return String
     */
    public function ban($id, Request $request)
    {
        $desarrolladora = Desarrolladora::find($id);

        $desarrolladora->update([
            'ban' => true,
            'motivo' => $request->motivo,
        ]);

        return 'La desarrolladora ' . $desarrolladora->nombre . ' ha sido baneada';
    }

    /**
     * Elimina el ban a una desarrolladora.
     *
     * @param  int  $id
     * @return String
     */
    public function unban($id)
    {
        $desarrolladora = Desarrolladora::find($id);

        $desarrolladora->update([
            'ban' => false,
            'motivo' => null,
            'reportes' => $desarrolladora->reportes + 1,
        ]);

        return 'La desarrolladora ' . $desarrolladora->nombre . ' ya no está baneada';
    }
}
