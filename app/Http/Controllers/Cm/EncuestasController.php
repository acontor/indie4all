<?php

namespace App\Http\Controllers\Cm;

use App\Http\Controllers\Controller;
use App\Models\Cm;
use App\Models\Encuesta;
use App\Models\Opcion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class EncuestasController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('cm');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $encuestas = Encuesta::where('desarrolladora_id', Cm::where('user_id', Auth::id())->first()->desarrolladora_id)->get();
        return view('cm.encuestas', ['encuestas' => $encuestas]);
    }

    public function create()
    {
        return view('cm.encuestas_crear');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'pregunta' => 'required',
            'fecha_fin' => 'required',
        ]);

        $encuesta = Encuesta::create([
            'pregunta' => $request->pregunta,
            'fecha_fin' => $request->fecha_fin,
            'desarrolladora_id' => Cm::where('user_id', Auth::id())->first()->desarrolladora_id,
        ]);

        $id_encuesta = $encuesta->id;

        $num_opciones = count($request->all()) - 2;

        for ($i = 1; $i < $num_opciones; $i++) {
            $num_opcion = "opcion" . $i;
            $opcion = $request->$num_opcion;
            Opcion::create([
                'descripcion' => $opcion,
                'encuesta_id' => $id_encuesta,
            ]);
        }

        if ($encuesta->exists()) {
            session()->flash('success', 'La encuesta se ha creado.');
        } else {
            session()->flash('error', 'La encuesta no se ha podido crear. Si sigue fallando contacte con soporte@indie4all.com');
        }

        return redirect('/cm/encuestas');
    }

    public function destroy($id)
    {
        Opcion::where('encuesta_id', $id)->delete();

        $encuesta = Encuesta::find($id)->delete();

        $encuesta->delete();

        if (!$encuesta->exists()) {
            session()->flash('success', 'La encuesta se ha eliminado.');
        } else {
            session()->flash('error', 'La encuesta no se ha podido eliminar. Si sigue fallando contacte con soporte@indie4all.com');
        }

        return redirect('/cm/encuestas');
    }

    public function finish($id)
    {
        Encuesta::find($id)->update([
            'fin' => true
        ]);

        session()->flash('success', 'La encuesta ha finalizado');

        return redirect('/cm/encuestas');
    }
}
