<body>
    <h4>Hola {{ $name }}</h4>
    <!-- Logo corporativo -->
    <img src="{{ asset('/images/logo.png') }}" height="100" />
    <p>Se ha registrado tu participación en el sorteo de {{ $desarrolladora }}</p>
    <ul>
        <li>Nombre: {{ $sorteo->titulo }}</li>
        <li>Descripción: {{ $sorteo->descripcion }}</li>
        <li>Fecha fin: {{ $sorteo->fecha_fin }}</li>
    </ul>
    <br>
    <small>Le saluda cordialmente, Indie4all</small>
</body>
