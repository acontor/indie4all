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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $logros = Logro::paginate(10);
        $users = User::all()->count();
        return view('admin.logros', compact('logros', 'users'));
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
