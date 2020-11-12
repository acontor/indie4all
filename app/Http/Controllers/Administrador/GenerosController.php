<?php

namespace App\Http\Controllers\Administrador;

use App\Http\Controllers\Controller;
use App\Models\Genero;
use Illuminate\Http\Request;

class GenerosController extends Controller
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
        $generos = Genero::paginate(4);
        $generosAll = Genero::all();
        $numJuegos = [];
        $numSeguidores = [];
        foreach ($generosAll as $genero) {
            array_push($numJuegos,  $genero->juegos->count());
            array_push($numSeguidores,  $genero->usuarios->count());
        }
        $data = [$numJuegos, $numSeguidores];
        return view('admin.generos', ['generos' => $generos, 'generosAll' => $generosAll, 'data' => $data]);
    }

    public function create()
    {
        return view('admin.generos_editor');
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
            'nombre' => 'required',
        ]);

        Genero::create($request->all());

        return redirect('/admin/generos')->with('success', '¡Género guardado!');
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
            'nombre' => 'required',
        ]);

        Genero::find($id)->update($request->all());

        return redirect('/admin/generos')->with('success', '¡Género actualizado!');
    }

    public function edit($id)
    {
        $genero = Genero::find($id);
        return view('admin.generos_editor', ['genero' => $genero]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Genero::find($id)->delete();
        return redirect('/admin/generos')->with('success', '¡Género borrado!');
    }
}
