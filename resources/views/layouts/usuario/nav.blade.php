<nav class="navbar navbar-expand-md navbar-dark shadow-sm">
    <a class="navbar-brand d-md-none d-inline" href="{{ url('/') }}">
        <img src="{{ asset('images/logo.png') }}" width="50" alt="">
    </a>
    <button class="btn btn-warning search">
        <span class="badge badge-dark d-none d-md-inline">ctrl + y</span><i class="fas fa-search d-inline ml-md-2"></i>
    </button>
    <button class="navbar-toggler ml-1" type="button" data-toggle="collapse" data-target="#collapsingNavbar2">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="navbar-collapse collapse justify-content-between align-items-center w-100" id="collapsingNavbar2">
        <ul class="navbar-nav mx-auto text-md-center text-left">
            <li class="nav-item">
                <a href="{{ url('/') }}" class="nav-link navbar-brand mx-0 d-none d-md-inline">
                    <img src="{{ asset('images/logo.png') }}" class="img-fluid" width="50" alt="">
                </a>
            </li>
            @auth
                <li class="nav-item mt-1">
                    <a class="nav-link" href="{{ route('home') }}">Portal</a>
                </li>
            @endauth
            <li class="nav-item mt-1">
                <a class="nav-link" href="{{ route('usuario.masters.index') }}">Masters</a>
            </li>
            <li class="nav-item mt-1">
                <a class="nav-link" href="{{ route('usuario.desarrolladoras.index') }}">Desarrolladoras</a>
            </li>
            <li class="nav-item mt-1">
                <a class="nav-link" href="{{ route('usuario.juegos.index') }}">Juegos</a>
            </li>
            <li class="nav-item mt-1">
                <a class="nav-link" href="{{ route('usuario.campanias.all') }}">Campañas</a>
            </li>
        </ul>
        <ul class="nav navbar-nav">
            @guest
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">{{ __("Login") }} / {{ __("Register") }}</a>
                </li>
            @else
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->name }}
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('usuario.cuenta.index') }}">
                            Mi cuenta
                        </a>
                        @if(App\Models\Administrador::where("user_id", Auth::id())->count() == 1)
                            <a class="dropdown-item" href="{{ route('admin.index') }}">
                                Panel de administración
                            </a>
                        @elseif(App\Models\Cm::where("user_id", Auth::id())->count() == 1)
                            <a class="dropdown-item" href="{{ route('cm.index') }}">
                                Panel de desarrolladora
                            </a>
                        @elseif(App\Models\Master::where("user_id", Auth::id())->count() == 1)
                            <a class="dropdown-item" href="{{ route('master.index') }}">
                                Panel de master
                            </a>
                        @endif
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            {{ __("Logout") }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>
            @endguest
        </ul>
    </div>
</nav>
