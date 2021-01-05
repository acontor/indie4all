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
                    <h1 class="d-inline-block">Sorteos ({{ $sorteos->count() }})</h1>
                    <a href="{{ route('cm.sorteo.create') }}" class="btn btn-success btn-sm round float-right mt-2"><i class="far fa-plus-square"></i></a>
                </div>
                <div class="table-responsive box mt-4">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <td class="w-20">Título</td>
                                <td class="w-30">Descripción</td>
                                <td class="w-20 text-center">Participaciones</td>
                                <td class="w-20">Ganador</td>
                                <td class="w-10 text-center">Acciones</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sorteos as $sorteo)
                                <tr>
                                    <td class="w-20">{{ $sorteo->titulo }}</td>
                                    <td class="w-30">{{ $sorteo->descripcion }}</td>
                                    <td class="w-20 text-center">{{ $sorteo->participantes->count() }}</td>
                                    <td class="w-20">
                                        @if($sorteo->user_id != null)
                                        {{$sorteo->ganador->email}}
                                        @else
                                        No ha finalizado
                                        @endif
                                    </td>
                                    <td class="align-middle w-10 text-center">
                                        <div class="btn-group">
                                            <a class="btn btn-success btn-sm round mr-2" href="{{ route('cm.sorteo.finish', $sorteo->id) }}">
                                                <i class="fas fa-hourglass-half"></i>
                                            </a>
                                            <a class="btn btn-primary btn-sm round mr-2" href="{{ route('cm.sorteo.edit', $sorteo->id) }}">
                                                <i class="far fa-edit"></i>
                                            </a>
                                            <button class="btn btn-danger btn-sm round" type="submit">
                                                <i class="far fa-trash-alt"></i>
                                            </button>
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
    </div>
@endsection

@section("scripts")
    <script src="{{ asset('js/datatable/datatable.js') }}"></script>
@endsection
