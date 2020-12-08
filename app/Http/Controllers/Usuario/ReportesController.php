<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use App\Models\Campania;
use App\Models\Desarrolladora;
use App\Models\Juego;
use App\Models\Mensaje;
use App\Models\Post;
use App\Models\User;

class ReportesController extends Controller
{
    public function reporte($id, $tipo)
    {
        switch ($tipo) {
            case 'campania':
                $objectoReporte =  Campania::find($id);
                break;
            case 'desarrolladora':
                $objectoReporte = Desarrolladora::find($id);
                break;
            case 'juego':
                $objectoReporte = Juego::find($id);
                break;
            case 'mensaje':
                $objectoReporte = Mensaje::find($id);
                break;
            case 'post':
                $objectoReporte = Post::find($id);
                break;
            case 'user':
                $objectoReporte = User::find($id);
                break;
            default:
                return 'No éxiste la entidad que quieres reportar.';
        }

        $numReport = $objectoReporte->reportes;
        $objectoReporte->reportes = $numReport + 1;
        $objectoReporte->save();

        return 'El reporte se ha llevado a cabo con éxito';
    }
}
