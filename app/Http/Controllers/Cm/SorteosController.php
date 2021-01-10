<?php

namespace App\Http\Controllers\Cm;

use App\Http\Controllers\Controller;
use App\Mail\Sorteos\SorteoGanador;
use App\Models\Cm;
use App\Models\Desarrolladora;
use Illuminate\Support\Facades\Auth;
use App\Models\Sorteo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class SorteosController extends Controller
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
        $sorteos = Sorteo::where('desarrolladora_id', Cm::where('user_id', Auth::id())->first()->desarrolladora_id)->get();
        return view('cm.sorteos', ['sorteos' => $sorteos]);
    }

    public function create()
    {
        return view('cm.sorteos_crear');
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
            'titulo' => 'required',
            'descripcion' => 'required',
            'fecha_fin' => 'required',
        ]);

        $sorteo = Sorteo::create([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'fecha_fin' => $request->fecha_fin,
            'desarrolladora_id' => Cm::where('user_id', Auth::id())->first()->desarrolladora_id,
        ]);

        if ($sorteo->exists) {
            session()->flash('success', 'El sorteo se ha creado.');
        } else {
            session()->flash('error', 'El sorteo no se ha podido crear. Si sigue fallando contacte con soporte@indie4all.com');
        }

        return redirect('/cm/sorteos');
    }

    public function edit($id)
    {
        $sorteo = Sorteo::find($id);
        return view('cm.sorteos_crear', ['sorteo' => $sorteo]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'titulo' => 'required',
            'descripcion' => 'required',
            'fecha_fin' => 'required',
        ]);

        Sorteo::find($id)->update([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'fecha_fin' => $request->fecha_fin,
        ]);

        session()->flash('success', 'El sorteo se ha actualizado.');

        return redirect('/cm/sorteos');
    }

    public function finish($id)
    {
        $ganador = DB::table('sorteo_user')->select('user_id')->where('sorteo_id', $id)->inRandomOrder()->first();

        $sorteo = Sorteo::find($id);

        $sorteo->update([
            'user_id' => $ganador->user_id,
        ]);

        $user = User::find($ganador->user_id);

        $desarrolladora = Desarrolladora::find($sorteo->desarrolladora_id);

        Mail::to($user->email)->send(new SorteoGanador($user->name, $sorteo, $desarrolladora));


        session()->flash('success', 'Sorteo finalizado. El ganador ha sido ' .$user->name);


        return redirect('/cm/sorteos');
    }
}
