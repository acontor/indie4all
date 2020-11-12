<nav class="sidebar">
    <ul>
        <li class="@if(Request::is('cm')){{ "menu-active" }}@endif"><a href="{{ route('cm.index') }}"><i class="fas fa-home"></i>Inicio</a></li>
        <li class="@if(Request::is('cm/desarrolladora')){{ "menu-active" }}@endif"><a href="{{ route('cm.desarrolladora.index') }}"><i class="fas fa-building"></i>Desarrolladora</a></li>
        <li class="@if(Request::is('cm/juegos*')){{ "menu-active" }}@endif"><a href="{{ route('cm.juegos.index') }}"><i class="fas fa-gamepad"></i>Juegos</a></li>
        <li><a><i class="fas fa-bullhorn"></i>Campañas</a></li>
        <li><a><i class="fas fa-gift"></i>Sorteos</a></li>
        <li><a><i class="fas fa-poll"></i>Encuestas</a></li>
    </ul>
</nav>
