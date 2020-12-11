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
                <div class="box">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <td>Nombre</td>
                                <td>Fecha de lanzamiento</td>
                                <td>Precio</td>
                                <td>Desarrolladora</td>
                                <td class="text-center">Acciones</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($juegos as $juego)
                                <tr>
                                    <td class="align-middle">{{ $juego->nombre }}</td>
                                    <td class="align-middle">{{ $juego->fecha_lanzamiento }}</td>
                                    <td class="align-middle">{{ $juego->precio }} €</td>
                                    <td class="align-middle">{{ $juego->desarrolladora->nombre }}</td>
                                    <td class="align-middle text-center">
                                        <div class="btn-group">
                                            <a href="{{ route('admin.juego.show', $juego->id) }}" class="btn btn-primary btn-sm round">
                                                <i class="far fa-eye"></i>
                                            </a>
                                            <button class="btn btn-danger btn-sm round ml-1">
                                                <i class="fas fa-gavel"></i>
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
@endsection
@section("scripts")
    <script src="{{ asset('js/datatable.js') }}"></script>
    <script type="text/javascript">
        $(function() {
            $('table').DataTable({
                "responsive": true
            });
        });

    </script>
@endsection
