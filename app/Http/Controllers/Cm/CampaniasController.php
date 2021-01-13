<?php

namespace App\Http\Controllers\Cm;

use App\Http\Controllers\Controller;
use App\Models\Cm;
use App\Models\Desarrolladora;
use App\Models\Campania;
use App\Models\Compra;
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
        $juegos = Desarrolladora::find(Cm::where('user_id', Auth::id())->first()->desarrolladora_id)->juegos()->has('campania')->orderByDesc('ban')->get();
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
        $compras = Compra::where('campania_id', $id)->get();
        return view('cm.campania', ['campania' => $campania, 'generos' => $generos, 'compras' => $compras]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cm.campania');
    }

    public function store(Request $request)
    {
        $request->validate([
            'meta' => 'required',
            'nombre' => 'required',
            'imagen_portada' => ['mimes:png', 'dimensions:width=1024,height=512'],
            'imagen_caratula' => ['mimes:png', 'dimensions:width=200,height=256'],
            'fecha_fin' => 'required',
            'aporte_minimo' => 'required',
            'genero_id' => 'required',
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

        $campania = Campania::create([
            'meta' => $request->meta,
            'fecha_fin' => $request->fecha_fin,
            'juego_id' => $juego->id,
            'aporte_minimo' => $request->aporte_minimo,
        ]);

        if ($campania->exists && $juego->exists) {
            session()->flash('success', 'La campaña se ha creado.');
        } else {
            session()->flash('error', 'La campaña no se ha podido crear. Si sigue fallando contacte con soporte@indie4all.com');
        }

        return redirect('/cm/campanias');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'meta' => 'required',
            'fecha_fin' => 'required',
            'nombre' => 'required',
            'imagen_portada' => ['mimes:png', 'dimensions:width=1024,height=512'],
            'imagen_caratula' => ['mimes:png', 'dimensions:width=200,height=256'],
            'genero_id' => 'required',
            'aporte_minimo' => 'required',
        ]);

        $campania = Campania::find($id);

        $campania->update([
            'meta' => $request->meta,
            'resultado' => $request->imagen_portada,
            'fecha_fin' => $request->fecha_fin,
            'contenido' => $request->contenido,
            'faq' => $request->faq,
        ]);

        $juego = Juego::find($campania->juego_id);

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
            'imagen_portada' => $imagenPortada ?? null,
            'imagen_caratula' => $imagenLogo ?? null,
            'fecha_lanzamiento' => $request->fecha_lanzamiento,
            'precio' => $request->precio,
            'genero_id' => $request->genero_id,
            'contenido' => $request->contenido,
        ]);

        session()->flash('success', 'La campaña se ha actualizado.');

        return redirect('/cm/campanias');
    }

    public function destroy($id)
    {
        $campania = Campania::find($id);

        $campania->delete();

        Juego::where('id', $campania->id)->delete();

        if (!$campania->exists) {
            session()->flash('success', 'La campaña se ha retirado.');
        } else {
            session()->flash('error', 'La campaña no se ha podido eliminar. Si sigue fallando contacte con soporte@indie4all.com');
        }

        return redirect('/cm/campanias');
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
