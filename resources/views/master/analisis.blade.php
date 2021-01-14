@extends("layouts.master.base")

@section("styles")
    <link href="{{ asset('css/animate/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/datatable/datatable.css') }}" rel="stylesheet">
@endsection

@section("content")
    <div class="container">
        <div class="box-header">
            <h1 class="d-inline-block">Análisis ({{ $analisis->count() }})</h1>
            <a href="{{ route('master.analisis.create', 0) }}" class="btn btn-success btn-sm round float-right mt-2"><i class="far fa-plus-square"></i></a>
        </div>
        <div class="table-responsive box">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <td class="w-30">Título</td>
                        <td class="w-15">Juego</td>
                        <td class="w-10 text-center">Comentarios</td>
                        <td class="w-10 text-center">Calificación</td>
                        <td class="w-10 text-center">Suspendido</td>
                        <td class="w-25 text-center">Acciones</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($analisis as $post)
                        <tr>
                            <td class="align-middle">{{ $post->titulo }}</td>
                            <td class="align-middle">{{ $post->juego->nombre }}</td>
                            <td class="align-middle text-center">{{ $post->comentarios->count() }}</td>
                            <td class="align-middle text-center">{{ $post->calificacion }}</td>
                            <td class="align-middle text-center">{{ $post->ban == 0 ? 'No' : 'Si' }}</td>
                            <td class="align-middle text-center">
                                <div class="btn-group">
                                    <form action="{{ route('master.analisis.edit', $post->id) }}" method="get">
                                        @csrf
                                        <button class="btn btn-primary btn-sm round mr-1" type="submit">
                                            <i class="far fa-edit"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('master.analisis.destroy', $post->id) }}" method="post">
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
@endsection

@section("scripts")
    <script src="{{ asset('js/datatable/datatable.js') }}"></script>
    <script src="{{ asset('js/datatable/script.js') }}"></script>
    <script src="{{ asset('js/sweetalert/sweetalert.min.js') }}"></script>
    <script src="{{ asset('js/script.js') }}"></script>
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
