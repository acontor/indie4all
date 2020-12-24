<body>
    <h4>Hola {{ $name }}</h4>
    <img src="{{ asset('/images/default.png') }}" height="100" />
    <p>¡Enhorabuena!, has sido el ganador del sorteo {{ $sorteo->titulo }} de {{ $desarrolladora->nombre }}</p>
    <p>Premio: {{ $sorteo->descripcion }}</p>
    <p>Si la desarrolladora no le contacta en 5 días contacte con ella a {{ $desarrolladora->email }} o ponte en contacto con soporte@indie4all.com</p>
    <br>
    <small>Le saluda cordialmente, Indie4all</small>
</body>
