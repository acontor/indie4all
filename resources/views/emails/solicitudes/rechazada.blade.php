<body>
    <h4>Hola {{ $name }}</h4>
    <!-- Logo corporativo -->
    <img src="{{ asset('/images/logo.png') }}" height="100" />
    <p>Su solicitud ha sido rechazada por los siguientes motivos:</p>
    <ul>
        <li style="list-style-type: none;">{{ $motivo }}</li>
    </ul>
    <p>Puedes ponerte en contacto con nosotros para saber más.</p>
    <br>
    <small>Le saluda cordialmente, {{ $admin }}</small>
</body>
