<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use App\Models\Campania;
use App\Models\Desarrolladora;
use App\Models\Juego;
use App\Models\Master;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class BuscadorController extends Controller
{

    /**
     * Muestra todas los juegos y cuando es llamada con un objeto Request aplica un filtro de búsqueda
     *
     * @param  Request opciones por ajax para la búsqueda
     * @return \Illuminate\Http\Response
     */
    public function juegos(Request $request)
    {
        $juegos = Juego::query()->doesntHave('campania');
        if ($request->ajax()) {
            if ($request->nombre != '' || $request->genero != '' || $request->desarrolladora != '' || $request->precioMin != '' || $request->precioMax != '') {
                if ($request->nombre != '') {
                    $juegos = $juegos->where('nombre', 'like', '%' . $request->nombre . '%');
                }
                if ($request->genero != '') {
                    $juegos = $juegos->where('genero_id', $request->genero);
                }
                if ($request->desarrolladora != '') {
                    $juegos = $juegos->where('desarrolladora_id', $request->desarrolladora);
                }
                if ($request->precioMin != '') {
                    $juegos = $juegos->where('precio', '>=', $request->precioMin);
                }
                if ($request->precioMax != '') {
                    $juegos = $juegos->where('precio', '<=', $request->precioMax);
                }
                $juegos = $juegos->get();
            } else {
                $juegos = $juegos->paginate(8);
            }

            return view('usuario.pagination_data', ['juegos' => $juegos])->render();
        }
        $juegos = $juegos->paginate(8);
        return view('usuario.juegos_all', ['juegos' => $juegos]);
    }

    /**
     * Muestra todas los masters y cuando es llamada con un objeto Request aplica un filtro de búsqueda
     *
     * @param  Request opciones por ajax para la búsqueda 
     * @return \Illuminate\Http\Response
     */
    public function masters(Request $request)
    {
        $masters = Master::query();
        $masters->withCount('seguidores', 'posts');
        if ($request->ajax()) {
            if ($request->nombre != '' || $request->ordenarPor != '' || $request->desarrolladora != '' || $request->ordenarDe != '') {
                if ($request->ordenarPor != '') {
                    $masters = $masters->orderBy($request->ordenarPor, $request->ordenarDe);
                }
                if ($request->nombre != '') {
                    $masters = $masters->where('nombre', 'like', '%' . $request->nombre . '%')->orderBy('nombre', $request->ordenarDe);
                }
                $masters = $masters->get();
            } else {
                $masters = $masters->paginate(2);
            }
            return view('usuario.pagination_data', ['masters' => $masters])->render();
        }
        $masters = $masters->paginate(2);
        return view('usuario.masters_all', ['masters' => $masters]);
    }

    /**
     * Muestra todas las desarrolladoras y cuando es llamada con un objeto Request aplica un filtro de búsqueda
     *
     * @param  Request opciones por ajax para la búsqueda 
     * @return \Illuminate\Http\Response
     */
    public function desarrolladoras(Request $request)
    {
        $desarrolladoras = Desarrolladora::query();
        $desarrolladoras->withCount('users', 'posts', 'juegos');
        if ($request->ajax()) {
            if ($request->nombre != '' || $request->ordenarPor != '' || $request->desarrolladora != '' || $request->ordenarDe != '') {
                if ($request->ordenarPor != '') {
                    $desarrolladoras = $desarrolladoras->orderBy($request->ordenarPor, $request->ordenarDe);
                }
                if ($request->nombre != '') {
                    $desarrolladoras = $desarrolladoras->where('nombre', 'like', '%' . $request->nombre . '%')->orderBy('nombre', $request->ordenarDe);
                }
                $desarrolladoras = $desarrolladoras->get();
            } else {
                $desarrolladoras = $desarrolladoras->paginate(2);
            }
            return view('usuario.pagination_data', ['desarrolladoras' => $desarrolladoras])->render();
        }
        $desarrolladoras = $desarrolladoras->paginate(2);
        return view('usuario.desarrolladoras_all', ['desarrolladoras' => $desarrolladoras]);
    }

    /**
     * Muestra todas las campañas y cuando es llamada con un objeto Request aplica un filtro de búsqueda
     *
     * @param  Request opciones por ajax para la búsqueda 
     * @return \Illuminate\Http\Response
     */
    public function campanias(Request $request)
    {   
        
        $fechHoy = date('Y-m-d');
        $campanias = Campania::query();
        $campanias->where('fecha_fin','>=', $fechHoy)->withCount('compras', 'posts');
        if ($request->ajax()) {
            if ($request->nombre != '' || $request->ordenarPor != '' || $request->desarrolladora != '' || $request->ordenarDe != '') {
                if ($request->ordenarPor != '') {
                    $campanias = $campanias->orderBy($request->ordenarPor, $request->ordenarDe);
                }
                
                if ($request->nombre != '') {
                    $campanias = $campanias->where('nombre', 'like', '%' . $request->nombre . '%')->orderBy('nombre', $request->ordenarDe);
                }
                $campanias = $campanias->get();
            } else {
                $campanias = $campanias->paginate(2);
            }
            return view('usuario.pagination_data', ['campanias' => $campanias])->render();
        }
        $campanias = $campanias->paginate(2);
        return view('usuario.campanias_all', ['campanias' => $campanias]);
    }
}
