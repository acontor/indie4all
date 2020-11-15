<?php

namespace App\Http\Controllers\Cm;

use App\Http\Controllers\Controller;
use App\Models\Cm;
use App\Models\Desarrolladora;
use App\Models\Campania;
use App\Models\Juego;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CampaniasController extends Controller
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
        $juegos = Desarrolladora::find(Cm::where('user_id', Auth::id())->first()->desarrolladora_id)->juegos()->paginate(6);
        return view('cm.campanias', ['juegos' => $juegos]);
    }

    public function create($id)
    {
        $juego = Juego::find($id);
        return view('cm.campanias_crear', ['juego' => $juego]);
    }

    public function store(Request $request, $id)
    {
        $request->validate([
            'meta' => 'required',
            'fecha_fin' => 'required',
        ]);

        Campania::create([
            'meta' => $request->meta,
            'resultado' => $request->imagen_portada,
            'fecha_fin' => $request->fecha_fin,
            'juego_id' => $id,
        ]);

        return redirect('/cm/campanias')->with('success', '¡Campaña creada!');
    }

    public function edit($campaniaId, $juegoId)
    {
        $campania = Campania::find($campaniaId);
        $juego = Juego::find($juegoId);
        return view('cm.campanias_crear', ['campania' => $campania, 'juego' => $juego]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'meta' => 'required',
            'fecha_fin' => 'required',
        ]);

        Campania::find($id)->update($request->all());

        return redirect('/cm/campanias')->with('success', '¡Campaña actualizada!');
    }

    public function destroy($id)
    {
        Campania::find($id)->delete();
        return redirect('/cm/campanias')->with('success', '¡Campaña borrad!');
    }
}
