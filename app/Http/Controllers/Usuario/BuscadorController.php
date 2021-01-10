<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use App\Models\Campania;
use App\Models\Desarrolladora;
use App\Models\Juego;
use App\Models\Master;
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
            if ($request->page == '' && $request->ordenarPor != 'null' || $request->nombre != '' || $request->genero != '' || $request->desarrolladora != '' || $request->precioMin != '' || $request->precioMax != '' || $request->fechaDesde != '' || $request->fechaHasta != '') {
                if ($request->ordenarPor != 'null' && $request->ordenarDe != 'null') {
                    $juegos = $juegos->orderBy($request->ordenarPor, $request->ordenarDe);
                }
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
                if ($request->fechaDesde != '') {
                    $juegos = $juegos->where('fecha_lanzamiento', '>=', $request->fechaDesde);
                }
                if ($request->fechaHasta != '') {
                    $juegos = $juegos->where('fecha_lanzamiento', '<=', $request->fechaHasta);
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
        if ($request->genero != '') {
            $juegos = $juegos->where('genero_id', $request->genero)->get();
        } else {
            $juegos = $juegos->paginate(8);
        }
        return view('usuario.juegos_all', ['juegos' => $juegos ,'genero'=>$request->genero]);
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
            if ($request->page == '' && $request->nombre != '' || $request->ordenarPor != '' || $request->desarrolladora != '' || $request->ordenarDe != 'null') {
                if ($request->ordenarPor != 'null' && $request->ordenarDe != 'null') {
                    $masters = $masters->orderBy($request->ordenarPor, $request->ordenarDe);
                }
                if ($request->nombre != '') {
                    $masters = $masters->where('nombre', 'like', '%' . $request->nombre . '%')->orderBy('nombre', $request->ordenarDe);
                }
                $masters = $masters->get();
            } else {
                $masters = $masters->paginate(8);
            }
            return view('usuario.pagination_data', ['masters' => $masters])->render();
        }
        $masters = $masters->paginate(8);
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
        $desarrolladoras->withCount('users', 'posts', 'juegos', 'sorteos', 'encuestas');
        if ($request->ajax()) {
            if ($request->page == '' && $request->nombre != '' || $request->ordenarPor != '' || $request->desarrolladora != '' || $request->ordenarPor != 'null') {
                if ($request->ordenarPor != 'null' && $request->ordenarDe != 'null') {
                    $desarrolladoras = $desarrolladoras->orderBy($request->ordenarPor, $request->ordenarDe);
                }
                if ($request->nombre != '') {
                    $desarrolladoras = $desarrolladoras->where('nombre', 'like', '%' . $request->nombre . '%')->orderBy('nombre', $request->ordenarDe);
                }

                if ($request->nombre != '') {
                    $desarrolladoras = $desarrolladoras->where('nombre', 'like', '%' . $request->nombre . '%');
                }
                $desarrolladoras = $desarrolladoras->get();
            } else {
                $desarrolladoras = $desarrolladoras->paginate(8);
            }
            return view('usuario.pagination_data', ['desarrolladoras' => $desarrolladoras])->render();
        }
        $desarrolladoras = $desarrolladoras->paginate(8);
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
        $campanias->where('fecha_fin', '>=', $fechHoy)->withCount('compras', 'posts');
        if ($request->ajax()) {
            if ($request->page == '' && $request->nombre != '' || $request->ordenarPor != '' || $request->desarrolladora != '' || $request->ordenarPor != 'null' || $request->aporteMinMax != '' || $request->aporteMinMin != '') {
                if ($request->ordenarPor != 'null' && $request->ordenarDe != 'null') {
                    $campanias = $campanias->orderBy($request->ordenarPor, $request->ordenarDe);
                }
                if ($request->nombre != '') {
                    $campanias = $campanias->where('nombre', 'like', '%' . $request->nombre . '%');
                }
                if ($request->aporteMinMin != '') {
                    $campanias = $campanias->where('aporte_minimo', '>=', $request->aporteMinMin);
                }
                if ($request->aporteMinMax != '') {
                    $campanias = $campanias->where('aporte_minimo', '<=', $request->aporteMinMax);
                }
                $campanias = $campanias->get();
            } else {
                $campanias = $campanias->paginate(8);
            }
            return view('usuario.pagination_data', ['campanias' => $campanias])->render();
        }
        $campanias = $campanias->paginate(8);
        return view('usuario.campanias_all', ['campanias' => $campanias]);
    }
}
