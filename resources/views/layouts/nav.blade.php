<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <a class="navbar-brand" href="{{ url('/') }}">
        {{ config('app.name', 'Laravel') }}
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <!-- Left Side Of Navbar -->
        <ul class="navbar-nav mr-auto">
            @auth
            <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">{{ __('Home') }}</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('usuario.desarrolladoras.index') }}">{{ __('Desarrolladoras') }}</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('usuario.juegos.index') }}">{{ __('Juegos') }}</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('usuario.masters.index') }}">{{ __('Masters') }}</a></li>
            @if(App\Models\Cm::where('user_id', Auth::id())->count() == 1)
            <li class="nav-item"><a class="nav-link" href="{{ route('usuario.desarrolladora.show', App\Models\Cm::where('user_id', Auth::id())->first()->desarrolladora_id) }}">Mi desarrolladora</a></li>
            @endif
            @endauth
        </ul>

        <!-- Right Side Of Navbar -->
        <ul class="navbar-nav ml-auto">
            <!-- Authentication Links -->
            @guest
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                </li>
                @if (Route::has('register'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                    </li>
                @endif
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
                        @if(App\Models\Administrador::where('user_id', Auth::id())->count() == 1)
                            <a class="dropdown-item" href="{{ route('admin.index') }}">
                                Panel de administración
                            </a>
                        @elseif(App\Models\Cm::where('user_id', Auth::id())->count() == 1)
                            <a class="dropdown-item" href="{{ route('cm.index') }}">
                                Panel de desarrolladora
                            </a>
                        @elseif(App\Models\Master::where('user_id', Auth::id())->count() == 1)
                            <a class="dropdown-item" href="{{ route('admin.index') }}">
                                Panel de master
                            </a>
                        @endif
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
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
