<?php

namespace App\Http\Controllers\Administrador;

use App\Http\Controllers\Controller;
use App\Mail\Solicitudes\AceptarSolicitud;
use App\Mail\Solicitudes\RechazarSolicitud;
use App\Models\Desarrolladora;
use App\Models\Cm;
use App\Models\Solicitud;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class SolicitudesController extends Controller
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
        $desarrolladoras = Solicitud::where('tipo', 'Desarrolladora')->get();
        $masters = Solicitud::where('tipo', 'Master')->get();
        return view('admin.solicitudes', ['desarrolladoras' => $desarrolladoras, 'masters' => $masters]);
    }

    /**
     * Aceptar solicitud de nueva desarrolladora
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @param  int  $cm
     * @return \Illuminate\Http\Response
     */
    public function aceptarDesarrolladora($id)
    {
        $solicitud = Solicitud::find($id);

        $desarrolladora = Desarrolladora::create([
            'nombre' => $solicitud->nombre,
            'email' => $solicitud->email,
            'direccion' => $solicitud->direccion,
            'telefono' => $solicitud->telefono,
            'url' => $solicitud->url,
        ]);

        Cm::create([
            'desarrolladora_id' => $desarrolladora->id,
            'user_id' => $solicitud->user_id
        ]);

        Solicitud::find($id)->delete();

        $user = User::find($solicitud->user_id);

        $url = env('APP_URL') . '/cm';

        $admin = Auth::user()->name;

        Mail::to($user->email)->send(new AceptarSolicitud($url, $user->name, $admin));

        return redirect('/admin/solicitudes')->with('success', '¡Solicitud aceptada!');
    }

    /**
     * Rechazar solicitud de nueva desarrolladora
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function rechazarDesarrolladora(Request $request)
    {
        $solicitud = Solicitud::find($request->id);

        $user = User::find($solicitud->user_id);

        $motivo = $request->motivo;

        $admin = Auth::user()->name;

        Mail::to($user->email)->send(new RechazarSolicitud($motivo, $user->name, $admin));

        $solicitud->delete();
    }
}
