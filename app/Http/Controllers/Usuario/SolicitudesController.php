<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use App\Models\Solicitud;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SolicitudesController extends Controller
{
    /**
     * Muestra la vista para realizar una solicitud.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('usuario.solicitud');
    }

    /**
     * Crear una solicitud.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => ['required', 'unique:' . strtolower($request->tipo) . 's', 'max:255'],
            'email' => ['required', 'max:255'],
            'direccion' => ['max:255'],
            'telefono' => ['digits:9', 'nullable', 'numeric'],
            'url' => ['max:255', 'nullable', 'url'],
            'comentario' => ['required'],
        ]);

        $solicitud = Solicitud::create([
            'nombre' => $request->nombre,
            'email' => $request->email,
            'direccion' => $request->direccion,
            'telefono' => $request->telefono,
            'url' => $request->url,
            'comentario' => $request->comentario,
            'tipo' => $request->tipo,
            'user_id' => Auth::id(),
        ]);

        if ($solicitud->exists) {
            session()->flash('success', 'Será procesada en un plazo de 24/48 horas.');
        } else {
            session()->flash('error', 'Su solicitud ha fallado. En caso de que sigua fallando, contacte con soporte@indie4all.com');
        }

        return redirect('/' . strtolower($request->tipo) . '/solicitud');
    }
}
