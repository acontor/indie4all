<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Juego;
use App\Models\Mensaje;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AnalisisController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('master');
    }

    /**
     * Muestra una vista con los análisis del master del usuario registrado.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $analisis = Post::where('master_id', Auth::user()->master->id)->where('juego_id', '!=', null)->get();
        return view('master.analisis', ['analisis' => $analisis]);
    }

    /**
     * Muestra el formulario para realizar el análisis de un juego.
     *
     * @param  Integer  $id
     * @return \Illuminate\Http\Response
     */
    public function create($id = null)
    {
        $juegos = Juego::doesntHave('campania')->get();
        return view('master.analisis_editor', ['juegos' => $juegos, 'id' => $id]);
    }

    /**
     * Guarda en la base de datos el análisis realizado.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => ['required', 'max:255'],
            'calificacion' => ['required', 'numeric', 'max:10', 'min:1'],
            'contenido' => 'required',
            'juego' => 'required',
        ]);

        $analisis = Post::where('master_id', Auth::user()->master->id)->where('juego_id', $request->juego)->count();

        if ($analisis > 0) {
            session()->flash('error', 'Ya has creado un análisis del juego seleccionado.');
        } else {
            $analisis = Post::create([
                'titulo' => $request->titulo,
                'calificacion' => $request->calificacion,
                'contenido' => $request->contenido,
                'master_id' => Auth::user()->master->id,
                'juego_id' => $request->juego,
            ]);

            if ($analisis->exists()) {
                session()->flash('success', 'El análisis se ha creado.');
            } else {
                session()->flash('error', 'El análisis no se ha podido crear. Si sigue fallando contacte con soporte@indie4all.com');
            }
        }

        return redirect('/master/analisis');
    }

    /**
     * Muestra el formulario para editar el análisis seleccionado.
     *
     * @param  Integer  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $juegos = Juego::doesntHave('campania')->count();
        $analisis = Post::find($id);
        if($analisis->exists()) {
            return view('master.analisis_editor', ['analisis' => $analisis, 'juegos' => $juegos, 'id' => $analisis->juego_id]);
        } else {
            session()->flash('error', 'El analisis no existe');
            return redirect()->back();
        }
    }

    /**
     * Actualiza el análsis seleccionado.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'titulo' => ['required', 'max:255'],
            'calificacion' => ['required', 'numeric', 'max:10', 'min:1'],
            'contenido' => 'required',
        ]);

        $analisis = Post::find($id);

        $analisis->update([
            'titulo' => $request->titulo,
            'calificacion' => $request->calificacion,
            'contenido' => $request->contenido,
        ]);

        session()->flash('success', 'El análisis se ha editado.');

        return redirect('/master/analisis');
    }

    /**
     * Elimina el análisis seleccionado y todos sus mensajes.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Mensaje::where('post_id', $id)->delete();

        $analisis = Post::find($id);

        $analisis->delete();

        if (!$analisis->exists()) {
            session()->flash('success', 'El análisis se ha eliminado.');
        } else {
            session()->flash('error', 'El análisis no se ha podido eliminar. Si sigue fallando contacte con soporte@indie4all.com');
        }

        return redirect('/master/analisis');
    }

    /**
     * Sube las fotos al servidor.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function upload(Request $request)
    {
        if ($request->hasFile('upload')) {
            $nombreOriginal = $request->file('upload')->getClientOriginalName();
            $nombreImagen = pathinfo($nombreOriginal, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $nombreImagen = $nombreImagen . '_' . time() . '.' . $extension;
            $request->file('upload')->move(public_path('/images/masters/' . Auth::user()->master->nombre . '/analisis'), $nombreImagen);
            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('/images/masters/' . Auth::user()->master->nombre . '/analisis/' . $nombreImagen);
            $respuesta = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url')</script>";
            @header('Content-type: text/html; charset=utf-8');
            echo $respuesta;
        }
    }
}
