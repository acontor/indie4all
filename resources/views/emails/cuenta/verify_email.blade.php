<body>
    <h4>Hola</h4>
    <!-- Logo corporativo -->
    <img src="{{ asset('/images/default.png') }}" height="100" />
    <p>Haga clic en el botón de abajo para verificar su dirección de correo electrónico.</p>
    <a href="{{ $verificationUrl }}">Verificar Email</a>
    <br>
    <small>Le saluda cordialmente, indie4all</small>
    <br>
    <p>Si no solicitó un restablecimiento de contraseña, no es necesario realizar ninguna otra acción.</p>
</body>