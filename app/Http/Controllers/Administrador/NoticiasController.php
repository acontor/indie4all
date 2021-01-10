<?php

namespace App\Http\Controllers\Administrador;

use App\Http\Controllers\Controller;
use App\Models\Mensaje;
use App\Models\Post;
use Illuminate\Http\Request;

class NoticiasController extends Controller
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
     * Muestra todas las noticias.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $noticias = Post::where([['desarrolladora_id', null], ['juego_id', null], ['master_id', null], ['campania_id', null]])->get();

        return view('admin.noticias', ['noticias' => $noticias]);
    }

    /**
     * Muestra formulario para crear una noticia
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.noticias_editor');
    }

    /**
     * Crea una noticia.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => ['required', 'max:255'],
            'contenido' => ['required', 'max:255'],
        ]);

        $post = Post::create([
            'titulo' => $request->titulo,
            'contenido' => $request->contenido,
        ]);

        if ($post->exists) {
            session()->flash('success', 'La noticia se ha publicado');
        } else {
            session()->flash('error', 'La noticia no se ha podido publicar');
        }

        return redirect('/admin/noticias');
    }

    /**
     * Muestra formulario para editar una noticia
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);

        return view('admin.noticias_editor', ['post' => $post]);
    }

    /**
     * Actualiza la noticia seleccionada.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'titulo' => ['required', 'max:255'],
            'contenido' => ['required', 'max:255'],
        ]);

        Post::find($id)->update([
            'titulo' => $request->titulo,
            'contenido' => $request->contenido,
        ]);

        session()->flash('success', 'La noticia se ha actualizado');

        return redirect('/admin/noticias');
    }

    /**
     * Elimina la noticia seleccionada.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);

        $post->delete();

        if (!$post->exists) {
            session()->flash('success', 'La noticia se ha eliminado');
        } else {
            session()->flash('error', 'La noticia no se ha podido eliminar');
        }

        return redirect('/admin/noticias');
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
            $request->file('upload')->move(public_path('images/posts'), $nombreImagen);
            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('images/administracion/noticias' . $nombreImagen);
            $respuesta = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url')</script>";
            @header('Content-type: text/html; charset=utf-8');
            echo $respuesta;
        }
    }
}
