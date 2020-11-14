<?php

namespace App\Http\Controllers\Cm;

use App\Http\Controllers\Controller;
use App\Models\Cm;
use App\Models\Desarrolladora;
use App\Models\Genero;
use App\Models\Juego;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class JuegosController extends Controller
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
        $juegos = Desarrolladora::find(Cm::where('user_id', Auth::id())->first()->desarrolladora_id)->juegos()->paginate(6);
        return view('cm.juegos', ['juegos' => $juegos]);
    }
    public function create()
    {
        $generos = Genero::all();
        return view('cm.juegos_crear', ['generos' => $generos]);
    }

    public function store(Request $request)
    {
        $request->validate([
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
            $request['imagen_portada'] = $fileNamePortada;
        }
        if ($caratula = $request->file('imagen_caratula')) {
            $originNameCaratula = $request->file('imagen_caratula')->getClientOriginalName();
            $fileNameCaratula = pathinfo($originNameCaratula, PATHINFO_FILENAME);
            $extensionCaratula = $request->file('imagen_caratula')->getClientOriginalExtension();
            $fileNameCaratula = $fileNameCaratula . '_' . time() . '.' . $extensionCaratula;
            $caratula->move('images/juegos/caratulas/', $fileNameCaratula);
            $request['imagen_caratula'] = $fileNamePortada;
        }
        Juego::create([
            'nombre' => $request->nombre,
            'imagen_portada' => $request->imagen_portada,
            'imagen_caratula' => $request->imagen_caratula,
            'sinopsis' => $request->sinopsis,
            'fecha_lanzamiento' => $request->fecha_lanzamiento,
            'precio' => $request->precio,
            'desarrolladora_id' =>  Cm::where('user_id', Auth::id())->first()->desarrolladora_id,
            'genero_id' => $request->genero,
        ]);

        return redirect('/cm/juegos')->with('success', 'Juego creado!');
    }

    public function edit($id)
    {
        $juego = Juego::find($id);
        $generos = Genero::All();
        return view('cm.juegos_crear', ['juego' => $juego, 'generos' => $generos]);
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required',
            'sinopsis' => 'required',
            'imagen_portada' => 'required',
            'imagen_caratula' => 'required',
            'sinopsis' => 'required',
            'fecha_lanzamiento' => 'required',
            'precio' => 'required',
            'genero_id' => 'required',
        ]);

        Juego::find($id)->update($request->all());

        return redirect('/cm/juegos')->with('success', 'Juego actualizado!');
    }

    public function destroy($id)
    {
        Juego::find($id)->delete();
        return redirect('/cm/juegos')->with('success', '¡Juego borrado!');
    }
}
