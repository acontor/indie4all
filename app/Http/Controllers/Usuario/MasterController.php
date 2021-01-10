<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use App\Models\Master;
use App\Models\User;
use App\Listeners\FollowListener;
use App\Models\Post;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $masters = Master::withCount(['seguidores' => function (Builder $query) {
            $query->whereBetween('master_user.created_at', [date('Y-m-d', strtotime(date('Y-m-d') . ' -3 months')), date('Y-m-d')]);
        }, 'posts' => function (Builder $query) {
            $query->whereBetween('posts.created_at', [date('Y-m-d', strtotime(date('Y-m-d') . ' -3 months')), date('Y-m-d')]);
        }])->orderBy('posts_count', 'DESC')->orderBy('seguidores_count', 'DESC')->get();

        $posts = Post::where('master_id', '!=', null)->orderBy('created_at', 'DESC')->get();

        return view('usuario.masters', ['masters' => $masters, 'posts' => $posts]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $master = Master::find($id);
        return view('usuario.master', ['master' => $master]);
    }

    public function follow($id)
    {
        $user = User::find(Auth::id());
        $user->masters()->attach([$id => ['notificacion' => true]]);

        event(new FollowListener($user));

        return redirect()->route('usuario.master.show', ['id' => $id]);
    }

    public function unfollow($id)
    {
        $user = User::find(Auth::id());

        $user->masters()->detach($id);

        return redirect()->route('usuario.master.show', ['id' => $id]);
    }

    public function notificacion($id, $notificacion)
    {
        $user = User::find(Auth::id());

        $user->masters()->sync([
            $id => ['notificacion' => $notificacion]
        ], false);

        return redirect()->route('usuario.master.show', ['id' => $id]);
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
