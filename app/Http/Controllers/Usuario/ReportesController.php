<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use App\Models\Reporte;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportesController extends Controller
{
    public function reporte($id, $tipo, Request $request)
    {
        switch ($tipo) {
            case 'campania':
                Reporte::create([
                    'campania_id' => $id,
                    'user_id' => Auth::id(),
                    'motivo' => $request->motivo,
                ]);
                break;
            case 'desarrolladora':
                Reporte::create([
                    'desarrolladora_id' => $id,
                    'user_id' => Auth::id(),
                    'motivo' => $request->motivo,
                ]);
                break;
            case 'juego':
                Reporte::create([
                    'juego_id' => $id,
                    'user_id' => Auth::id(),
                    'motivo' => $request->motivo,
                ]);
                break;
            case 'mensaje':
                Reporte::create([
                    'mensaje_id' => $id,
                    'user_id' => Auth::id(),
                    'motivo' => $request->motivo,
                ]);
                break;
            case 'post':
                Reporte::create([
                    'post_id' => $id,
                    'user_id' => Auth::id(),
                    'motivo' => $request->motivo,
                ]);
                break;
            case 'master':
                Reporte::create([
                    'master_id' => $id,
                    'user_id' => Auth::id(),
                    'motivo' => $request->motivo,
                ]);
                break;
            case 'encuesta':
                Reporte::create([
                    'encuesta_id' => $id,
                    'user_id' => Auth::id(),
                    'motivo' => $request->motivo,
                ]);
                break;
            case 'sorteo':
                Reporte::create([
                    'sorteo_id' => $id,
                    'user_id' => Auth::id(),
                    'motivo' => $request->motivo,
                ]);
                break;
            default:
                return 'No éxiste la entidad que quieres reportar.';
        }

        return 'El reporte se ha llevado a cabo con éxito';
    }
}
