@extends("layouts.cm.base")
@section("styles")
    <link href="{{ asset('css/cm.css') }}" rel="stylesheet">
@endsection
@section("content")
    <div class="container">
        <div class="row">
            <div class="col-sm">
                <div class="box-header">
                    <h1 class="d-inline-block">Juegos ({{ $juegos->count() }})</h1>
                    <a href="{{ route('cm.juego.create') }}" class="btn btn-success btn-sm round float-right mt-2"><i class="far fa-plus-square"></i></a>
                </div>
            </div>
        </div>
        <div class="row">
            @foreach ($juegos as $juego)
                <div class="col-3 mt-4 mr-4">
                    <div class="card">
                        <img src="{{ asset('/images/default.png') }}" height="100" />
                        <div class="card-body">
                            <h5 class="card-title">
                                <a href="{{ route('usuario.juego.show', $juego->id) }}">{{ $juego->nombre }}</a>
                            </h5>
                            <p class="date-lanzamiento"> {{ $juego->fecha_lanzamiento }}
                                <span class="genero">{{ $juego->genero->nombre }}</span>
                            </p>
                            <p class="card-text">
                                {{ $juego->sinopsis }}
                            </p>
                            <div class="row">
                                <a class="btn btn-primary btn-sm round ml-1" title="Ver Juego"
                                    href="{{ route('cm.juego.show', $juego->id) }}">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <form action="{{ route('cm.juego.destroy', $juego->id) }}" method='post'>
                                    @csrf
                                    @method("DELETE")
                                    <button class="btn btn-danger btn-sm round ml-1 btn-delete" type="submit">
                                        <i class="far fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
@section("scripts")
    <script src="{{ asset('js/datatable/datatable.js') }}"></script>
    <script src="{{ asset('js/sweetalert/sweetalert.min.js') }}"></script>
    <script>
        $(function() {
            $("table").dataTable();

            let sessionSuccess = {!! json_encode(session()->get("success")) !!}

            if (sessionSuccess != undefined) {
                notificacion(sessionSuccess)
            }

            $(".btn-danger").click(function(e) {
                e.preventDefault();
                let form = $(this).parents("form");
                Swal.fire({
                    position: "center",
                    title: "Cuidado",
                    text: "¡Tendrás que volver a crear el juego para recuperarlo!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Aceptar",
                    cancelButtonText: "Cancelar",
                    showClass: {
                        popup: "animate__animated animate__fadeInDown"
                    },
                    hideClass: {
                        popup: "animate__animated animate__fadeOutUp"
                    },
                    closeOnConfirm: false,
                }).then((resultado) => {
                    if (resultado.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });

        function notificacion(sessionSuccess) {
            Swal.fire({
                position: "top-end",
                title: sessionSuccess,
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
