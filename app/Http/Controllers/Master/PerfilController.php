<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master;
use App\Models\User;
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $perfil = Master::find(User::find(Auth::id())->master->id);
        return view('master.perfil', ['perfil' => $perfil]);
    }

    public function update(Request $request, $id)
    {
        $master = Master::find($id);

        $request->validate([
            'nombre' => 'required',
            'email' => 'required',
        ]);

        $fileName = '';
        $imagen = public_path() . '/images/masters/' . $master->imagen;

        if (@getimagesize($imagen)) {
            unlink($imagen);
        }
        if ($imagen = $request->file('imagen')) {
            $originName = $request->file('imagen')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('imagen')->getClientOriginalExtension();
            $fileName = $fileName . '_' . time() . '.' . $extension;
            $imagen->move('images/masters/', $fileName);
        }

        $master->update([
            'nombre' => $request->nombre,
            'email' => $request->email,
            'imagen' => $fileName,
        ]);

        return view('master.perfil', ['perfil' => $master]);
    }
}
