<?php

namespace App\Http\Controllers\Cm;

use App\Http\Controllers\Controller;
use App\Models\Cm;
use App\Models\Desarrolladora;
use App\Models\Campania;
use App\Models\Genero;
use App\Models\Juego;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CampaniasController extends Controller
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
        $juegos = Desarrolladora::find(Cm::where('user_id', Auth::id())->first()->desarrolladora_id)->juegos()->has('campania')->get();
        return view('cm.campanias', ['juegos' => $juegos]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $campania = Campania::find($id);
        $generos = Genero::All();
        return view('cm.campania', ['campania' => $campania, 'generos' => $generos]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'meta' => 'required',
            'fecha_fin' => 'required',
            'nombre' => 'required',
            'sinopsis' => 'required',
            'imagen_portada' => 'required',
            'imagen_caratula' => 'required',
            'sinopsis' => 'required',
            'fecha_lanzamiento' => 'required',
            'precio' => 'required',
            'genero_id' => 'required',
        ]);

        if ($portada = $request->file('imagen_portada')) {
            $originNamePortada = $request->file('imagen_portada')->getClientOriginalName();
            $fileNamePortada = pathinfo($originNamePortada, PATHINFO_FILENAME);
            $extensionPortada = $request->file('imagen_portada')->getClientOriginalExtension();
            $fileNamePortada = $fileNamePortada . '_' . time() . '.' . $extensionPortada;
            $portada->move('images/juegos/portadas/', $fileNamePortada);
        }

        if ($caratula = $request->file('imagen_caratula')) {
            $originNameCaratula = $request->file('imagen_caratula')->getClientOriginalName();
            $fileNameCaratula = pathinfo($originNameCaratula, PATHINFO_FILENAME);
            $extensionCaratula = $request->file('imagen_caratula')->getClientOriginalExtension();
            $fileNameCaratula = $fileNameCaratula . '_' . time() . '.' . $extensionCaratula;
            $caratula->move('images/juegos/caratulas/', $fileNameCaratula);
        }

        $juego = Juego::create([
            'nombre' => $request->nombre,
            'imagen_portada' => $fileNamePortada,
            'imagen_caratula' => $fileNameCaratula,
            'sinopsis' => $request->sinopsis,
            'fecha_lanzamiento' => $request->fecha_lanzamiento,
            'precio' => $request->precio,
            'desarrolladora_id' =>  Cm::where('user_id', Auth::id())->first()->desarrolladora_id,
            'genero_id' => $request->genero,
            'genero_id' => $request->genero_id,
        ]);

        Campania::create([
            'meta' => $request->meta,
            'resultado' => $request->imagen_portada,
            'fecha_fin' => $request->fecha_fin,
            'juego_id' => $juego->id,
        ]);

        return redirect('/cm/campanias')->with('success', '¡Campaña creada!');
    }

    public function edit($campaniaId, $juegoId)
    {
        $campania = Campania::find($campaniaId);
        $juego = Juego::find($juegoId);
        return view('cm.campanias_crear', ['campania' => $campania, 'juego' => $juego]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'meta' => 'required',
            'fecha_fin' => 'required',
        ]);

        Campania::find($id)->update($request->all());

        return redirect('/cm/campanias')->with('success', '¡Campaña actualizada!');
    }

    public function destroy($id)
    {
        Campania::find($id)->delete();
        return redirect('/cm/campanias')->with('success', '¡Campaña borrad!');
    }
}
