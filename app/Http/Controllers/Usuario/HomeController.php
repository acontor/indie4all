<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use App\Models\Campania;
use App\Models\Desarrolladora;
use App\Models\Juego;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $usuario = User::find(Auth::id());
        $juegos = Juego::whereDoesntHave('campania')->get();
        $campanias = Auth::user()->compras->has('campania');
        return view('usuario.home', ['usuario' => $usuario, 'juegos' => $juegos, 'campanias' => $campanias]);
    }

    public function busqueda(Request $request)
    {
        $data = [];
        if ($request->has('q')) {
            $search = $request->q;
            $juegos = Juego::select("id", "nombre")->where('nombre', 'LIKE', "%$search%")->take(5)->get();
            $desarrolladoras = Desarrolladora::select("id", "nombre")->where('nombre', 'LIKE', "%$search%")->take(5)->get();
            $masters = DB::table('users')
                ->join('masters', 'users.id', '=', 'masters.user_id')
                ->select('masters.id', 'users.name')->where('users.name', 'LIKE', "%$search%")->take(5)->get();
            foreach ($juegos as $juego) {
                $temp = ['id' => $juego->id, 'nombre' => $juego->nombre, 'tipo' => 'Juego'];
                array_push($data, $temp);
            }
            foreach ($desarrolladoras as $desarrolladora) {
                $temp = ['id' => $desarrolladora->id, 'nombre' => $desarrolladora->nombre, 'tipo' => 'Desarrolladora'];
                array_push($data, $temp);
            }
            foreach ($masters as $master) {
                $temp = ['id' => $master->id, 'nombre' => $master->name, 'tipo' => 'Master'];
                array_push($data, $temp);
            }
        }
        return response()->json($data);
    }

    public function acerca()
    {
        return view('acerca');
    }

    public function faq()
    {
        return view('faq');
    }

    public function desarrolladora()
    {
        return view('desarrolladora');
    }

    public function master()
    {
        return view('master');
    }
}
