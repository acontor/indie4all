<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config("app.name", "Laravel") }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
        integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/usuario.css') }}" rel="stylesheet">
    <link href="{{ asset('css/animate/animate.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
    @yield("styles")
</head>

<body>
    <div id="app">
        @include("layouts.usuario.nav")
        @if(Cookie::get('laravel_cookie_consent') != 1)
            {{\Cookie::queue(\Cookie::forget('laravel_cookie_consent'))}}
            <nav class="navbar navbar-expand-md footer fixed-bottom navbar-dark shadow-sm bg-danger text-light nav-alert nav-cookie">
                <span class="mx-auto">@include('cookieConsent::index')</span>
            </nav>
        @endif
        @if (Auth::user() != null && Auth::user()->ban)
            <nav class="navbar navbar-expand-md navbar-dark shadow-sm bg-dark text-light nav-alert">
                <span class="mx-auto">Su cuenta se encuentra baneada. No podrá hacer uso de las funciones sociales de la plataforma. Accede a <a href="{{ route('usuario.cuenta.index') }}">Mi Cuenta</a> para ver el motivo.</span>
            </nav>
        @endif
        @if (Auth::user() != null && Auth::user()->email_verified_at == null)
            <nav class="navbar navbar-expand-md navbar-dark shadow-sm bg-dark text-light nav-alert">
                <span class="verify-alert mx-auto">Para utilizar las funciones sociales de la plataforma verifique su cuenta. Haz clic <a class="verify-link">aquí</a> para recibir el email de verificación</span>
            </nav>
        @endif
        @yield("content")
        @if(Auth::user() && Auth::user()->master()->count() != 0)
            <a href="{{ route('usuario.master.show', Auth::user()->master()->first()->id) }}">
                <div class="perfil">
                    <i class="fas fa-user" aria-hidden="true"></i>
                </div>
            </a>
            <a href="{{ route('master.analisis.create', 0) }}">
                <div class="analisis">
                    <i class="fas fa-feather-alt" aria-hidden="true"></i>
                </div>
            </a>
            <a href="#">
                <div class="estado">
                    <i class="fas fa-brain" aria-hidden="true"></i>
                </div>
            </a>
        @endif
        @if(Auth::user() && Auth::user()->cm()->count() != 0)
            <a href="{{ route('usuario.desarrolladora.show', Auth::user()->cm()->first()->id) }}">
                <div class="perfil">
                    <i class="fas fa-user" aria-hidden="true"></i>
                </div>
            </a>
            <a href="{{ route('cm.juego.create') }}">
                <div class="juego">
                    <i class="fas fa-gamepad" aria-hidden="true"></i>
                </div>
            </a>
            <a href="{{ route('cm.campania.create') }}">
                <div class="campania">
                    <i class="fas fa-bullhorn" aria-hidden="true"></i>
                </div>
            </a>
        @endif
    </div>
    @include("layouts.usuario.footer")
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script src="https://cdn.ckeditor.com/4.15.0/standard/ckeditor.js"></script>
    <script src="https://www.google.com/recaptcha/api.js"></script>
    <script src="{{ asset('js/sweetalert/sweetalert.min.js') }}"></script>
    <script src="{{ asset('js/script.js') }}"></script>
    <script src="{{ asset('js/usuario.js') }}"></script>
    @yield("scripts")
    <script>
        $(function () {
            $(".estado").parent().on("click", function(e) {
                e.preventDefault();
                nuevoEstado('{{ asset("js/ckeditor/config.js") }}');
            });
        });
    </script>
</body>

</html>
