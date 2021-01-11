<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use App\Models\Campania;
use App\Models\Desarrolladora;
use App\Models\Juego;
use App\Models\Master;
use App\Models\Post;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Muestra el inicio de la web.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $noticias = Post::where([['desarrolladora_id', null], ['juego_id', null], ['master_id', null], ['campania_id', null]])->get();

        $juegos = Juego::doesnthave('campania')->take(3)->get();
        $juegosVentas = Juego::withCount(['compras' => function (Builder $query) {
            $query->whereBetween('fecha_compra', [date('Y-m-d', strtotime(date('Y-m-d') . ' -3 months')), date('Y-m-d')]);
        }])->doesnthave('campania')->orderBy('compras_count', 'DESC')->take(3)->get();

        $campanias = Campania::take(3)->get();
        $campaniasVentas = Campania::withCount(['compras' => function (Builder $query) {
            $query->whereBetween('fecha_compra', [date('Y-m-d', strtotime(date('Y-m-d') . ' -3 months')), date('Y-m-d')]);
        }])->orderBy('compras_count', 'DESC')->take(3)->get();

        $masters = Master::take(3)->get();

        $mastersTops = Master::withCount(['seguidores' => function (Builder $query) {
            $query->whereBetween('master_user.created_at', [date('Y-m-d', strtotime(date('Y-m-d') . ' -3 months')), date('Y-m-d')]);
        }, 'posts' => function (Builder $query) {
            $query->whereBetween('posts.created_at', [date('Y-m-d', strtotime(date('Y-m-d') . ' -3 months')), date('Y-m-d')]);
        }])->orderBy('posts_count', 'DESC')->orderBy('seguidores_count', 'DESC')->take(3)->get();

        return view('welcome', ['noticias' => $noticias, 'juegos' => $juegos, 'juegosVentas' => $juegosVentas, 'campanias' => $campanias, 'campaniasVentas' => $campaniasVentas, 'masters' => $masters, 'mastersTops', $mastersTops]);
    }

    /**
     * Muestra el portal personalizado para cada usuario.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function home()
    {
        $coleccion = Auth::user()->juegos;

        $juegos_id = [];

        if ($coleccion && $coleccion->count() > 0) {
            foreach ($coleccion as $juego) {
                array_push($juegos_id, $juego->id);
            }
        }

        $juegos = Juego::whereDoesntHave('campania')->whereIn('id', $juegos_id)->get();

        $campanias = Auth::user()->compras->has('campania');

        $posts = Post::all();

        return view('usuario.home', ['juegos' => $juegos, 'campanias' => $campanias, 'posts' => $posts]);
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
