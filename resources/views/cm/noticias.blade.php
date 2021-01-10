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
                    <h1 class="d-inline-block">Noticias ({{ $noticias->count() }})</h1>
                    <a href="{{ route('cm.noticia.create', ['tipo' => 'desarrolladora', 'id' => App\Models\Cm::where('user_id', Auth::id())->first()->desarrolladora_id]) }}" class="btn btn-success btn-sm round float-right mt-2"><i class="far fa-plus-square"></i></a>
                </div>
                <div class="box">
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
                            @foreach ($noticias as $noticia)
                                <tr>
                                    <td>{{ $noticia->titulo }}</td>
                                    <td>{{ $noticia->tipo }}</td>
                                    <td class="text-center">{{ $noticia->comentarios->count() }}</td>
                                    <td class="text-center">{{ $noticia->calificacion }}</td>
                                    <td class="align-middle text-center">
                                        <div class="btn-group">
                                            <form action="{{ route('cm.noticia.edit', $noticia->id) }}" method="post">
                                                @csrf
                                                <button class="btn btn-primary btn-sm round mr-1" type="submit">
                                                    <i class="far fa-edit"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('cm.noticia.destroy', $noticia->id) }}" method="post">
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
