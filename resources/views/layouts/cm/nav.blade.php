<nav class="navbar navbar-expand navbar-dark">
    <div class="container">

        <!-- Right Side Of Navbar -->
        <ul class="navbar-nav ml-auto align-items-center">
            <li class="nav-item dropdown">
                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false" v-pre>
                    <i class="fas fa-user"></i>{{-- {{ Auth::user()->name }}
                    --}}
                </a>

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{ route("home") }}">
                        Página de inicio
                    </a>
                    <a class="dropdown-item" href="{{ route("logout") }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Cerrar sesión
                    </a>

                    <form id="logout-form" action="{{ route("logout") }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </li>
        </ul>
    </div>
</nav>
