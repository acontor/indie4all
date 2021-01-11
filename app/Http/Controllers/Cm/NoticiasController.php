<?php

namespace App\Http\Controllers\Cm;

use App\Http\Controllers\Controller;
use App\Models\Cm;
use App\Models\Desarrolladora;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
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
        $this->middleware('cm');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $noticias = Desarrolladora::find(Cm::where('user_id', Auth::id())->first()->desarrolladora_id)->posts()->get();
        return view('cm.noticias', ['noticias' => $noticias]);
    }

    public function create($tipo, $id)
    {
        return view('cm.noticia_editor', ['tipo' => $tipo, 'id' => $id]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $tipo, $id)
    {
        $request->validate([
            'titulo' => 'required',
            'contenido' => 'required',
        ]);

        $post = Post::create([
            'titulo' => $request->titulo,
            'contenido' => $request->contenido,
            $tipo . '_id' => $id,
        ]);

        if($tipo == 'juego') {
            $url = '/cm/juego/' . $id;
        } else if($tipo == 'campania') {
            $url = '/cm/campania/' . $id;
        } else {
            $url = '/cm/noticias';
        }

        if ($post->exists) {
            session()->flash('success', 'El post se ha creado.');
        } else {
            session()->flash('error', 'El post no se ha podido crear. Si sigue fallando contacte con soporte@indie4all.com');
        }

        return redirect()->to($url);
    }

    public function edit($id)
    {
        $noticia = Post::find($id);
        return view('cm.noticia_editor', ['noticia' => $noticia]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'titulo' => 'required',
            'contenido' => 'required',
        ]);

        $post = Post::find($id);

        $post->update([
            'titulo' => $request->titulo,
            'contenido' => $request->contenido,
        ]);

        if($post->juego_id) {
            $url = '/cm/juego/' . $post->juego_id;
        } else if($post->campania_id) {
            $url = '/cm/campania/' . $post->campania_id;
        } else {
            $url = '/cm/noticias';
        }

        session()->flash('success', 'El post se ha editado.');

        return redirect()->to($url);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Post::find($id)->delete();
    }

    public function upload(Request $request)
    {
        if ($request->hasFile('upload')) {
            $nombreOriginal = $request->file('upload')->getClientOriginalName();
            $nombreImagen = pathinfo($nombreOriginal, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $nombreImagen = $nombreImagen . '_' . time() . '.' . $extension;
            $request->file('upload')->move(public_path('/images/desarrolladoras/' . Auth::user()->cm->desarrolladora->nombre . '/noticias'), $nombreImagen);
            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('/images/desarrolladoras/' . Auth::user()->cm->desarrolladora->nombre . '/noticias/' . $nombreImagen);
            $respuesta = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url')</script>";
            @header('Content-type: text/html; charset=utf-8');
            echo $respuesta;
        }
    }
}
