<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use App\Models\Genero;
use App\Models\Logro;
use App\Models\Solicitud;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CuentaController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usuario = User::find(Auth()->id());
        $logros = Logro::all();
        $generos = Genero::all();
        $solicitudRechazada = Solicitud::where('user_id', Auth()->id())->withTrashed()->get();
        return view('usuario.cuenta', ['usuario' => $usuario, 'logros' => $logros, 'generos' => $generos, 'solicitudRechazada' => $solicitudRechazada]);
    }

    public function usuario(Request $request)
    {
        $usuario = User::find(Auth::id());

        if(Hash::check($request->verify, $usuario->password)) {
            if(isset($request->password)) {
                $usuario->update([
                    'name' => $request->nombre,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                ]);
            } else {
                $usuario->update([
                    'name' => $request->nombre,
                    'email' => $request->email,
                ]);
            }
        } else {
            return redirect('/cuenta')->with('danger', 'La contraseña no coincide');
        }

        return redirect('/cuenta');
    }

    public function generos(Request $request)
    {
        $usuario = User::find(Auth::id());


        $usuario->generos()->wherePivot('user_id', $usuario->id)->detach();

        foreach ($request->generos as $value) {
            $usuario->generos()->attach([
                $value
            ]);
        }

        return redirect('/cuenta');
    }
}
