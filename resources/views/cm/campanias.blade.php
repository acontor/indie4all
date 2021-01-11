@extends("layouts.cm.base")

@section("content")
    <div class="container">
        <div class="row">
            <div class="col-sm">
                <div class="box-header">
                    <h1 class="d-inline-block">Campañas ({{ $juegos->count() }})</h1>
                    <a href="{{ route('cm.campania.create') }}" class="btn btn-success btn-sm round float-right mt-2"><i class="far fa-plus-square"></i></a>
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
                                <a href="{{ route('usuario.campania.show', $juego->campania->id) }}">{{ $juego->nombre }}</a>
                            </h5>
                            <p class="date-lanzamiento"> {{ $juego->fecha_lanzamiento }}
                                <span class="genero">{{ $juego->genero->nombre }}</span>
                            </p>
                            <p class="card-text">
                                {{ $juego->sinopsis }}
                            </p>
                            @if($juego->campania->ban)
                                <small class="text-danger">¡La campaña está suspendida!</small>
                            @endif
                            <div class="row mt-3">
                                <a class="btn btn-primary btn-sm round ml-1" title="Ver Juego"
                                    href="{{ route('cm.campania.show', $juego->campania->id) }}">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <form action="{{ route('cm.campania.destroy', $juego->campania->id) }}" method='post'>
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
    <script src="{{ asset('js/datatable/script.js') }}"></script>
    <script src="{{ asset('js/sweetalert/sweetalert.min.js') }}"></script>
    <script src="{{ asset('js/script.js') }}"></script>
    <script>
        $(function() {
            $(".btn-danger").on('click', function(e) {
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

    </script>
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
