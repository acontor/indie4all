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
     * Muestra el listado de todos los géneros.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $generos = Genero::all();

        $numJuegos = [];
        $numSeguidores = [];

        foreach ($generos as $genero) {
            array_push($numJuegos,  $genero->juegos->count());
            array_push($numSeguidores,  $genero->usuarios->count());
        }

        $datos = [$numJuegos, $numSeguidores];

        return view('admin.generos', ['generos' => $generos, 'datos' => $datos]);
    }

    /**
     * Muestra el formulario de creación de géneros.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.generos_editor');
    }

    /**
     * Almacena el género creado.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => ['required', 'string', 'max:255', 'unique:generos'],
        ]);

        $generos = Genero::create($request->all());

        if ($generos->exists()) {
            session()->flash('success', 'El género ha sido creado');
        } else {
            session()->flash('error', 'El género no se ha podido crear');
        }

        return redirect('/admin/generos');
    }

    /**
     * Muestra el formulario para editar el género seleccionado.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $genero = Genero::find($id);

        return view('admin.generos_editor', ['genero' => $genero]);
    }

    /**
     * Actualiza el género seleccionado.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $genero = Genero::find($id);

        $request->validate([
            'nombre' => $genero->nombre !== $request->nombre ? ['required', 'string', 'unique:generos', 'max:255'] : ['required', 'string', 'max:255'],
        ]);

        $genero->update($request->all());

        session()->flash('success', 'El género se ha actualizado');

        return redirect('/admin/generos');
    }
}
