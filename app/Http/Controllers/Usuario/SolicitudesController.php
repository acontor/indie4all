<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use App\Listeners\FollowListener;
use App\Mail\Sorteos\SorteoConfirmacion;
use App\Models\Desarrolladora;
use App\Models\Post;
use App\Models\Solicitud;
use App\Models\Sorteo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class SolicitudesController extends Controller
{
    /**
     * Muestra la vista para realizar una solicitud de tipo Desarrolladora.
     *
     * @return \Illuminate\Http\Response
     */
    public function createDesarrolladora()
    {
        return view('usuario.solicitud_desarrolladora');
    }

    /**
     * Crear una solicitud de tipo Desarrolladora.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeDesarrolladora(Request $request)
    {
        $request->validate([
            'nombre' => ['required', 'unique:solicituds', 'unique:desarrolladoras', 'max:255'],
            'email' => ['required', 'max:255'],
            'direccion' => ['max:255'],
            'telefono' => ['digits:9', 'nullable', 'numeric'],
            'url' => ['max:255', 'nullable', 'url'],
        ]);

        $solicitud = Solicitud::create([
            'nombre' => $request->nombre,
            'email' => $request->email,
            'direccion' => $request->direccion,
            'telefono' => $request->telefono,
            'url' => $request->url,
            'comentario' => $request->comentario,
            'tipo' => 'Desarrolladora',
            'user_id' => Auth::id(),
        ]);

        if ($solicitud->exists) {
            session()->flash('success', 'Será procesada en un plazo de 24/48 horas.');
        } else {
            session()->flash('error', 'Su solicitud ha fallado. En caso de que sigua fallando, contacte con soporte@indie4all.com');
        }

        return redirect('/desarrolladora');
    }
}
