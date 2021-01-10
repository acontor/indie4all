<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use App\Listeners\FollowListener;
use App\Models\Juego;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
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
            $query->whereBetween('juego_user.created_at', [date('Y-m-d', strtotime(date('Y-m-d') . ' -3 months')), date('Y-m-d')]);
        }, 'compras' => function (Builder $query) {
            $query->whereBetween('fecha_compra', [date('Y-m-d', strtotime(date('Y-m-d') . ' -3 months')), date('Y-m-d')]);
        }])->doesnthave('campania')->orderBy('compras_count', 'DESC')->orderBy('seguidores_count', 'DESC')->get();

        $posts = Post::where('master_id', null)->where('juego_id', '!=', null)->orderBy('created_at', 'DESC')->get();
        $analisis = Post::where('master_id', '!=', null)->where('juego_id', '!=', null)->orderBy('created_at', 'DESC')->get();
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

        $coleccion = Auth::user() ? Auth::user()->juegos : null;

        $juegos_id = [];

        if ($coleccion && $coleccion->count() > 0) {
            foreach ($coleccion as $juego) {
                array_push($juegos_id, $juego->id);
            }
        }

        $recomendados = Juego::withCount(['seguidores' => function (Builder $query) {
            $query->whereBetween('juego_user.created_at', [date('Y-m-d', strtotime(date('Y-m-d') . ' -3 months')), date('Y-m-d')]);
        }, 'compras' => function (Builder $query) {
            $query->whereBetween('fecha_compra', [date('Y-m-d', strtotime(date('Y-m-d') . ' -3 months')), date('Y-m-d')]);
        }])
            ->doesnthave('campania')
            ->where('id', '!=', $juego->id)
            ->where('genero_id', $juego->genero_id)
            ->orWhere('desarrolladora_id', $juego->desarrolladora_id)
            ->where('id', '!=', $juego->id)
            ->orderBy('compras_count', 'DESC')->orderBy('seguidores_count', 'DESC')->get();

        if (count($juegos_id) > 0) {
            $recomendados->whereNotIn('id', $juegos_id);
        }

        return view('usuario.juego', ['juego' => $juego, 'recomendados' => $recomendados]);
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

        return redirect()->route('usuario.juego.show', ['id' => $id]);
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

        return redirect()->route('usuario.juego.show', ['id' => $id]);
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

        return redirect()->route('usuario.juego.show', ['id' => $id]);
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
            $query->whereBetween('juego_user.created_at', [date('Y-m-d', strtotime(date('Y-m-d') . ' -3 months')), date('Y-m-d')]);
        }, 'compras' => function (Builder $query) {
            $query->whereBetween('fecha_compra', [date('Y-m-d', strtotime(date('Y-m-d') . ' -3 months')), date('Y-m-d')]);
        }])->doesnthave('campania')->orderBy('compras_count', 'DESC')->orderBy('seguidores_count', 'DESC');

        if (count($generos_id) > 0) {
            $juegos->whereIn('genero_id', $generos_id);
        }

        if (count($juegos_id) > 0) {
            $juegos->whereNotIn('id', $juegos_id);
        }

        if ($juegos->count() < 5) {
            $juegos = Juego::withCount(['seguidores' => function (Builder $query) {
                $query->whereBetween('juego_user.created_at', [date('Y-m-d', strtotime(date('Y-m-d') . ' -3 months')), date('Y-m-d')]);
            }, 'compras' => function (Builder $query) {
                $query->whereBetween('fecha_compra', [date('Y-m-d', strtotime(date('Y-m-d') . ' -3 months')), date('Y-m-d')]);
            }])->doesnthave('campania')->orderBy('compras_count', 'DESC')->orderBy('seguidores_count', 'DESC');
        }

        return $juegos->inRandomOrder()->get();
    }
}
