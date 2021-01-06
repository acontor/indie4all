<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use App\Models\Juego;
use App\Models\Post;
use App\Models\User;
use App\Listeners\FollowListener;
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
        if (Auth::user()) {
            $seguidos = Auth::user()->juegos;
        } else {
            $seguidos = null;
        }
        $juegos = Juego::all();
        return view('usuario.juegos', ['juegos' => $juegos, 'seguidos' => $seguidos]);
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
}
