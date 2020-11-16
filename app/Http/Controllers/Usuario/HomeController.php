<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use App\Models\Desarrolladora;
use App\Models\Juego;
use App\Models\Master;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $usuario = User::find(Auth::id());
        return view('usuario.home', ['usuario' => $usuario]);
    }

    public function busqueda(Request $request)
    {
        $data = [];
        if ($request->has('q')) {
            $search = $request->q;
            $juegos = Juego::select("id", "nombre")->where('nombre', 'LIKE', "%$search%")->get();
            $desarrolladoras = Desarrolladora::select("id", "nombre")->where('nombre', 'LIKE', "%$search%")->get();
            //$usuarios = User::with('masters')->select("masters.id, users.name")->where('name', 'LIKE', "%$search%")->get();
            $masters = DB::table('users')
            ->join('masters', 'users.id', '=', 'masters.user_id')
            ->select('masters.id', 'users.name')->where('users.name', 'LIKE', "%$search%")->get();
            foreach ($juegos as $juego) {
                $temp = ["id" => $juego->id, "nombre" => "Juego > " . $juego->nombre];
                array_push($data, $temp);
            }
            foreach ($desarrolladoras as $desarrolladora) {
                $temp = ["id" => $desarrolladora->id, "nombre" => "Desarrolladora > " . $desarrolladora->nombre];
                array_push($data, $temp);
            }
            foreach ($masters as $master) {
                $temp = ["id" => $master->id, "nombre" => "Master > " . $master->name];
                array_push($data, $temp);
            }
        }
        return response()->json($data);
    }
}
