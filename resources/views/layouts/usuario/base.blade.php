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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/i18n/es.js"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
        integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/usuario.css') }}" rel="stylesheet">
    <link href="{{ asset('css/animate.min.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    @yield("styles")
</head>

<body>
    <div id="app">
        @include("layouts.usuario.nav")
        @if (Auth::user() != null && Auth::user()->ban)
        <nav class="navbar navbar-expand-md navbar-dark shadow-sm bg-dark text-light">
            <span class="mx-auto">Su cuenta se encuentra baneada. No podrá hacer uso de las funciones sociales de la plataforma. Accede a <a href="{{ route('usuario.cuenta.index') }}">Mi Cuenta</a> para ver el motivo.</span>
        </nav>
        @endif
        @if (Auth::user() != null && Auth::user()->email_verified_at == null)
        <nav class="navbar navbar-expand-md navbar-dark shadow-sm bg-dark text-light">
            <span class="verify-alert mx-auto">Para utilizar las funciones sociales de la plataforma verifique su cuenta. Haz clic <a class="verify-link">aquí</a> para recibir el email de verificación</span>
        </nav>
        @endif
        @yield("content")
    </div>
    @yield("scripts")
    <script src="{{ asset('js/sweetalert.min.js') }}"></script>
    <script>
        $(function() {
            $(document).keydown(function(event) {
                if (event.ctrlKey && event.code == "KeyY") {
                    busqueda();
                }
            });

            $(".search").click(busqueda);

            $(".verify-link").click(verificar);
        });

        function busqueda() {
            Swal.fire({
                position: 'top',
                title: '<div class="input-group"><div class="input-group-prepend"><span class="input-group-text bg-light"><i class="fas fa-search"></i></span></div><input type="text" class="form-control" placeholder="Buscar" id="busqueda" autocomplete="off"></div>',
                html: '<small><span class="badge badge-secondary d-none d-md-inline">Tab</span> Moverse entre los resultados <span class="badge badge-secondary ml-3">Esc</span> Cerrar búsqueda</small><div></div>',
                showCloseButton: false,
                showCancelButton: false,
                showConfirmButton: false,
                customClass: 'swal-height',
                showClass: {
                    popup: 'animate__animated animate__zoomIn'
                },
                hideClass: {
                    popup: 'animate__animated animate__zoomOut'
                }
            });

            $("#busqueda").keyup(function() {
                $(".swal2-html-container>div").html("");
                if($("#busqueda").val() != "") {
                    $.ajax({
                        url: "{{ route('usuario.busqueda') }}",
                        datatype: "json",
                        data: {
                            q: $("#busqueda").val(),
                        },
                        success: function(data) {
                            let html = '<div class="list-group mb-4 mt-2 mr-3">';
                            if(data.length == 0) {
                                $(".swal2-html-container>div").append('<p class="mt-3">No se ha encontrado ningún resultado</p>');
                            } else {
                                data.forEach(element => {
                                    if(element.tipo == "Juego") {
                                        if(html.indexOf("<h4 class='mt-2 mb-2'>Juegos</h4>") == -1) {
                                            html += `<h4 class='mt-2 mb-2'>Juegos</h4><small><a href="{{ route('usuario.juegos.all') }}">Ver todos</a></small>`;
                                        }
                                        let url = '{{ route("usuario.juego.show", ":id") }}';
                                        url = url.replace(':id', element.id);
                                        html += `<a href="${url}" class="list-group-item list-group-item-action">${element.nombre}</a>`;
                                    } else if (element.tipo == "Desarrolladora") {
                                        if(html.indexOf("<h4 class='mt-2 mb-2'>Desarrolladoras</h4>") == -1) {
                                            html += `<h4 class='mt-2 mb-2'>Desarrolladoras</h4><small><a href="{{ route('usuario.desarrolladoras.all') }}">Ver todas</a></small>`;
                                        }
                                        let url = '{{ route("usuario.desarrolladora.show", ":id") }}';
                                        url = url.replace(':id', element.id);
                                        html += `<a href="${url}" class="list-group-item list-group-item-action">${element.nombre}</a>`;
                                    } else if (element.tipo == "Master") {
                                        if(html.indexOf("<h4 class='mt-2 mb-2'>Masters</h4>") == -1) {
                                            html += `<h4 class='mt-2 mb-2'>Masters</h4><small><a href="{{ route('usuario.masters.all') }}">Ver todas</a></small>`;
                                        }
                                        let url = '{{ route("usuario.master.show", ":id") }}';
                                        url = url.replace(':id', element.id);
                                        html += `<a href="${url}" class="list-group-item list-group-item-action">${element.nombre}</a>`;
                                    }
                                });
                                html += '</ul>';
                                $(".swal2-html-container>div").append(html);
                            }
                        }
                    });
                }
            });
        }

        function verificar() {
            $.ajax({
                url: "{{ route('verification.resend') }}",
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    $(".verify-alert").html("El correo debe haberse enviado a su bandeja de entrada. Compruebe su bandeja de spam si no le llega.")
                }
            });
        }

    </script>
</body>

</html>
