@extends("layouts.usuario.base")

@section("content")
    <main class="py-4">
        <div class="container">
            <div class="box-header">
                <h1>Campañas ({{ $campanias->count() }})</h1>
            </div>
            <div class="table-responsive box">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <td>Nombre</td>
                            <td>Fecha final de campaña</td>
                            <td>Total a recaudar</td>
                            <td>Recaudado</td>
                            <td>Desarrolladora</td>
                            <td>Acción</td>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($campanias as $campania)
                            <tr>
                                <td class="align-middle">{{ $campania->juego->nombre }}</td>
                                <td class="align-middle">{{ $campania->fecha_fin }}</td>
                                <td class="align-middle">{{ $campania->meta }} €</td>
                                <td class="align-middle">{{ $campania->recaudado }} €</td>
                                <td class="align-middle">{{ $campania->juego->desarrolladora->nombre }}</td>
                                <td><a href="{{route('usuario.campania.show', $campania->id)}}"> Ver campaña</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </main>
@endsection
@section("scripts")
    <script src="{{ asset('js/datatable.js') }}"></script>
    <script type="text/javascript">
        $(function() {
            $("table").dataTable();
        });

    </script>
@endsection
