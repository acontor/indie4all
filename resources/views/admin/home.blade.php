@extends("layouts.admin.base")
@section("styles")
    <link href="{{ asset('css/animate.min.css') }}" rel="stylesheet">
@endsection
@section("content")
    <div class="container">
        <div class="box-header">
            <h1>Vista general</h1>
        </div>
        <div class="box mt-4">
            <div class="row">
                <div class="col-sm-7 col-12">
                    <h2>Usuarios activos últimas 5 horas</h2>
                    <canvas id="active-users" width="400" height="300"></canvas>
                </div>
                <div class="col-sm-5 col-12">
                    <div class="row">
                        <div class="col-sm-12 col-12 mt-4 mt-sm-0">
                            <h2>Posts últimos 5 días</h2>
                            <canvas id="posts" width="400" height="200"></canvas>
                        </div>
                        <div class="col-sm-12 col-12 mt-4 mt-sm-0">
                            <h2>Mensajes últimos 5 días</h2>
                            <canvas id="mensajes" width="400" height="200"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="box mt-4">
            <div class="row">
                <div class="col-sm-6 col-md-4 mb-3 cards-link">
                    <a href="{{ route('admin.usuarios.index') }}">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Usuarios <i class="fas fa-link"></i></h5>
                                <h6 class="card-subtitle mb-2">Número de usuarios totales.</h6>
                                <p class="card-text text-center">{{ $numUsuarios }}</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-sm-6 col-md-4 mb-3 cards-link">
                    <a href="{{ route('admin.desarrolladoras.index') }}">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Desarrolladoras <i class="fas fa-link"></i></h5>
                                <h6 class="card-subtitle mb-2">Número de desarrolladoras totales.</h6>
                                <p class="card-text text-center">{{ $numDesarrolladoras }}</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-sm-6 col-md-4 mb-3 cards-link">
                    <a href="{{ route('admin.juegos.index') }}">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Juegos <i class="fas fa-link"></i></h5>
                                <h6 class="card-subtitle mb-2">Número de juegos totales.</h6>
                                <p class="card-text text-center">{{ $numJuegos }}</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
@section("scripts")
    <script src="{{ asset('js/sweetalert.min.js') }}"></script>
    <script src="{{ asset('js/chart.min.js') }}"></script>
    <script>
        $(function() {

            let numSolicitudes = {!! json_encode($numSolicitudes) !!};

            if (numSolicitudes > 0) {
                notificaciones(numSolicitudes);
            }

            let diaActual = new Date();

            let dias = []

            for (let index = 4; index >= 0; index--) {
                diaActual.setDate(diaActual.getDate() - index);
                dias.push(diaActual.getDate())
                diaActual.setDate(diaActual.getDate() + index);
            }

            let numPosts = {!! json_encode($numPosts) !!};
            let numMensajes = {!! json_encode($numMensajes) !!};

            graficaUsuarios();
            graficaPosts(numPosts, dias);
            graficaMensajes(numMensajes, dias);
        });

        function graficaUsuarios() {
            let ctx = document.getElementById("active-users").getContext("2d");

            let horaActual = new Date().getHours();

            let horas = []

            for (let index = 4; index >= 0; index--) {
                horas.push(`${horaActual - index}:00`)
            }

            let myLineChart = new Chart(ctx, {
                type: "line",
                data: {
                    labels: horas,
                    datasets: [{
                        label: "Usuarios activos",
                        data: [12, 19, 3, 5, 2],
                        borderColor: "#ff6384",
                        backgroundColor: "transparent",
                        borderWidth: 1
                    }]
                },
            });
        }

        function graficaPosts(numPosts, dias) {
            let ctx = document.getElementById("posts").getContext("2d");

            let myLineChart = new Chart(ctx, {
                type: "bar",
                data: {
                    labels: dias,
                    datasets: [{
                        label: "Posts",
                        data: numPosts,
                        backgroundColor: "#ff6384",
                        borderWidth: 1
                    }]
                },
            });
        }

        function graficaMensajes(numMensajes, dias) {
            let ctx = document.getElementById("mensajes").getContext("2d");

            let myLineChart = new Chart(ctx, {
                type: "bar",
                data: {
                    labels: dias,
                    datasets: [{
                        label: "Mensajes",
                        data: numMensajes,
                        backgroundColor: "#ff6384",
                        borderWidth: 1
                    }]
                },
            });
        }

        function notificaciones(numSolicitudes) {
            Swal.fire({
                position: "top-end",
                title: `Tienes ${numSolicitudes} solicitudes`,
                timer: 3000,
                showConfirmButton: false,
                showClass: {
                    popup: "animate__animated animate__fadeInDown"
                },
                hideClass: {
                    popup: "animate__animated animate__fadeOutUp"
                },
                allowOutsideClick: false,
                backdrop: false,
                width: "auto",
            });
        }

    </script>
@endsection
