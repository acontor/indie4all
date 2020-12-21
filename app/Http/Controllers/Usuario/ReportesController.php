<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use App\Models\Reporte;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportesController extends Controller
{
    public function reporte(Request $request)
    {
        Reporte::create([
            $request->tipo =>  $request->id,
            'user_id' => Auth::id(),
            'motivo' => $request->motivo,
        ]);

        return 'El reporte se ha llevado a cabo con éxito';
    }
}
