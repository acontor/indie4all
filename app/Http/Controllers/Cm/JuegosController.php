<?php

namespace App\Http\Controllers\Cm;

use App\Http\Controllers\Controller;
use App\Imports\ClavesImport;
use App\Models\Clave;
use App\Models\Cm;
use App\Models\Desarrolladora;
use App\Models\Genero;
use App\Models\Juego;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $juegos = Desarrolladora::find(Cm::where('user_id', Auth::id())->first()->desarrolladora_id)->juegos()->doesntHave('campania')->orderByDesc('ban')->get();
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
            'nombre' => ['required', 'max:255'],
            'imagen_portada' => ['mimes:png', 'dimensions:width=1024,height=512'],
            'imagen_caratula' => ['mimes:png', 'dimensions:width=200,height=256'],
            'fecha_lanzamiento' => 'required',
            'precio' => 'required',
            'genero_id' => 'required'
        ]);

        $ruta = public_path('/images/desarrolladoras/' . Auth::user()->cm->desarrolladora->nombre . '/' . $request->nombre);

        if ($request->file('imagen_portada') != null) {
            $imagenPortada = $this->guardarImagen($request->file('imagen_portada'), $ruta, 'portada');
        }
        if ($request->file('imagen_caratula') != null) {
            $imagenCaratula = $this->guardarImagen($request->file('imagen_caratula'), $ruta, 'logo');
        }

        $juego = Juego::create([
            'nombre' => $request->nombre,
            'imagen_portada' => $imagenPortada ?? null,
            'imagen_caratula' => $imagenCaratula ?? null,
            'fecha_lanzamiento' => $request->fecha_lanzamiento,
            'precio' => $request->precio,
            'desarrolladora_id' =>  Cm::where('user_id', Auth::id())->first()->desarrolladora_id,
            'genero_id' => $request->genero_id,
        ]);

        if ($juego->exists) {
            session()->flash('success', 'El juego se ha creado.');
        } else {
            session()->flash('error', 'El juego no se ha podido crear. Si sigue fallando contacte con soporte@indie4all.com');
        }

        return redirect('/cm/juegos');
    }

    public function update(Request $request, $id)
    {
        $juego = Juego::find($id);

        $request->validate([
            'nombre' => ['required', 'max:255'],
            'imagen_portada' => ['mimes:png', 'dimensions:width=1024,height=512'],
            'imagen_caratula' => ['mimes:png', 'dimensions:width=200,height=256'],
            'fecha_lanzamiento' => 'required',
            'precio' => 'required',
            'genero_id' => 'required'
        ]);

        if ($juego->nombre != $request->nombre) {
            rename(public_path('/images/desarrolladoras/' . Auth::user()->cm->desarrolladora->nombre . '/' . $juego->nombre), public_path('/images/desarrolladoras/' . '/' . Auth::user()->cm->desarrolladora->nombre . '/' . $request->nombre));
        }

        $ruta = public_path('/images/desarrolladoras/' . Auth::user()->cm->desarrolladora->nombre . '/' . $request->nombre);

        if ($request->file('imagen_portada') != null) {
            $imagenPortada = $this->guardarImagen($request->file('imagen_portada'), $ruta, 'portada');
        } else {
            $imagenPortada = $juego->imagen_portada;
        }
        if ($request->file('imagen_caratula') != null) {
            $imagenLogo = $this->guardarImagen($request->file('imagen_caratula'), $ruta, 'logo');
        } else {
            $imagenLogo = $juego->imagen_logo;
        }

        $juego->update([
            'nombre' => $request->nombre,
            'imagen_portada' => $imagenPortada,
            'imagen_caratula' => $imagenLogo,
            'fecha_lanzamiento' => $request->fecha_lanzamiento,
            'precio' => $request->precio,
            'genero_id' => $request->genero_id,
            'contenido' => $request->contenido,
        ]);

        session()->flash('success', 'El juego se ha actualizado.');

        return redirect('/cm/juegos');
    }

    public function destroy($id)
    {
        $juego = Juego::find($id);

        $portada = public_path('/images/desarrolladoras/' . Auth::user()->cm->desarrolladora->nombre . '/' . $juego->nombre . '/' . $juego->imagen_portada);
        $caratula = public_path('/images/desarrolladoras/' . Auth::user()->cm->desarrolladora->nombre . '/' . $juego->nombre . '/' . $juego->imagen_caratula);

        if (@getimagesize($portada) && @getimagesize($caratula)) {
            unlink($portada);
            unlink($caratula);
        }

        $juego->delete();

        if (!$juego->exists) {
            session()->flash('success', 'El juego se ha retirado.');
        } else {
            session()->flash('error', 'El juego no se ha podido retirar. Si sigue fallando contacte con soporte@indie4all.com');
        }

        return redirect('/cm/juegos');
    }

    public function importar(Request $request)
    {
        Excel::import(new ClavesImport($request->juego), $request->file('csv'));

        $juego = Juego::find($request->juego);

        $generos = Genero::All();
        return view('cm.juego', ['juego' => $juego, 'generos' => $generos]);
    }

    public function fileImportExport()
    {
        return view('cm.claves');
    }

    public function claveDestroy($id)
    {
        Clave::find($id)->delete();

        return redirect('/cm/juegos');
    }

    public function clavesDestroy($id)
    {
        Clave::where('juego_id', $id)->delete();

        $juego = Juego::find($id);

        $generos = Genero::All();
        return view('cm.juego', ['juego' => $juego, 'generos' => $generos]);
    }

    /**
     * Guarda las imágenes en la carpeta public.
     *
     * @param  \Illuminate\Http\Request  $imagen
     * @param  String  $ruta
     * @param  String  $nombre
     * @return String
     */
    public function guardarImagen($imagen, $ruta, $nombre)
    {
        if ($imagen != null) {
            if (@getimagesize($ruta)) {
                unlink($ruta);
            }
            $extension = $imagen->getClientOriginalExtension();
            $imagen->move($ruta, $nombre . '.' .  $extension);
        }

        return $nombre . '.' .  $extension;
    }
}
