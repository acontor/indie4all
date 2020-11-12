<?php

namespace App\Http\Controllers\Administrador;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Master;
use App\Models\Fan;
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usuarios = User::all();
        $num_masters = Master::all()->count();
        $num_fans = Fan::all()->count();
        $num_cms = CM::all()->count();
        return view('admin.usuarios', ['usuarios' => $usuarios, 'num_masters' => $num_masters, 'num_fans' => $num_fans, 'num_cms' => $num_cms]);
    }

    public function create()
    {
        return view('admin.usuarios_editor');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect('/admin/usuarios')->with('success', 'Usuario creado!');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
        ]);

        User::find($id)->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect('/admin/usuarios')->with('success', '¡Usuario actualizado!');
    }

    public function edit($id)
    {
        $usuario = User::find($id);
        return view('admin.usuarios_editor', ['usuario' => $usuario]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect('/admin/usuarios')->with('success', '¡Usuario borrado!');
    }

    /*
    public function selectSearch(Request $request)
    {
        $usuarios = [];

        if ($request->has('q')) {
            $search = $request->q;
            $usuarios = User::select("id", "name")
                ->where('name', 'LIKE', "%$search%")
                ->get();
        }
        return response()->json($usuarios);
    }
    */
}
