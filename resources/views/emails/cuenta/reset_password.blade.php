<body>
    <h4>Hola</h4>
    <!-- Logo corporativo -->
    <img src="{{ asset('/images/logo.png') }}" height="100" />
    <p>Está recibiendo este correo electrónico porque recibimos una solicitud de restablecimiento de contraseña para su cuenta.</p>
    <a href="{{ $url }}">Restablecer Contraseña</a>
    <br>
    <small>Le saluda cordialmente, indie4all</small>
    <br>
    <p>El link expirará en {{ $count }} minutos. Si no solicitó un restablecimiento de contraseña, no es necesario realizar ninguna otra acción.</p>
</body>
