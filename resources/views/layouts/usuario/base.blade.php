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
        });

        function busqueda() {
            Swal.fire({
                position: 'top',
                title: '<div class="input-group"><div class="input-group-prepend"><span class="input-group-text bg-light"><i class="fas fa-search"></i></span></div><input type="text" class="form-control" placeholder="Buscar" id="busqueda" autocomplete="off"></div>',
                html: '<small><span class="badge badge-secondary">Tab</span> Moverse entre los resultados <span class="badge badge-secondary ml-3">Esc</span> Cerrar búsqueda</small><div></div>',
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
                                $(".swal2-html-container>div").append('No se ha encontrado ningún resultado');
                            } else {
                                data.forEach(element => {
                                    if(element.tipo == "Juego") {
                                        if(html.indexOf("<h4 class='mt-2 mb-2'>Juegos</h4>") == -1) {
                                            html += "<h4 class='mt-2 mb-2'>Juegos</h4>";
                                        }
                                        let url = '{{ route("usuario.juego.show", ":id") }}';
                                        url = url.replace(':id', element.id);
                                        html += `<a href="${url}" class="list-group-item list-group-item-action">${element.nombre}</a>`;
                                    } else if (element.tipo == "Desarrolladora") {
                                        if(html.indexOf("<h4 class='mt-2 mb-2'>Desarrolladoras</h4>") == -1) {
                                            html += "<h4 class='mt-2 mb-2'>Desarrolladoras</h4>";
                                        }
                                        let url = '{{ route("usuario.desarrolladora.show", ":id") }}';
                                        url = url.replace(':id', element.id);
                                        html += `<a href="${url}" class="list-group-item list-group-item-action">${element.nombre}</a>`;
                                    } else if (element.tipo == "Master") {
                                        if(html.indexOf("<h4 class='mt-2 mb-2'>Masters</h4>") == -1) {
                                            html += "<h4 class='mt-2 mb-2'>Masters</h4>";
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

    </script>
</body>

</html>
