<?php

namespace App\Http\Controllers\Administrador;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Models\Logro;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class LogrosController extends Controller
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
     * Muestra el listado de todos los logros.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $logros = Logro::all();
        $datos = [];

        foreach ($logros as $logro) {
            $dato = DB::table('logro_user')->where('logro_id', $logro->id)->count();

            array_push($datos, $dato);
        }

        return view('admin.logros', ['logros' => $logros, 'datos' => $datos]);
    }

    /**
     * Muestra el formulario de creación de logros.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.logros_editor');
    }

    /**
     * Almacena el logro creado.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => ['required', 'string', 'max:255', 'unique:generos'],
            'descripcion' => ['required', 'string', 'max:255', 'unique:generos'],
            'icono' => ['required', 'string', 'max:255', 'unique:generos'],
        ]);

        $logro = Logro::create($request->all());

        if ($logro->exists) {
            session()->flash('success', 'El logro ha sido creado');
        } else {
            session()->flash('error', 'El logro no se ha podido crear');
        }

        return redirect('/admin/logros');
    }

    /**
     * Muestra el formulario para editar el logro seleccionado.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $logro = Logro::find($id);

        return view('admin.logros_editor', ['logro' => $logro]);
    }

    /**
     * Actualiza el logro seleccionado.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $logro = Logro::find($id);

        $request->validate([
            'nombre' => $logro->nombre !== $request->nombre ? ['required', 'string', 'unique:logros', 'max:255'] : ['required', 'string', 'max:255'],
            'descripcion' => $logro->descripcion !== $request->descripcion ? ['required', 'string', 'unique:logros', 'max:255'] : ['required', 'string', 'max:255'],
            'icono' => $logro->icono !== $request->icono ? ['required', 'string', 'unique:logros', 'max:255'] : ['required', 'string', 'max:255'],
        ]);

        $logro->update($request->all());

        session()->flash('success', 'El logro se ha actualizado');

        return redirect('/admin/logros');
    }
}
