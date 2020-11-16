@extends("layouts.admin.base")
@section("styles")
    <link href="{{ asset('css/datatable.css') }}" rel="stylesheet">
@endsection
@section("content")
    <div class="container">
        <div class="row">
            <div class="col-sm">
                <div class="box-header">
                    <h1 class="d-inline-block">Desarrolladoras ({{ $desarrolladoras->count() }})</h1>
                    @if ($numSolicitudes > 0)
                        <a href="{{ route('admin.solicitudes.index') }}" class="btn btn-success btn-sm float-right mt-2">Solicitudes ({{ $numSolicitudes }})</a>
                    @endif
                </div>
                <div class="table-responsive box">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <td>Nombre</td>
                                <td>Email</td>
                                <td>Dirección</td>
                                <td>Teléfono</td>
                                <td>Url</td>
                                <td>Logo</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($desarrolladoras as $desarrolladora)
                                <tr>
                                    <td class="align-middle">{{ $desarrolladora->nombre }}</td>
                                    <td class="align-middle">{{ $desarrolladora->email }}</td>
                                    <td class="align-middle">{{ $desarrolladora->direccion }}</td>
                                    <td class="align-middle">{{ $desarrolladora->telefono }}</td>
                                    <td class="align-middle">{{ $desarrolladora->url }}</td>
                                    <td class="align-middle">{{ $desarrolladora->imagen_logo }}</td>
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
