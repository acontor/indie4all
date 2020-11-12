<?php

namespace App\Http\Controllers\Administrador;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Models\Logro;
use App\Models\User;
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $logros = Logro::paginate(10);
        $num_usuarios = User::all()->count();
        return view('admin.logros', ['logros' => $logros, 'num_usuarios' => $num_usuarios]);
    }

    public function create()
    {
        return view('admin.logros_editor');
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
            'descripcion' => 'required',
            'icono' => 'required',
        ]);

        if ($archivo = $request->file('icono')) {
            $originName = $request->file('icono')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('icono')->getClientOriginalExtension();
            $fileName = $fileName . '_' . time() . '.' . $extension;
            $archivo->move('images/logros', $fileName);
            $request['icono'] = $fileName;
        }

        Logro::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'icono' => $fileName,
        ]);

        return redirect('/admin/logros')->with('success', '¡Logro guardado!');
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
            'descripcion' => 'required',
            'icono' => 'required',
        ]);

        $logro = Logro::find($id);
        $image_path = public_path("images/logros/{$logro->icono}");

        if (File::exists($image_path)) {
            unlink($image_path);
        }

        if ($archivo = $request->file('icono')) {
            $originName = $request->file('icono')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('icono')->getClientOriginalExtension();
            $fileName = $fileName . '_' . time() . '.' . $extension;
            $archivo->move('images/logros', $fileName);
            $request['icono'] = $fileName;
        }

        Logro::find($id)->update([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'icono' => $fileName,
        ]);
        return redirect('/admin/logros')->with('success', '!Logro actualizado!');
    }

    public function edit($id)
    {
        $logro = Logro::find($id);
        return view('admin.logros_editor', ['logro' => $logro]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $logro = Logro::find($id);
        $image_path = public_path("images/logros/{$logro->icono}");

        if (File::exists($image_path)) {
            unlink($image_path);
        }

        $logro->delete();

        return redirect('/admin/logros')->with('success', '¡Logro borrado!');
    }
}
