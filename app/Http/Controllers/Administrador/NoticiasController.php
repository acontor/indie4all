<?php

namespace App\Http\Controllers\Administrador;

use App\Http\Controllers\Controller;
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $noticias = Post::where([['desarrolladora_id', null], ['juego_id', null], ['master_id', null], ['campania_id', null]])->get();
        return view('admin.noticias', ['noticias' => $noticias]);
    }

    public function create()
    {
        return view('admin.noticias_editor');
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
            'titulo' => 'required',
            'contenido' => 'required',
        ]);

        Post::create($request->all());

        return redirect('/admin/noticias')->with('success', '¡Noticia guardada!');
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

        Post::find($id)->update([
            'titulo' => $request->titulo,
            'contenido' => $request->contenido,
            'comentarios' => $request->comentarios || 0
        ]);

        return redirect('/admin/noticias')->with('success', '!Noticia actualizada!');
    }

    public function upload(Request $request)
    {
        // Mover imagen a temp
        if ($request->hasFile('upload')) {
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName . '_' . time() . '.' . $extension;
            $request->file('upload')->move(public_path('images/posts'), $fileName);
            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('images/posts/' . $fileName);
            $msg = 'Image successfully uploaded';
            $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";
            @header('Content-type: text/html; charset=utf-8');
            echo $response;
        }
    }


    public function edit($id)
    {
        $post = Post::find($id);
        return view('admin.noticias_editor', ['post' => $post]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Post::find($id)->delete();

        return redirect('/admin/noticias')->with('success', '¡Noticia borrada!');
    }
}
