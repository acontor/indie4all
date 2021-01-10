<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class EstadosController extends Controller
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'estado' => 'required',
        ]);

        $post = Post::create([
            'contenido' => $request->estado,
            'master_id' => Auth::user()->master->id,
        ]);

        if ($post->exists) {
            return ['estado' => 'success', 'mensaje' => 'El estado se ha publicado.'];
        } else {
            return ['estado' => 'error', 'mensaje' => 'El estado no se ha podido. Si sigue fallando contacte con soporte@indie4all.com'];
        }
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
        return redirect('/master/' . Auth::user()->master->id);
    }
}
