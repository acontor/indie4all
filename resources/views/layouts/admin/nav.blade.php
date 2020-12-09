<nav class="navbar navbar-expand navbar-dark">
    <div class="container">
        <!-- Right Side Of Navbar -->
        <ul class="navbar-nav ml-auto align-items-center">
            <!-- Según las solicitudes que tenga el usuario -->
            @php
            $solicitudes = \App\Models\Solicitud::all()->count();
            $reportes = \Illuminate\Support\Facades\DB::table('reportes')->select('desarrolladora_id')->where('desarrolladora_id', '!=', null)->groupBy('desarrolladora_id')->havingRaw('COUNT(*) >= 3')->get()->count() + \Illuminate\Support\Facades\DB::table('reportes')->select('post_id')->where('post_id', '!=', null)->groupBy('post_id')->havingRaw('COUNT(*) >= 3')->get()->count() + \Illuminate\Support\Facades\DB::table('reportes')->select('mensaje_id')->where('mensaje_id', '!=', null)->groupBy('mensaje_id')->havingRaw('COUNT(*) >= 3')->get()->count() + \Illuminate\Support\Facades\DB::table('reportes')->select('juego_id')->where('juego_id', '!=', null)->groupBy('juego_id')->havingRaw('COUNT(*) >= 3')->get()->count() + \Illuminate\Support\Facades\DB::table('reportes')->select('campania_id')->where('campania_id', '!=', null)->groupBy('campania_id')->havingRaw('COUNT(*) >= 3')->get()->count() + \Illuminate\Support\Facades\DB::table('reportes')->select('encuesta_id')->where('encuesta_id', '!=', null)->groupBy('encuesta_id')->havingRaw('COUNT(*) >= 3')->get()->count() + \Illuminate\Support\Facades\DB::table('reportes')->select('sorteo_id')->where('sorteo_id', '!=', null)->groupBy('sorteo_id')->havingRaw('COUNT(*) >= 3')->get()->count() + \Illuminate\Support\Facades\DB::table('reportes')->select('master_id')->where('master_id', '!=', null)->groupBy('master_id')->havingRaw('COUNT(*) >= 3')->get()->count();
            @endphp
            @if ($reportes > 0)
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.reportes.index') }}" role="button" aria-haspopup="true"
                        aria-expanded="false" v-pre>
                        <i class="fas fa-flag"></i>
                        <span class="badge badge-warning" id="messages-count">
                            {{ $reportes }}
                        </span>
                    </a>
                </li>
            @endif
            @if ($solicitudes > 0)
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.solicitudes.index') }}" role="button" aria-haspopup="true"
                        aria-expanded="false" v-pre>
                        <i class="fas fa-envelope"></i>
                        <span class="badge badge-warning" id="messages-count">
                            {{ $solicitudes }}
                        </span>
                    </a>
                </li>
            @endif

            <li class="nav-item dropdown">
                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false" v-pre>
                    <i class="fas fa-user"></i>{{-- {{ Auth::user()->name }}
                    --}}
                </a>

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{ route('home') }}">
                        Página de inicio
                    </a>
                    <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Cerrar sesión
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </li>
        </ul>
    </div>
</nav>
