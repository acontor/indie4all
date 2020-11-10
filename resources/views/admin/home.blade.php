@extends('layouts.admin.base')
@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
@endsection
@section('content')
    <div class="container">
        <div class='row'>
            <div class='col-sm'>
                <div class="box-header">
                    <h1>Vista general</h1>
                </div>
            </div>
        </div>
        <div class="row box mt-4">
            <div class="col-sm-12">
                <h2>Usuarios activos últimas 5 horas</h2>
                <canvas id="active-users" width="400" height="150"></canvas>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-sm-5 box mt-4">
                <h2>Posts últimos 5 días</h2>
                <canvas id="posts" width="400" height="200"></canvas>
            </div>
            <div class="col-sm-5 box offset-sm-1 mt-4">
                <h2>Mensajes últimos 5 días</h2>
                <canvas id="mensajes" width="400" height="200"></canvas>
            </div>
        </div>
        <div class="row box mt-4">
            <div class="col-sm-6 col-md-4 mb-3 cards-link">
                <a href="{{ route('admin.usuarios.index') }}">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Usuarios <i class="fas fa-link"></i></h5>
                            <h6 class="card-subtitle mb-2">Número de usuarios totales.</h6>
                            <p class="card-text text-center">{{ $num_usuarios }}</p>
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
                            <p class="card-text text-center">{{ $num_desarrolladoras }}</p>
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
                            <p class="card-text text-center">{{ $num_juegos }}</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>
    <script>
        $(function() {

            var solicitudes = {!! json_encode($num_solicitudes) !!};

            if (solicitudes > 0) {
                Swal.fire({
                    position: 'top-end',
                    title: `Tienes ${solicitudes} solicitudes`,
                    timer: 3000,
                    showConfirmButton: false,
                    showClass: {
                        popup: 'animate__animated animate__fadeInDown'
                    },
                    hideClass: {
                        popup: 'animate__animated animate__fadeOutUp'
                    },
                    allowOutsideClick: false,
                    backdrop: false,
                    width: 'auto',
                });
            }

            let current_hour = new Date().getHours();

            let hours = []

            for (let index = 4; index >= 0; index--) {
                hours.push(`${current_hour - index}:00`)
            }

            let current_day = new Date();

            let days = []

            for (let index = 4; index >= 0; index--) {
                current_day.setDate(current_day.getDate() - index);
                days.push(current_day.getDate())
                current_day.setDate(current_day.getDate() + index);
            }




            var ctx = document.getElementById('active-users').getContext('2d');

            var myLineChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: hours,
                    datasets: [{
                        label: 'Usuarios activos',
                        data: [12, 19, 3, 5, 2],
                        borderColor: '#ff6384',
                        backgroundColor: 'transparent',
                        borderWidth: 1
                    }]
                },
            });

            var ctx2 = document.getElementById('posts').getContext('2d');

            var myLineChart = new Chart(ctx2, {
                type: 'bar',
                data: {
                    labels: days,
                    datasets: [{
                        label: 'Posts',
                        data: [12, 19, 3, 5, 2],
                        backgroundColor: '#ff6384',
                        borderWidth: 1
                    }]
                },
            });

            var ctx3 = document.getElementById('mensajes').getContext('2d');

            var myLineChart = new Chart(ctx3, {
                type: 'bar',
                data: {
                    labels: days,
                    datasets: [{
                        label: 'Mensajes',
                        data: [12, 19, 3, 5, 2],
                        backgroundColor: '#ff6384',
                        borderWidth: 1
                    }]
                },
            });

        });

    </script>
@endsection
