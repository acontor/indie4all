@extends("layouts.admin.base")

@section("styles")
    <link href="{{ asset('css/animate/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/datatable/datatable.css') }}" rel="stylesheet">
@endsection

@section("content")
    <div class="container">
        <div class="row">
            <div class="col-sm">
                <div class="box-header">
                    <h1 class="d-inline-block">Géneros ({{ $generos->count() }})</h1>
                    <a href="{{ route('admin.generos.create') }}" class="btn btn-success btn-sm round float-right mt-2"><i
                            class="far fa-plus-square"></i></a>
                </div>
                <div class="box mt-4">
                    <canvas id="myChart"></canvas>
                </div>
                <div class="box mt-4">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <td class="w-50">Nombre</td>
                                <td class="w-20 text-center">Seguidores</td>
                                <td class="w-20 text-center">Juegos</td>
                                <td class="w-10 text-center">Acciones</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($generos as $genero)
                                <tr>
                                    <td class="align-middle w-50">{{ $genero->nombre }}</td>
                                    <td class="w-20 text-center">{{ $genero->usuarios->count() }}</td>
                                    <td class="w-20 text-center">{{ $genero->juegos->count() }}</td>
                                    <td class="align-middle w-10 text-center">
                                        <div class="btn-group">
                                            <form method="get" action="{{ route('admin.generos.edit', $genero->id) }}">
                                                @csrf
                                                <button class="btn btn-primary btn-sm round mr-1" type="submit">
                                                    <i class="far fa-edit"></i>
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
    <script src="{{ asset('js/admin.js') }}"></script>
    <script src="{{ asset('js/script.js') }}"></script>
    <script src="{{ asset('js/chart/chart.min.js') }}"></script>
    <script>
        $(function() {
            var generos = {!! $generos !!};
            var datos = {!! json_encode($datos) !!};

            graficaGeneros(generos, datos);

        });

    </script>
@endsection
