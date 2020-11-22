<?php

namespace App\Http\Controllers\Cm;

use App\Http\Controllers\Controller;
use App\Models\Cm;
use App\Models\Desarrolladora;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DesarrolladoraController extends Controller
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
        $desarrolladora = Desarrolladora::find(Cm::where('user_id', Auth::id())->first()->desarrolladora_id);
        return view('cm.desarrolladora', ['desarrolladora' => $desarrolladora]);
    }

    public function update(Request $request, $id)
    {
        $desarrolladora = Desarrolladora::find($id);
        $request->validate([
            'nombre' => 'required',
            'email' => 'required',
            'direccion' => 'required',
            'telefono' => 'required',
            'url' => 'required',
            'imagen_logo' => 'required',
        ]);
        $fileName = '';
        $imagen = public_path() . '/images/desarrolladoras/' . $desarrolladora->imagen_logo;
        if (@getimagesize($imagen)) {
            unlink($imagen);
        }
        if ($imagen = $request->file('imagen_logo')) {
            $originName = $request->file('imagen_logo')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('imagen_logo')->getClientOriginalExtension();
            $fileName = $fileName . '_' . time() . '.' . $extension;
            $imagen->move('images/desarrolladoras/', $fileName);
        }

        Desarrolladora::find($id)->update([
            'nombre' => $request->nombre,
            'email' => $request->email,
            'direccion' => $request->direccion,
            'telefono' => $request->telefono,
            'url' => $request->url,
            'imagen_logo' => $fileName,
        ]);

        return redirect('/cm/desarrolladora')->with('success', 'Juego actualizado!');
    }
}
