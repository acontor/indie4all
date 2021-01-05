@extends("layouts.usuario.base")

@section('content')
    <main class="p-3 pb-5">
        <div class="container bg-light p-3 shadow-lg rounded mt-4">
            <img src="{{ asset('images/logo.png') }}" class="img-fluid mb-3 mx-auto d-block">
            <h1 class="mt-3 mb-5 text-center">¿Quieres ser master?</h1>
            <p>¡Buenas apasionado de los juegos indies!</p>
            <p>¿Disfrutar de nuestros juegos y realizar comentarios se te ha quedado corto?</p>
            <p>¿Buscas nuevos desafíos?</p>
            <p class="mb-5">Te invitamos a que rellenes la solicitud para pasar a formar parte de nuestro exclusivo círculo
                de Masters. Analiza tus juegos favoritos y comparte tus pensamientos. Crea tu propia comunidad e intenta
                llegar a más gente.</p>
            @if (Auth::user() && !Auth::user()->cm && !Auth::user()->master && Auth::user()->reportes == 0 && !Auth::user()->ban && !Auth::user()->solicitud && Auth::user()->hasVerifiedEmail())
                <p>Rellena el siguiente formulario y te responderemos en 24/48 horas.</p>
                <a class="btn btn-dark" href="{{ route('usuario.solicitud.create', 'Master') }}">Realizar solicitud</a>
            @elseif(Auth::user()->solicitud && Auth::user()->solicitud->tipo == "Master")
                <p><b>¡Tu solicitud se está procesando!</b></p>
            @else
                <small>Para realizar una solicitud debes cumplir las siguientes condiciones:
                    <ul class="ml-5 mt-3 list-unstyled">
                        <li>Estar registrado en nuestra plataforma</li>
                        <li>No pertenecer a una desarrolladora</li>
                        <li>No haber recibido baneos en el tiempo que lleves formando parte de nuestra familia</li>
                        <li>Verificar tu cuenta</li>
                        <li>Disponer de todos los logros</li>
                    </ul>
                    Puedes realizar una solicitud especial si eres especialista en prensa del videojuego contactando a
                    soporte@indie4all.com
                    Si tienes algún problema, contacta con soporte@indie4all.com
                </small>
            @endif
            <p class="mt-5">¡Te esperamos con los brazos abiertos!</p>
        </div>
    </main>
@endsection

@section('scripts')
    <script src="{{ asset('js/script.js') }}"></script>
    @if (Session::has('success'))
        <script defer>
            notificacionEstado('success', "{{ Session::get('success') }}");

        </script>
    @elseif(Session::has('error'))
        <script defer>
            notificacionEstado('error', "{{ Session::get('error') }}");

        </script>
    @endif
@endsection
