<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PerfilController extends Controller
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
     * Muestra una vista con los datos del perfil de master del usuario registrado.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $perfil = Master::find(Auth::user()->master->id);
        $analisis = Post::where('master_id', Auth::user()->master->id)->where('juego_id', '!=', null)->get();
        return view('master.perfil', ['perfil' => $perfil, 'analisis' => $analisis]);
    }

    /**
     * Actualizado los datos del perfil de master.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $master = Master::find(Auth::user()->master->id);

        $request->validate([
            'nombre' => $master->nombre !== $request->nombre ? ['required', 'unique:masters', 'max:255'] : ['required', 'max:255'],
            'email' => ['required', 'max:255'],
            'imagen_portada' => ['mimes:png', 'dimensions:width=1024,height=512'],
            'imagen_logo' => ['mimes:png', 'dimensions:width=256,height=256'],
        ]);

        if ($master->nombre != $request->nombre) {
            rename(public_path('/images/masters/' . $master->nombre), public_path('/images/masters/' . $request->nombre));
        }

        $ruta = public_path('/images/masters/' . $request->nombre);

        if ($request->file('imagen_portada') != null) {
            $imagenPortada = $this->guardarImagen($request->file('imagen_portada'), $ruta, 'portada');
        } else {
            $imagenPortada = $master->imagen_portada;
        }
        if ($request->file('imagen_logo') != null) {
            $imagenLogo = $this->guardarImagen($request->file('imagen_logo'), $ruta, 'logo');
        } else {
            $imagenLogo = $master->imagen_logo;
        }

        $master->update([
            'nombre' => $request->nombre,
            'email' => $request->email,
            'imagen_portada' => $imagenPortada,
            'imagen_logo' => $imagenLogo,
        ]);

        Post::where('master_id', Auth::user()->master->id)->where('juego_id', '!=', null)->update([
            'destacado' => 0,
        ]);

        foreach ($request->juegos as $value) {
            Post::where('master_id', Auth::user()->master->id)->where('juego_id', $value)->update([
                'destacado' => 1,
            ]);
        }

        session()->flash('success', 'Perfil modificado.');

        return redirect('/master/perfil');
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
