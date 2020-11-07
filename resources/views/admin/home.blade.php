@extends('layouts.admin.base')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
@section('content')
    <div class="container">
        <div class='row mt-5'>
            <div class='col-sm-8 offset-sm-2'>
                <h1 class='display-5'>Bienvenido al panel de administración</h1>
            </div>
        </div>
        <div class="row mt-5">
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        $(function() {

            var solicitudes = {!!json_encode($num_solicitudes) !!};

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
        });

    </script>
@endsection
