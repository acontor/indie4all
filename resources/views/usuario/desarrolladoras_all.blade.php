@extends("layouts.usuario.base")

@section("styles")
    <link href="{{ asset('css/datatable/datatable.css') }}" rel="stylesheet">
@endsection

@section("content")
    <main class="py-4">
        <div class="container">
            <div class="box-header">
                <h1>Desarrolladoras ({{ $desarrolladoras->count() }})</h1>
            </div>
            <div class="table-responsive box">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <td>Nombre</td>
                            <td>Número de juegos</td>
                            <td>Número de campañas</td>
                            <td>Número de seguidores</td>
                            <td>Acción</td>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($desarrolladoras as $desarrolladora)
                            <tr>
                                <td class="align-middle">{{ $desarrolladora->nombre }}</td>
                                <td class="align-middle">1</td>
                                <td class="align-middle">1</td>
                                <td class="align-middle">1</td>
                                <td><a href="{{route('usuario.desarrolladora.show', $desarrolladora->id)}}"> Ver Desarrolladora</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </main>
@endsection

@section("scripts")
    <script src="{{ asset('js/datatable/datatable.js') }}"></script>
    <script src="{{ asset('js/datatable/script.js') }}"></script>
@endsection
