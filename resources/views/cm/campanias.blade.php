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
        <div class="row mb-4 mt-5">
            @foreach ($juegos as $juego)
            <div class="col-md-3 col-sm-6 mt-4 item">
                <div class="card item-card card-block">
                    @if($juego->imagen_portada)
                        <img class="img-fluid" src="{{ asset('/images/desarrolladoras/' . $juego->desarrolladora->nombre . '/' . $juego->nombre . '/' . $juego->imagen_portada) }}" id="imagen-portada" alt="Portada del juego" />
                    @else
                        <img class="img-fluid" src="{{ asset('/images/desarrolladoras/default-portada-juego.png') }}" id="imagen-portada" alt="Portada del juego" />
                    @endif
                    <div class="p-3">
                        <h5><a href="{{ route('usuario.campania.show', $juego->campania->id) }}">{{ $juego->nombre }}</a></h5>
                        Participaciones:<small class="float-right"> {{$juego->campania->compras_count}}</small><br>
                        Recaudado:<small class="float-right"> {{$juego->campania->recaudado}}€</small><br>
                        Meta:<small class="float-right"> {{$juego->campania->meta}}€</small><br>
                        Aporte min:<small class="float-right"> {{$juego->campania->aporte_minimo}}</small><br>
                        Termina:<small class="float-right"> {{$juego->campania->fecha_fin}}</small><br>
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
