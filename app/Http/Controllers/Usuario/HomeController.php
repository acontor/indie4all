<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use App\Models\Campania;
use App\Models\Compra;
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
        $noticias = Post::where([['desarrolladora_id', null], ['juego_id', null], ['master_id', null], ['campania_id', null]])->where('titulo', '!=', null)->orderByDesc('destacado')->orderByDesc('created_at')->get();

        $juegos = Juego::doesnthave('campania')->where('ban', 0)->take(3)->get();
        $juegosVentas = Juego::withCount(['compras' => function (Builder $query) {
            $query->where('fecha_compra', '<=', date('Y-m-d', strtotime(date('Y-m-d') . ' +1 days')))->where('fecha_compra', '>=', date('Y-m-d', strtotime(date('Y-m-d') . ' -3 months')));
        }])->doesnthave('campania')->where('ban', 0)->orderBy('compras_count', 'DESC')->take(3)->get();

        $campanias = Campania::take(3)->get();
        $campaniasVentas = Campania::withCount(['compras' => function (Builder $query) {
            $query->where('fecha_compra', '<=', date('Y-m-d', strtotime(date('Y-m-d') . ' +1 days')))->where('fecha_compra', '>=', date('Y-m-d', strtotime(date('Y-m-d') . ' -3 months')));
        }])->where('ban', 0)->orderBy('compras_count', 'DESC')->take(3)->get();

        $masters = Master::take(3)->get();

        $mastersTops = Master::withCount(['seguidores' => function (Builder $query) {
            $query->where('master_user.created_at', '<=', date('Y-m-d', strtotime(date('Y-m-d') . ' +1 days')))->where('master_user.created_at', '>=', date('Y-m-d', strtotime(date('Y-m-d') . ' -3 months')));
        }, 'posts' => function (Builder $query) {
            $query->where('posts.created_at', '<=', date('Y-m-d', strtotime(date('Y-m-d') . ' +1 days')))->where('posts.created_at', '>=', date('Y-m-d', strtotime(date('Y-m-d') . ' -3 months')));
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

        $juegos = Juego::doesntHave('campania')->where('ban', 0)->whereIn('id', $juegos_id)->get();

        $compras = Compra::has('campania')->where('user_id', Auth::id())->take(3)->get();

        $desarrolladoras = Auth::user()->desarrolladoras->where('ban', 0);

        $desarrolladoras_id = [];

        if ($desarrolladoras && $desarrolladoras->count() > 0) {
            foreach ($desarrolladoras as $desarrolladora) {
                array_push($desarrolladoras_id, $desarrolladora->id);
            }
        }

        $masters = Auth::user()->masters;

        $masters_id = [];

        if ($masters && $masters->count() > 0) {
            foreach ($masters as $master) {
                array_push($masters_id, $master->id);
            }
        }

        $posts = Post::whereIn('desarrolladora_id', $desarrolladoras_id)
            ->orwhereIn('master_id', $masters_id)
            ->orwhereIn('juego_id', $juegos_id)
            ->orderByDesc('created_at')
            ->where('ban', 0)
            ->get();

        return view('usuario.home', ['juegos' => $juegos, 'compras' => $compras, 'posts' => $posts]);
    }

    public function busqueda(Request $request)
    {
        $data = [];
        if ($request->has('q')) {
            $search = $request->q;
            $juegos = Juego::where('nombre', 'LIKE', "%$search%")->where('ban', 0)->doesntHave('campania')->take(5)->get();
            $campanias = Juego::where('nombre', 'LIKE', "%$search%")->where('ban', 0)->has('campania')->take(5)->get();
            $desarrolladoras = Desarrolladora::select("id", "nombre", "imagen_logo")->where('nombre', 'LIKE', "%$search%")->where('ban', 0)->take(5)->get();
            $masters = DB::table('users')
                ->join('masters', 'users.id', '=', 'masters.user_id')
                ->select('masters.id', 'users.name', 'masters.imagen_logo')->where('users.name', 'LIKE', "%$search%")->where('users.ban', 0)->take(5)->get();
            foreach ($juegos as $juego) {
                $temp = ['id' => $juego->id, 'nombre' => $juego->nombre, 'imagen_caratula' => $juego->imagen_caratula, 'desarrolladora' => $juego->desarrolladora->nombre, 'tipo' => 'Juego'];
                array_push($data, $temp);
            }
            foreach ($campanias as $juego) {
                $temp = ['id' => $juego->campania->id, 'nombre' => $juego->nombre, 'imagen_caratula' => $juego->imagen_caratula, 'desarrolladora' => $juego->desarrolladora->nombre, 'tipo' => 'Campaña'];
                array_push($data, $temp);
            }
            foreach ($desarrolladoras as $desarrolladora) {
                $temp = ['id' => $desarrolladora->id, 'nombre' => $desarrolladora->nombre, 'imagen_logo' => $desarrolladora->imagen_logo, 'tipo' => 'Desarrolladora'];
                array_push($data, $temp);
            }
            foreach ($masters as $master) {
                $temp = ['id' => $master->id, 'nombre' => $master->name, 'imagen_logo' => $master->imagen_logo, 'tipo' => 'Master'];
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
