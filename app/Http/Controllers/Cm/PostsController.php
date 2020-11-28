<?php

namespace App\Http\Controllers\Cm;

use App\Http\Controllers\Controller;
use App\Models\Cm;
use App\Models\Desarrolladora;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PostsController extends Controller
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
        $posts = Desarrolladora::find(Cm::where('user_id', Auth::id())->first()->desarrolladora_id)->posts()->get();
        return view('cm.posts', ['posts' => $posts]);
    }

    public function create()
    {
        return view('cm.posts_editor');
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

        // Recorrer contenido para buscar imágenes, cambiar ruta temp por post

        Post::create([
            'titulo' => $request->titulo,
            'contenido' => $request->contenido,
            'desarrolladora_id' => Cm::where('user_id', Auth::id())->first()->desarrolladora_id,
        ]);

        return redirect('/cm/posts')->with('success', '¡Post guardado!');
    }

    public function edit($id)
    {
        $post = Post::find($id);
        return view('cm.posts_editor', ['post' => $post]);
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
        ]);

        return redirect('/cm/posts')->with('success', '!Post actualizado!');
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

        return redirect('/cm/posts')->with('success', '¡Post borrado!');
    }
}
