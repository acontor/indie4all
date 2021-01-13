<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use App\Listeners\EncuestaListener;
use App\Listeners\FollowListener;
use App\Listeners\SorteoListener;
use App\Mail\Sorteos\SorteoConfirmacion;
use App\Models\Campania;
use App\Models\Desarrolladora;
use App\Models\Post;
use App\Models\Sorteo;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class DesarrolladorasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $desarrolladoras = Desarrolladora::withCount(['seguidores' => function (Builder $query) {
            $query->where('desarrolladora_user.created_at', '<=', date('Y-m-d', strtotime(date('Y-m-d') . ' +1 days')))->where('desarrolladora_user.created_at', '>=', date('Y-m-d', strtotime(date('Y-m-d') . ' -3 months')));
        }, 'posts' => function (Builder $query) {
            $query->where('posts.created_at', '<=', date('Y-m-d', strtotime(date('Y-m-d') . ' +1 days')))->where('posts.created_at', '>=', date('Y-m-d', strtotime(date('Y-m-d') . ' -3 months')));
        }])->where('ban', 0)->orderBy('posts_count', 'DESC')->orderBy('seguidores_count', 'DESC')->get();

        $posts = Post::select('posts.*')
            ->where('desarrolladora_id', '!=', null)
            ->join('desarrolladoras', 'desarrolladoras.id', '=', 'posts.desarrolladora_id')
            ->where('posts.ban', 0)
            ->where('desarrolladoras.ban', 0)
            ->orderBy('posts.created_at', 'DESC')->get();

        return view('usuario.desarrolladoras', ['desarrolladoras' => $desarrolladoras, 'posts' => $posts]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $desarrolladora = Desarrolladora::find($id);

        if ($desarrolladora->ban) {
            session()->flash('error', 'La desarrolladora está suspendida');
            return redirect()->back();
        }

        $campanias = Campania::select('campanias.*')
            ->join('juegos', 'juegos.id', 'campanias.juego_id')
            ->join('desarrolladoras', 'desarrolladoras.id', 'juegos.desarrolladora_id')
            ->where('desarrolladoras.id', $id)
            ->where('campanias.ban', 0)->get();

        return view('usuario.desarrolladora', ['desarrolladora' => $desarrolladora, 'campanias' => $campanias]);
    }

    public function follow($id)
    {
        $user = User::find(Auth::id());
        $user->desarrolladoras()->attach([$id => ['notificacion' => true]]);

        event(new FollowListener($user));

        return redirect()->back();
    }

    public function unfollow($id)
    {
        $user = User::find(Auth::id());

        $user->desarrolladoras()->detach($id);

        return redirect()->back();
    }

    public function notificacion($id, $notificacion)
    {
        $user = User::find(Auth::id());

        $user->desarrolladoras()->sync([
            $id => ['notificacion' => $notificacion]
        ], false);

        return redirect()->back();
    }

    public function post(Request $request)
    {
        $post = Post::find($request->id);

        $mensajes = DB::table('mensajes')
            ->join('users', 'users.id', '=', 'mensajes.user_id')
            ->select('mensajes.contenido', 'mensajes.created_at', 'users.name')
            ->where('mensajes.post_id', $post->id)->get();

        return ['post' => $post, 'mensajes' => $mensajes];
    }

    public function sorteo(Request $request)
    {
        $user = User::find(Auth::id());
        $user->sorteos()->attach($request->id);

        $sorteo = Sorteo::find($request->id);

        $desarrolladora = $sorteo->desarrolladora->nombre;

        Mail::to($user->email)->send(new SorteoConfirmacion($user->name, $sorteo, $desarrolladora));

        event(new SorteoListener($user));
    }

    public function encuesta(Request $request)
    {
        $user = User::find(Auth::id());

        $user->opciones()->attach([$request->opcion => ['opcion_id' => $request->opcion]]);

        event(new EncuestaListener($user));
    }
}
