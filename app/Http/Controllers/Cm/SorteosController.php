<?php

namespace App\Http\Controllers\Cm;

use App\Http\Controllers\Controller;
use App\Models\Cm;
use App\Models\Desarrolladora;
use Illuminate\Support\Facades\Auth;

class SorteosController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('cm');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sorteos = Desarrolladora::find(Cm::where('user_id', Auth::id())->first()->desarrolladora_id)->sorteos;

        return view('cm.sorteos', ['sorteos' => $sorteos]);
    }
}
