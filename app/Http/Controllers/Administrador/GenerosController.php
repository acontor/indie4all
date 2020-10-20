<?php

namespace App\Http\Controllers\Administrador;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Genero;
use Illuminate\Http\Request;

class GenerosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $generos = Genero::all();
        return view('admin.generos', compact('generos', $generos));
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

        $genero = new Genero([
            'nombre' => $request->get('nombre'),
        ]);

        $genero->save();

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

        $genero = Genero::find($id);
        $genero->nombre = $request->nombre;
        $genero->save();

        return redirect('/admin/generos')->with('success', '¡Género actualizado!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $genero = Genero::find($id);
        $genero->delete();
        return redirect('/admin/generos')->with('success', '¡Género borrado!');
    }
}
