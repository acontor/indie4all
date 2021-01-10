<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use App\Listeners\FollowListener;
use App\Mail\Sorteos\SorteoConfirmacion;
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
            $query->whereBetween('desarrolladora_user.created_at', [date('Y-m-d', strtotime(date('Y-m-d') . ' -3 months')), date('Y-m-d')]);
        }, 'posts' => function (Builder $query) {
            $query->whereBetween('posts.created_at', [date('Y-m-d', strtotime(date('Y-m-d') . ' -3 months')), date('Y-m-d')]);
        }])->orderBy('posts_count', 'DESC')->orderBy('seguidores_count', 'DESC')->get();

        $posts = Post::where('desarrolladora_id', '!=', null)->orderBy('created_at', 'DESC')->get();

        return view('usuario.desarrolladoras', ['desarrolladoras' => $desarrolladoras, 'posts' => $posts]);
    }

    public function all()
    {
        $desarrolladoras = Desarrolladora::all();
        return view('usuario.desarrolladoras_all', ['desarrolladoras' => $desarrolladoras]);
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
        return view('usuario.desarrolladora', ['desarrolladora' => $desarrolladora]);
    }

    public function follow($id)
    {
        $user = User::find(Auth::id());
        $user->desarrolladoras()->attach([$id => ['notificacion' => true]]);

        event(new FollowListener($user));

        return redirect()->route('usuario.desarrolladora.show', ['id' => $id]);
    }

    public function unfollow($id)
    {
        $user = User::find(Auth::id());

        $user->desarrolladoras()->detach($id);

        return redirect()->route('usuario.desarrolladora.show', ['id' => $id]);
    }

    public function notificacion($id, $notificacion)
    {
        $user = User::find(Auth::id());

        $user->desarrolladoras()->sync([
            $id => ['notificacion' => $notificacion]
        ], false);

        return redirect()->route('usuario.desarrolladora.show', ['id' => $id]);
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
    }

    public function encuesta(Request $request)
    {
        $user = User::find(Auth::id());

        $user->opciones()->attach([$request->opcion => ['opcion_id' => $request->opcion]]);
    }
}
