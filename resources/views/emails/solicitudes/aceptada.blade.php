<body>
    <h4>Hola {{ $name }}</h4>
    <!-- Logo corporativo -->
    <img src="{{ asset('/images/logo.png') }}" height="100" />
    <p>Su solicitud ha sido aceptada. Ya puede acceder a su panel de administración para empezar a administrar su perfil.</p>
    <a href="{{ $url }}">Accede al panel</a>
    <br>
    <small>Le saluda cordialmente, {{ $admin }}</small>
</body>
