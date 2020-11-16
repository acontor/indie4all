<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use App\Models\Master;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class MasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $masters = Master::all();

        return view('usuario.masters', ['masters' => $masters]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $usuario = User::find(Auth::id())->masters()->where('master_id', '=', $id)->first();
        $master = Master::find($id);
        return view('usuario.master', ['master' => $master, 'usuario' => $usuario]);
    }

    public function follow($id)
    {
        $user = User::find(Auth::id());
        $user->masters()->sync([$id => ['notificacion' => true]]);

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
}
