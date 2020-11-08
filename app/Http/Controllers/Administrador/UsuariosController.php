<?php

namespace App\Http\Controllers\Administrador;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Master;
use App\Models\Fan;
use App\Models\Cm;
use Illuminate\Http\Request;

class UsuariosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usuarios = User::paginate(5);
        $num_masters = Master::all()->count();
        $num_fans = Fan::all()->count();
        $num_cms = CM::all()->count();
        return view('admin.usuarios', compact('usuarios', 'num_masters', 'num_fans', 'num_cms'));
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
            'name' => 'required',
            'email' => 'required',
        ]);

        User::find($id)->update($request->all());

        return redirect('/admin/usuarios')->with('success', '¡Usuario actualizado!');
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

    public function test()
    {
    	return view('admin.test');
    }
    public function selectSearch(Request $request)
    {
    	$usuarios = [];

        if($request->has('q')){
            $search = $request->q;
            $usuarios =User::select("id", "name")
            		->where('name', 'LIKE', "%$search%")
            		->get();
        }
        return response()->json($usuarios);
    }
}
