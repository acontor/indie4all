@extends("layouts.master.base")
@section("styles")
    <link href="{{ asset('css/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/datatable.css') }}" rel="stylesheet">
@endsection
@section("content")
    <div class="container">
        <div class="row">
            <div class="col-sm">
                <div class="box-header">
                    <h1 class="d-inline-block">Análisis ({{ $analisis->count() }})</h1>
                    <a href="{{ route('master.analisis.create', 0) }}" class="btn btn-success btn-sm round float-right mt-2"><i class="far fa-plus-square"></i></a>
                </div>
                <div class="table-responsive box">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <td class="w-30">Título</td>
                                <td class="w-25">Tipo</td>
                                <td class="w-10 text-center">Comentarios</td>
                                <td class="w-10 text-center">Calificación</td>
                                <td class="w-25 text-center">Acciones</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($analisis as $analisis)
                                <tr>
                                    <td>{{ $analisis->titulo }}</td>
                                    <td>{{ $analisis->tipo }}</td>
                                    <td class="text-center">{{ $analisis->mensajes->count() }}</td>
                                    <td class="text-center">{{ $analisis->calificacion }}</td>
                                    <td class="align-middle text-center">
                                        <div class="btn-group">
                                            <form action="{{ route('master.analisis.edit', $analisis->id) }}" method="post">
                                                @csrf
                                                <button class="btn btn-primary btn-sm round mr-1" type="submit">
                                                    <i class="far fa-edit"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('master.analisis.destroy', $analisis->id) }}" method="post">
                                                @csrf
                                                @method("DELETE")
                                                <button class="btn btn-danger btn-sm round ml-1" type="submit">
                                                    <i class="far fa-trash-alt"></i>
                                                </button>
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
