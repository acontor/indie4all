<nav class="sidebar">
    <ul>
        <li class="@if(Request::is('admin')){{ 'menu-active' }}@endif"><a href="{{ route('admin.index') }}"><i class="fas fa-home"></i>Inicio</a></li>
        <li class="@if(Request::is('admin/noticia*')){{ 'menu-active' }}@endif"><a href="{{ route('admin.noticias.index') }}"><i class="fas fa-newspaper"></i>Noticias</a></li>
        <li class="@if(Request::is('admin/usuario*')){{ 'menu-active' }}@endif"><a href="{{ route('admin.usuarios.index') }}"><i class="fas fa-users"></i>Usuarios</a></li>
        <li class="@if(Request::is('admin/desarrolladora*')){{ 'menu-active' }}@endif"><a href="{{ route('admin.desarrolladoras.index') }}"><i class="fas fa-building"></i>Desarrolladoras</a></li>
        <li class="@if(Request::is('admin/juego*')){{ 'menu-active' }}@endif"><a href="{{ route('admin.juegos.index') }}"><i class="fas fa-gamepad"></i>Juegos</a></li>
        <li class="@if(Request::is('admin/campania*')){{ 'menu-active' }}@endif"><a href="{{ route('admin.campanias.index') }}"><i class="fas fa-bullhorn"></i>Campañas</a></li>
        <li class="@if(Request::is('admin/genero*')){{ 'menu-active' }}@endif"><a href="{{ route('admin.generos.index') }}"><i class="fas fa-puzzle-piece"></i>Géneros</a></li>
        <li class="@if(Request::is('admin/logro*')){{ 'menu-active' }}@endif"><a href="{{ route('admin.logros.index') }}"><i class="fas fa-trophy"></i>Logros</a></li>
    </ul>
</nav>
