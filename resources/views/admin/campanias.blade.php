@extends("layouts.admin.base")
@section("styles")
    <link href="{{ asset('css/datatable.css') }}" rel="stylesheet">
@endsection
@section("content")
    <div class="container">
        <div class="row">
            <div class="col-sm">
                <div class="box-header">
                    <h1>Campañas ({{ $juegos->count() }})</h1>
                </div>
                <div class="box">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <td>Nombre</td>
                                <td>Fecha de fin</td>
                                <td>Meta</td>
                                <td>Recaudado</td>
                                <td class="text-center">Acciones</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($juegos as $juego)
                                <tr>
                                    <td class="align-middle">{{ $juego->nombre }}</td>
                                    <td class="align-middle">{{ $juego->campania->fecha_fin }}</td>
                                    <td class="align-middle">{{ $juego->campania->meta }} €</td>
                                    <td class="align-middle">{{ $juego->campania->recaudado }} €</td>
                                    <td class="align-middle text-center">
                                        <div class="btn-group">
                                            <a href="{{ route('admin.campania.show', $juego->id) }}" class="btn btn-primary btn-sm round"><i class="far fa-eye"></i></a>
                                            <form action="">
                                                <button class="btn btn-danger btn-sm round ml-1">
                                                    <i class="fas fa-eraser"></i>
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
    <script type="text/javascript">
        $(function() {
            $('table').DataTable({
                "responsive": true
            });
        });

    </script>
@endsection
