<?php

namespace App\Http\Controllers\Administrador;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Master;
use App\Models\Cm;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class UsuariosController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    /**
     * Muestra el listado de todos los usuarios.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usuarios = User::all();
        $numMasters = Master::all()->count();
        $numCms = CM::all()->count();

        return view('admin.usuarios', ['usuarios' => $usuarios, 'numMasters' => $numMasters, 'numCms' => $numCms]);
    }

    /**
     * Muestra el formulario de creación de usuarios.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.usuarios_editor');
    }

    /**
     * Almacena el usuarios creado.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:users'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $usuario = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if ($usuario->exists) {
            session()->flash('success', 'El usuario ha sido creado');
        } else {
            session()->flash('error', 'El usuario no se ha podido crear');
        }

        return redirect('/admin/usuarios');
    }

    /**
     * Muestra el formulario para editar al usuario seleccionado.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $usuario = User::find($id);

        return view('admin.usuarios_editor', ['usuario' => $usuario]);
    }

    /**
     * Actualiza el usuario seleccionado.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $usuario = User::find($id);

        $request->validate([
            'name' => $usuario->name !== $request->name ? ['required', 'string', 'unique:users', 'max:255'] : ['required', 'string', 'max:255'],
            'username' => $usuario->username !== $request->username ? ['required', 'string', 'unique:users', 'max:255'] : ['required', 'string', 'max:255'],
            'email' => $usuario->email !== $request->email ? ['required', 'string', 'email', 'max:255', 'unique:users'] : ['required', 'string', 'email', 'max:255'],
        ]);

        $usuario->update([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
        ]);

        session()->flash('success', 'El usuario se ha actualizado');

        return redirect('/admin/usuarios');
    }

    /**
     * Elimina al usuario seleccionado.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $usuario = User::find($id);

        $usuario->delete();

        if (!$usuario->exists) {
            session()->flash('success', 'El usuario se ha eliminado');
        } else {
            session()->flash('error', 'El usuario no se ha podido eliminar');
        }

        return redirect('/admin/usuarios');
    }

    /**
     * Banea un usuario.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return String
     */
    public function ban($id, Request $request)
    {
        $usuario = User::find($id);

        $usuario->update([
            'ban' => true,
            'motivo' => $request->motivo,
        ]);

        return 'El usuario ' . $usuario->nombre . ' ha sido baneado';
    }

    /**
     * Elimina el ban a un usuario.
     *
     * @param  int  $id
     * @return String
     */
    public function unban($id)
    {
        $usuario = User::find($id);

        $usuario->update([
            'ban' => false,
            'motivo' => null,
            'reportes' => $usuario->reportes + 1,
        ]);

        return 'El usuario ' . $usuario->name . ' ya no está baneado';
    }
}
