@extends("layouts.cm.base")

@section("styles")
    <link href="{{ asset('css/animate/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/datatable/datatable.css') }}" rel="stylesheet">
@endsection

@section("content")
    <div class="container">
        <div class="row">
            <div class="col-sm">
                <div class="box-header">
                    <h1 class="d-inline-block">Encuestas ({{ $encuestas->count() }})</h1>
                    <a href="{{ route('cm.encuestas.create') }}" class='btn btn-success btn-sm round float-right mt-2'><i class="far fa-plus-square"></i></a>
                </div>
                <div class="table-responsive box mt-4">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <td class="w-20">Pregunta</td>
                                <td class="w-30">Fecha fin</td>
                                <td class="w-20 text-center">Participaciones</td>
                                <td class="w-20">Resultado</td>
                                <td class="w-10 text-center">Acciones</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($encuestas as $encuesta)
                                <tr>
                                    <td class="w-20">{{ $encuesta->pregunta }}</td>
                                    <td class="w-30">{{ $encuesta->fecha_fin }}</td>
                                    <td class="w-20 text-center">
                                        @php
                                            $total = 0
                                        @endphp
                                        @foreach ($encuesta->opciones as $opcion)
                                            @php
                                                $total+=$opcion->participantes->count()
                                            @endphp
                                        @endforeach
                                        {{$total}}
                                    </td>
                                    <td class="w-20">
                                        @if($total == 0)
                                            Aún no ha participaciones
                                        @else
                                        @foreach ($encuesta->opciones as $opcion)
                                            {{$opcion->descripcion}} - {{($opcion->participantes->count() / $total) * 100}} %
                                            <br>
                                        @endforeach
                                        @endif
                                    </td>
                                    <td class="align-middle w-10 text-center">
                                        <div class="btn-group">
                                            <a class="btn btn-success btn-sm round mr-2" href="{{ route('cm.encuesta.finish', $encuesta->id) }}">
                                                <i class="fas fa-hourglass-half"></i>
                                            </a>
                                            <form action="{{ route('cm.encuestas.destroy', $encuesta->id) }}" method='post'>
                                                @csrf
                                                @method('DELETE')
                                                <button class='btn btn-danger btn-sm round ml-1' type='submit'><i class="far fa-trash-alt"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
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
            $('.btn-danger').click(function(e) {
                e.preventDefault();
                let form = $(this).parents('form');
                Swal.fire({
                    position: "center",
                    title: "Cuidado",
                    text: "¡Tendrás que volver a crear la campaña para recuperarla!",
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
