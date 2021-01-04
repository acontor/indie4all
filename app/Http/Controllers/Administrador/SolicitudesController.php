<?php

namespace App\Http\Controllers\Administrador;

use App\Http\Controllers\Controller;
use App\Mail\Solicitudes\AceptarSolicitud;
use App\Mail\Solicitudes\RechazarSolicitud;
use App\Models\Desarrolladora;
use App\Models\Cm;
use App\Models\Master;
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
        if (Solicitud::count() == 0) {
            return redirect('admin.index');
        }
    }

    /**
     * Muestra todas las solicitudes.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Solicitud::count() == 0) {
            return redirect('/admin');
        }
        $desarrolladoras = Solicitud::where('tipo', 'Desarrolladora')->get();
        $masters = Solicitud::where('tipo', 'Master')->get();
        return view('admin.solicitudes', ['desarrolladoras' => $desarrolladoras, 'masters' => $masters]);
    }

    /**
     * Aceptar solicitud de nueva desarrolladora.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Array
     */
    public function aceptarDesarrolladora(Request $request)
    {
        $solicitud = Solicitud::find($request->id);

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

        $solicitud->forceDelete();

        $user = User::find($solicitud->user_id);
        $url = env('APP_URL') . '/cm';
        $admin = Auth::user()->name;
        Mail::to($user->email)->send(new AceptarSolicitud($url, $user->name, $admin));

        if ($desarrolladora->exists) {
            return array('estado' => 'success', 'mensaje' => 'La solicitud ha sido aceptada');
        } else {
            return array('estado' => 'error', 'mensaje' => 'La solicitud no ha podido ser aceptada');
        }
    }

    /**
     * Rechazar solicitud de nueva desarrolladora.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Array
     */
    public function rechazarDesarrolladora(Request $request)
    {
        $request->validate([
            'motivo' => ['required'],
        ]);

        $solicitud = Solicitud::find($request->id);

        $user = User::find($solicitud->user_id);
        $motivo = $request->motivo;
        $admin = Auth::user()->name;
        Mail::to($user->email)->send(new RechazarSolicitud($motivo, $user->name, $admin));

        $solicitud->delete();

        if ($solicitud->deleted_at == null) {
            return array('estado' => 'error', 'mensaje' => 'La solicitud no ha podido ser rechazada');
        } else {
            return array('estado' => 'success', 'mensaje' => 'La solicitud ha sido rechazada');
        }
    }

    /**
     * Aceptar solicitud de nuevo master.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Array
     */
    public function aceptarMaster(Request $request)
    {
        $solicitud = Solicitud::find($request->id);

        $master = Master::create([
            'nombre' => $solicitud->nombre,
            'email' => $solicitud->email,
        ]);

        $solicitud->forceDelete();

        $user = User::find($solicitud->user_id);
        $url = env('APP_URL') . '/master';
        $admin = Auth::user()->name;
        Mail::to($user->email)->send(new AceptarSolicitud($url, $user->name, $admin));

        if ($master->exists) {
            return array('estado' => 'success', 'mensaje' => 'La solicitud ha sido aceptada');
        } else {
            return array('estado' => 'error', 'mensaje' => 'La solicitud no ha podido ser aceptada');
        }
    }

    /**
     * Rechazar solicitud de nuevo master.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Array
     */
    public function rechazarMaster(Request $request)
    {
        $request->validate([
            'motivo' => ['required'],
        ]);

        $solicitud = Solicitud::find($request->id);

        $user = User::find($solicitud->user_id);
        $motivo = $request->motivo;
        $admin = Auth::user()->name;
        Mail::to($user->email)->send(new RechazarSolicitud($motivo, $user->name, $admin));

        $solicitud->delete();

        if ($solicitud->deleted_at == null) {
            return array('estado' => 'error', 'mensaje' => 'La solicitud no ha podido ser rechazada');
        } else {
            return array('estado' => 'success', 'mensaje' => 'La solicitud ha sido rechazada');
        }
    }
}
