@extends("layouts.admin.base")
@section("styles")
    <link href="{{ asset('css/datatable.css') }}" rel="stylesheet">
@endsection
@section("content")
    <div class="container">
        <div class="row">
            <div class="col-sm">
                <div class="box-header">
                    <h1>Juegos ({{ $juegos->count() }})</h1>
                </div>
                <div class="table-responsive box">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <td>Nombre</td>
                                <td>Portada</td>
                                <td>Carátula</td>
                                <td>Sinopsis</td>
                                <td>Fecha de lanzamiento</td>
                                <td>Precio</td>
                                <td>Desarrolladora</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($juegos as $juego)
                                <tr>
                                    <td class="align-middle">{{ $juego->nombre }}</td>
                                    <td class="align-middle">{{ $juego->imagen_portada }}</td>
                                    <td class="align-middle">{{ $juego->imagen_caratula }}</td>
                                    <td class="align-middle">{{ $juego->sinopsis }}</td>
                                    <td class="align-middle">{{ $juego->fecha_lanzamiento }}</td>
                                    <td class="align-middle">{{ $juego->precio }} €</td>
                                    <td class="align-middle">{{ $juego->desarrolladora->nombre }}</td>
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
    <script type="text/javascript">
        $(function() {
            $("table").dataTable();
        });

    </script>
@endsection
