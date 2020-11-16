@extends("layouts.cm.base")
@section("styles")
    <link href="{{ asset('css/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/datatable.css') }}" rel="stylesheet">
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
                                    <td class="w-20 text-center">0</td>
                                    <td class="w-20">-</td>
                                    <td class="align-middle w-10 text-center">
                                        <div class="btn-group">
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
    <script src="{{ asset('js/datatable.js') }}"></script>
    <script src="{{ asset('js/sweetalert.min.js') }}"></script>
    <script>
        $(function() {
            $("table").dataTable();

            let sessionSuccess = {!! json_encode(session()->get("success")) !!}

            if (sessionSuccess != undefined) {
                notificacion(sessionSuccess)
            }

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
