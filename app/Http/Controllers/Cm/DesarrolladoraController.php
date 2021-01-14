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
            'nombre' => $desarrolladora->nombre !== $request->nombre ? ['required', 'unique:desarrolladoras', 'max:255'] : ['required', 'max:255'],
            'email' => $desarrolladora->email !== $request->email ? ['required', 'unique:desarrolladoras', 'max:255'] : ['required', 'max:255'],
            'imagen_portada' => ['mimes:png', 'dimensions:width=1024,height=512'],
            'imagen_logo' => ['mimes:png', 'dimensions:width=256,height=256'],
        ]);

        if ($desarrolladora->nombre != $request->nombre) {
            rename(public_path('/images/desarrolladoras/' . $desarrolladora->nombre), public_path('/images/desarrolladoras/' . $request->nombre));
        }

        $ruta = public_path('/images/desarrolladoras/' . $request->nombre);

        if ($request->file('imagen_portada') != null) {
            $imagenPortada = $this->guardarImagen($request->file('imagen_portada'), $ruta, 'portada');
        } else {
            $imagenPortada = $desarrolladora->imagen_portada;
        }
        if ($request->file('imagen_logo') != null) {
            $imagenLogo = $this->guardarImagen($request->file('imagen_logo'), $ruta, 'logo');
        } else {
            $imagenLogo = $desarrolladora->imagen_logo;
        }

        $desarrolladora->update([
            'nombre' => $request->nombre,
            'email' => $request->email,
            'direccion' => $request->direccion,
            'telefono' => $request->telefono,
            'url' => $request->url,
            'imagen_portada' => $imagenPortada,
            'imagen_logo' => $imagenLogo,
            'contenido' => $request->contenido,
        ]);

        session()->flash('success', 'El perfil se ha actualizado.');

        return redirect('/cm/desarrolladora');
    }

    public function upload(Request $request)
    {
        if ($request->hasFile('upload')) {
            $nombreOriginal = $request->file('upload')->getClientOriginalName();
            $nombreImagen = pathinfo($nombreOriginal, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $nombreImagen = $nombreImagen . '_' . time() . '.' . $extension;
            $request->file('upload')->move(public_path('/images/desarrolladoras/' . Auth::user()->cm->desarrolladora->nombre . '/contenido'), $nombreImagen);
            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('/images/desarrolladoras/' . Auth::user()->cm->desarrolladora->nombre . '/contenido/' . $nombreImagen);
            $respuesta = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url')</script>";
            @header('Content-type: text/html; charset=utf-8');
            echo $respuesta;
        }
    }

    /**
     * Guarda las imágenes en la carpeta public.
     *
     * @param  \Illuminate\Http\Request  $imagen
     * @param  String  $ruta
     * @param  String  $nombre
     * @return String
     */
    public function guardarImagen($imagen, $ruta, $nombre)
    {
        if ($imagen != null) {
            if (@getimagesize($ruta)) {
                unlink($ruta);
            }
            $extension = $imagen->getClientOriginalExtension();
            $imagen->move($ruta, $nombre . '.' .  $extension);
        }

        return $nombre . '.' .  $extension;
    }
}
