@extends("layouts.admin.base")

@section("styles")
    <link href="{{ asset('css/animate/animate.min.css') }}" rel="stylesheet">
@endsection

@section("content")
    <div class="container">
        <div class="box-header">
            <h1>Vista general</h1>
        </div>
        <div class="box mt-5">
            <div class="row">
                <div class="col-sm-6 col-12">
                    <h2 class="mb-4">Mensajes últimos 5 días</h2>
                    <canvas id="mensajes"></canvas>
                </div>
                <div class="col-sm-6 col-12">
                    <h2 class="mb-4">Posts últimos 5 días</h2>
                    <canvas id="posts"></canvas>
                </div>
            </div>
            <div class="row mt-5">
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
            <div class="row mt-5">
                <div class="col-sm-6 col-md-4 mb-3 cards-link">
                    <a href="{{ route('admin.campanias.index') }}">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Campañas <i class="fas fa-link"></i></h5>
                                <h6 class="card-subtitle mb-2">Número de campañas totales.</h6>
                                <p class="card-text text-center">{{ $numCampanias }}</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-sm-6 col-md-4 mb-3 cards-link">
                    <a href="{{ route('admin.generos.index') }}">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Géneros <i class="fas fa-link"></i></h5>
                                <h6 class="card-subtitle mb-2">Número de géneros totales.</h6>
                                <p class="card-text text-center">{{ $numGeneros }}</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-sm-6 col-md-4 mb-3 cards-link">
                    <a href="{{ route('admin.logros.index') }}">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Logros <i class="fas fa-link"></i></h5>
                                <h6 class="card-subtitle mb-2">Número de logros totales.</h6>
                                <p class="card-text text-center">{{ $numLogros }}</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section("scripts")
    <script src="{{ asset('js/sweetalert/sweetalert.min.js') }}"></script>
    <script src="{{ asset('js/admin.js') }}"></script>
    <script src="{{ asset('js/chart/chart.min.js') }}"></script>
    @if(Session::has('solicitudes') || Session::has('reportes'))
        <script defer>
            notificacionAdmin("{{ (Session::get('solicitudes')) ? Session::get('solicitudes') : null }}", "{{ (Session::get('reportes')) ? Session::get('reportes') : null }}");
        </script>
    @endif
    <script>
        $(function() {
            let diaActual = new Date();

            let dias = []

            for (let index = 4; index >= 0; index--) {
                diaActual.setDate(diaActual.getDate() - index);
                dias.push(diaActual.getDate())
                diaActual.setDate(diaActual.getDate() + index);
            }

            let numPosts = {!! json_encode($numPosts) !!};
            let numMensajes = {!! json_encode($numMensajes) !!};

            graficaPosts(numPosts, dias);
            graficaMensajes(numMensajes, dias);
        });

    </script>
@endsection
