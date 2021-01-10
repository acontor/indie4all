<?php

namespace App\Http\Controllers\Administrador;

use App\Http\Controllers\Controller;
use App\Models\Reporte;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportesController extends Controller
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
     * Muestra todos los reportes.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $desarrolladoras = Reporte::select('desarrolladora_id')
            ->where('desarrolladora_id', '!=', null)
            ->groupBy('desarrolladora_id')
            ->havingRaw('COUNT(*) >= 3')
            ->get();
        $posts = Reporte::select('post_id')
            ->where('post_id', '!=', null)
            ->groupBy('post_id')
            ->havingRaw('COUNT(*) >= 3')
            ->get();
        $mensajes = Reporte::select('mensaje_id')
            ->where('mensaje_id', '!=', null)
            ->groupBy('mensaje_id')
            ->havingRaw('COUNT(*) >= 3')
            ->get();
        $juegos = Reporte::select('juego_id')
            ->where('juego_id', '!=', null)
            ->groupBy('juego_id')
            ->havingRaw('COUNT(*) >= 3')
            ->get();
        $campanias = Reporte::select('campania_id')
            ->where('campania_id', '!=', null)
            ->groupBy('campania_id')
            ->havingRaw('COUNT(*) >= 3')
            ->get();
        $masters = Reporte::select('master_id')
            ->where('master_id', '!=', null)
            ->groupBy('master_id')
            ->havingRaw('COUNT(*) >= 3')
            ->get();
        $reportes = Reporte::all();

        return view('admin.reportes', ['desarrolladoras' => $desarrolladoras, 'posts' => $posts, 'mensajes' => $mensajes, 'juegos' => $juegos, 'campanias' => $campanias, 'reportes' => $reportes, 'masters' => $masters]);
    }

    /**
     *  Muestra un reporte.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $reportes = Reporte::join('users', 'users.id', 'reportes.user_id')->select('users.email', 'reportes.motivo')->where($request->tipo, $request->id)->get();

        return $reportes;
    }

    /**
     *  Acepta un reporte.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function aceptar(Request $request)
    {
        if($request->tabla == 'mensajes') {
            DB::table($request->tabla)->where('id', $request->id)->delete();
        } else {
            DB::table($request->tabla)->where('id', $request->id)->update([
                'ban' => 1,
                'Motivo' => 'Has sido reportado. Para más información envíe un mensaje a soporte@indie4all.com'
            ]);
        }

        Reporte::where($request->tipo, $request->id)->delete();

        return 'El reporte ha sido aceptado';
    }

    /**
     *  Rechaza un reporte.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function cancelar(Request $request)
    {
        Reporte::where($request->tipo, $request->id)->delete();

        return 'El reporte ha sido rechazado';
    }
}
