<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostsController extends Controller
{
    public function show(Request $request)
    {
        $post = Post::find($request->id);

        $mensajes = DB::table('mensajes')
            ->join('users', 'users.id', '=', 'mensajes.user_id')
            ->select('mensajes.contenido', 'mensajes.created_at', 'users.id as id', 'users.name')
            ->where('mensajes.post_id', $post->id)
            ->where('users.ban', 0)->get();

        $users_id = [];

        foreach ($mensajes as $mensaje) {
            array_push($users_id, $mensaje->id);
        }

        $logros = DB::table('logro_user')
            ->join('logros', 'logros.id', '=', 'logro_user.logro_id')
            ->join('users', 'users.id', '=', 'logro_user.user_id')
            ->select('users.id', 'logros.icono')
            ->whereIn('users.id', $users_id)->get();

        return ['post' => $post, 'mensajes' => $mensajes, 'logros' => $logros];
    }
}
