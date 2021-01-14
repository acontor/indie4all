<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use App\Listeners\FollowListener;
use App\Models\Juego;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JuegosController extends Controller
{
    /**
     * Muestra una vista con últimas noticias de juegos favoritos o todos los juegos, recomendaciones y filtros.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $coleccion = Auth::user() ? Auth::user()->juegos : null;
        $generos = Auth::user() ? Auth::user()->generos : null;

        $juegos = Juego::withCount(['seguidores' => function (Builder $query) {
            $query->where('juego_user.created_at', '<=', date('Y-m-d', strtotime(date('Y-m-d') . ' +1 days')))->where('juego_user.created_at', '>=', date('Y-m-d', strtotime(date('Y-m-d') . ' -3 months')));
        }, 'compras' => function (Builder $query) {
            $query->where('fecha_compra', '<=', date('Y-m-d', strtotime(date('Y-m-d') . ' +1 days')))->where('fecha_compra', '>=', date('Y-m-d', strtotime(date('Y-m-d') . ' -3 months')));
        }])->where('ban', 0)->doesnthave('campania')->orderBy('compras_count', 'DESC')->orderBy('seguidores_count', 'DESC')->get();

        $posts = Post::select('posts.*')
            ->where('master_id', null)
            ->where('juego_id', '!=', null)
            ->join('juegos', 'juegos.id', '=', 'posts.juego_id')
            ->where('posts.ban', 0)
            ->where('juegos.ban', 0)
            ->orderBy('posts.created_at', 'DESC')->get();

        $analisis = Post::select('posts.*')
            ->where('master_id', '!=', null)
            ->where('juego_id', '!=', null)
            ->join('masters', 'masters.id', '=', 'posts.master_id')
            ->join('users', 'users.id', '=', 'masters.user_id')
            ->where('posts.ban', 0)
            ->where('users.ban', 0)
            ->orderBy('posts.created_at', 'DESC')->get();

        $recomendados = $this->obtenerJuegos($generos, $coleccion);

        return view('usuario.juegos', ['recomendados' => $recomendados, 'juegos' => $juegos, 'coleccion' => $coleccion, 'posts' => $posts, 'analisis' => $analisis]);
    }

    /**
     * Muestra la vista de un juego.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $juego = Juego::find($id);

        if ($juego === null){
            session()->flash('error', 'Ese juego no éxiste');
            return redirect()->back();
        }

        if ($juego->ban) {
            session()->flash('error', 'El juego está suspendido');
            return redirect()->back();
        }

        $coleccion = Auth::user() ? Auth::user()->juegos : null;

        $juegos_id = [];

        if ($coleccion && $coleccion->count() > 0) {
            foreach ($coleccion as $juegoColeccion) {
                array_push($juegos_id, $juegoColeccion->id);
            }
        }

        $recomendados = Juego::withCount(['seguidores' => function (Builder $query) {
            $query->where('juego_user.created_at', '<=', date('Y-m-d', strtotime(date('Y-m-d') . ' +1 days')))->where('juego_user.created_at', '>=', date('Y-m-d', strtotime(date('Y-m-d') . ' -3 months')));
        }, 'compras' => function (Builder $query) {
            $query->where('fecha_compra', '<=', date('Y-m-d', strtotime(date('Y-m-d') . ' +1 days')))->where('fecha_compra', '>=', date('Y-m-d', strtotime(date('Y-m-d') . ' -3 months')));
        }])
            ->doesnthave('campania')
            ->where('id', '!=', $juego->id)
            ->where('genero_id', $juego->genero_id)
            ->where('ban', 0)
            ->orWhere('desarrolladora_id', $juego->desarrolladora_id)
            ->doesnthave('campania')
            ->where('id', '!=', $juego->id)
            ->where('ban', 0)
            ->orderBy('compras_count', 'DESC')->orderBy('seguidores_count', 'DESC')->get();

        if (count($juegos_id) > 0) {
            $recomendados->whereNotIn('id', $juegos_id);
        }

        $analisis = Post::select('posts.*')
            ->where('master_id', '!=', null)
            ->where('juego_id', $id)
            ->join('masters', 'masters.id', '=', 'posts.master_id')
            ->join('users', 'users.id', '=', 'masters.user_id')
            ->where('posts.ban', 0)
            ->where('users.ban', 0)
            ->orderBy('posts.created_at', 'DESC')->get();

        return view('usuario.juego', ['juego' => $juego, 'recomendados' => $recomendados, 'analisis' => $analisis]);
    }

    /**
     * Añade un juego a la colección.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function follow($id)
    {
        $user = User::find(Auth::id());
        $user->juegos()->attach([$id => ['notificacion' => true]]);

        event(new FollowListener($user));

        return redirect()->back();
    }

    /**
     *
     * Elimina un juego de la colección.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function unfollow($id)
    {
        $user = User::find(Auth::id());

        $user->juegos()->detach($id);

        return redirect()->back();
    }

    /**
     * Activa las notificaciones de un juego.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function notificacion($id, $notificacion)
    {
        $user = User::find(Auth::id());

        $user->juegos()->sync([
            $id => ['notificacion' => $notificacion]
        ], false);

        return redirect()->back();
    }

    /**
     * Obtiene juegos para recomendar.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function obtenerJuegos($generos, $coleccion)
    {
        $generos_id = [];

        if ($generos && $generos->count() > 0) {
            foreach ($generos as $genero) {
                array_push($generos_id, $genero->id);
            }
        }

        $juegos_id = [];

        if ($coleccion && $coleccion->count() > 0) {
            foreach ($coleccion as $juego) {
                array_push($juegos_id, $juego->id);
            }
        }

        $juegos = Juego::withCount(['seguidores' => function (Builder $query) {
            $query->where('juego_user.created_at', '<=', date('Y-m-d', strtotime(date('Y-m-d') . ' +1 days')))->where('juego_user.created_at', '>=', date('Y-m-d', strtotime(date('Y-m-d') . ' -3 months')));
        }, 'compras' => function (Builder $query) {
            $query->where('fecha_compra', '<=', date('Y-m-d', strtotime(date('Y-m-d') . ' +1 days')))->where('fecha_compra', '>=', date('Y-m-d', strtotime(date('Y-m-d') . ' -3 months')));
        }])->doesnthave('campania')->orderBy('compras_count', 'DESC')->orderBy('seguidores_count', 'DESC');

        if (count($generos_id) > 0) {
            $juegos->whereIn('genero_id', $generos_id);
        }

        if (count($juegos_id) > 0) {
            $juegos->whereNotIn('id', $juegos_id);
        }

        if ($juegos->count() < 5) {
            $juegos = Juego::withCount(['seguidores' => function (Builder $query) {
                $query->where('juego_user.created_at', '<=', date('Y-m-d', strtotime(date('Y-m-d') . ' +1 days')))->where('juego_user.created_at', '>=', date('Y-m-d', strtotime(date('Y-m-d') . ' -3 months')));
            }, 'compras' => function (Builder $query) {
                $query->where('fecha_compra', '<=', date('Y-m-d', strtotime(date('Y-m-d') . ' +1 days')))->where('fecha_compra', '>=', date('Y-m-d', strtotime(date('Y-m-d') . ' -3 months')));
            }])->doesnthave('campania')->orderBy('compras_count', 'DESC')->orderBy('seguidores_count', 'DESC');
        }

        return $juegos->where('ban', 0)->inRandomOrder()->get();
    }

    public function calificar(Request $request)
    {
        $user = User::find(Auth::id());

        $user->juegos()->sync(
            [$request->id => [
                'notificacion' => false,
                'calificacion' => $request->calificacion
            ]],
            false
        );

        $calificacion = Juego::find($request->id)->seguidores->avg('pivot.calificacion');

        return array('calificacion' => number_format($calificacion, 2, '.', ''), 'estado' => 'success', 'mensaje' => 'Gracias por calificarnos');
    }
}
