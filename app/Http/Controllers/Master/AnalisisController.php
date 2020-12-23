<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $analisis = Post::where('master_id', User::find(Auth::id())->master->id)->get();
        return view('master.analisis', ['analisis' => $analisis]);
    }

    public function create()
    {
        return view('master.analisis_editor');
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
            'calificacion' => 'required',
            'contenido' => 'required',
        ]);

        Post::create([
            'titulo' => $request->titulo,
            'calificacion' => $request->calificacion,
            'tipo' => 'Análisis',
            'contenido' => $request->contenido,
            'master_id' => User::find(Auth::id())->master->id,
        ]);

        return redirect('/master/analisis')->with('success', '¡Análisis guardado!');
    }

    public function edit($id)
    {
        $post = Post::find($id);
        return view('master.analisis_editor', ['post' => $post]);
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
            'calificacion' => 'required',
            'contenido' => 'required',
        ]);

        Post::find($id)->update([
            'titulo' => $request->titulo,
            'calificacion' => $request->calificacion,
            'contenido' => $request->contenido,
        ]);

        return redirect('/master/analisis')->with('success', '¡Análisis actualizado!');
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

        return redirect('/master/analisis')->with('success', '¡Post borrado!');
    }
}
