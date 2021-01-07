<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use App\Models\Juego;
use App\Models\Post;
use App\Models\User;
use App\Listeners\FollowListener;
use App\Models\Compra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class JuegosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $coleccion = Auth::user() ? Auth::user()->juegos : null;
        $generos = Auth::user() ? Auth::user()->generos : null;
        $juegos = Juego::all();
        $fecha = date('Y-m-d');
        $compras = Compra::select('juego_id', DB::raw("count(id) as ventas"))->whereBetween('fecha_compra', [date('Y-m-d', strtotime($fecha . ' -1 months')), $fecha])->groupBy('juego_id')->get();

        $posts = $this->obtenerPosts($coleccion);
        $recomendados = $this->obtenerJuegos($generos, $coleccion);

        return view('usuario.juegos', ['recomendados' => $recomendados, 'juegos' => $juegos, 'coleccion' => $coleccion, 'compras' => $compras, 'posts' => $posts]);
    }

    public function all(Request $request)
    {
        $juegos = Juego::paginate(2);
        if ($request->ajax()) {
            if ($request->nombre != '' || $request->genero != '') {
                if ($request->genero != '') {
                    $juegos = Juego::where('nombre', 'like', '%' . $request->nombre . '%')->where('genero_id', $request->genero)->paginate(200);
                } else if ($request->nombre == '') {
                    $juegos = Juego::where('genero_id', $request->genero)->paginate(200);
                } else {
                    $juegos = Juego::where('nombre', 'like', '%' . $request->nombre . '%')->paginate(200);
                }
            }
            return view('usuario.pagination_data', ['juegos' => $juegos])->render();
        }
        return view('usuario.juegos_all', ['juegos' => $juegos]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $juego = Juego::find($id);
        return view('usuario.juego', ['juego' => $juego]);
    }

    public function follow($id)
    {
        $user = User::find(Auth::id());
        $user->juegos()->attach([$id => ['notificacion' => true]]);

        event(new FollowListener($user));

        return redirect()->route('usuario.juego.show', ['id' => $id]);
    }

    public function unfollow($id)
    {
        $user = User::find(Auth::id());

        $user->juegos()->detach($id);

        return redirect()->route('usuario.juego.show', ['id' => $id]);
    }

    public function notificacion($id, $notificacion)
    {
        $user = User::find(Auth::id());

        $user->juegos()->sync([
            $id => ['notificacion' => $notificacion]
        ], false);

        return redirect()->route('usuario.juego.show', ['id' => $id]);
    }

    public function post(Request $request)
    {
        $post = Post::find($request->id);

        $mensajes = DB::table('mensajes')
            ->join('users', 'users.id', '=', 'mensajes.user_id')
            ->select('mensajes.contenido', 'mensajes.created_at', 'users.name', 'mensajes.id')
            ->where('mensajes.post_id', $post->id)->get();

        return ['post' => $post, 'mensajes' => $mensajes];
    }

    public function obtenerPosts($coleccion)
    {
        $juegos_id = [];

        if ($coleccion->count() > 0) {
            foreach ($coleccion as $juego) {
                array_push($juegos_id, $juego->id);
            }
        }

        if (count($juegos_id) > 0) {
            $posts = Post::whereIn('juego_id', $juegos_id)->get();
        } else {
            $posts = Post::where('juego_id', '!=', null)->get();
        }

        if($posts->count() == 0 || count($juegos_id)  == 0) {
            $posts = Post::where('juego_id', '!=', null)->get();
        }

        return $posts;
    }

    public function obtenerJuegos($generos, $coleccion)
    {
        $generos_id = [];

        if ($generos->count() > 0) {
            foreach ($generos as $genero) {
                array_push($generos_id, $genero->id);
            }
        }

        $juegos_id = [];

        if ($coleccion->count() > 0) {
            foreach ($coleccion as $juego) {
                array_push($juegos_id, $juego->id);
            }
        }

        if (count($generos_id) > 0) {
            if(count($juegos_id) > 0) {
                $posts = Juego::whereIn('genero_id', $generos_id)->whereNotIn('id', $juegos_id)->get();
            } else {
                $posts = Juego::whereIn('genero_id', $generos_id)->get();
            }
        } else {
            $posts = Juego::where('genero_id', '!=', null)->get();
        }

        return $posts;
    }
}
