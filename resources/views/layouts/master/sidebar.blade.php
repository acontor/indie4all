<nav class="sidebar">
    <ul>
        <li class="@if(Request::is('master')){{ 'menu-active' }}@endif"><a href="{{ route('master.index') }}"><i class="fas fa-home"></i>Inicio</a></li>
        <li class="@if(Request::is('master/perfil')){{ 'menu-active' }}@endif"><a href="{{ route('master.perfil.index') }}"><i class="fas fa-building"></i>Perfil</a></li>
        <li class="@if(Request::is('master/analisis*')){{ 'menu-active' }}@endif"><a href="{{ route('master.analisis.index') }}"><i class="fas fa-newspaper"></i>Análisis</a></li>
    </ul>
</nav>
