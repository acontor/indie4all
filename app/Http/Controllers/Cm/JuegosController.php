<?php

namespace App\Http\Controllers\Cm;

use App\Http\Controllers\Controller;
use App\Imports\ClavesImport;
use App\Models\Cm;
use App\Models\Desarrolladora;
use App\Models\Genero;
use App\Models\Juego;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

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
        $juegos = Desarrolladora::find(Cm::where('user_id', Auth::id())->first()->desarrolladora_id)->juegos()->get();
        return view('cm.juegos', ['juegos' => $juegos]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $juego = Juego::find($id);
        $generos = Genero::All();
        return view('cm.juego', ['juego' => $juego, 'generos' => $generos]);
    }

    public function create()
    {
        $generos = Genero::all();
        return view('cm.juego', ['generos' => $generos]);
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
        }

        if ($caratula = $request->file('imagen_caratula')) {
            $originNameCaratula = $request->file('imagen_caratula')->getClientOriginalName();
            $fileNameCaratula = pathinfo($originNameCaratula, PATHINFO_FILENAME);
            $extensionCaratula = $request->file('imagen_caratula')->getClientOriginalExtension();
            $fileNameCaratula = $fileNameCaratula . '_' . time() . '.' . $extensionCaratula;
            $caratula->move('images/juegos/caratulas/', $fileNameCaratula);
        }

        Juego::create([
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

        return redirect('/cm/juegos')->with('success', 'Juego creado!');
    }

    public function update(Request $request, $id)
    {
        $juego = Juego::find($id);
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

        $portada = public_path() . '/images/juegos/portadas/' . $juego->imagen_portada;
        $caratula = public_path() . '/images/juegos/caratulas/' . $juego->imagen_caratula;
        if (@getimagesize($portada) && @getimagesize($caratula)) {
            unlink($portada);
            unlink($caratula);
        }
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

        Juego::find($id)->update([
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

        return redirect('/cm/juegos')->with('success', 'Juego actualizado!');
    }

    public function destroy($id)
    {
        $juego = Juego::find($id);
        $portada = public_path() . '/images/juegos/portadas/' . $juego->imagen_portada;
        $caratula = public_path() . '/images/juegos/caratulas/' . $juego->imagen_caratula;
        if (@getimagesize($portada) && @getimagesize($caratula)) {
            unlink($portada);
            unlink($caratula);
        }
        Juego::find($id)->delete();

        return redirect('/cm/juegos')->with('success', '¡Juego borrado!');
    }

    public function importar(Request $request)
    {
        Excel::import(new ClavesImport($request->juego), $request->file('csv'));

        $juego = Juego::find($request->juego);

        return view('cm.juego', ['juego' => $juego]);
    }

    public function fileImportExport()
    {
        return view('cm.claves');
    }
}
