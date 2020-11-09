@extends('layouts.admin.base')
@section('content')
    <div class="container">
        <div class='row'>
            <div class='col-sm'>
                <h1 class='display-5'>Desarrolladoras ({{ $desarrolladoras->count() }})</h1>
                @if ($solicitudes->count() > 0)
                <a href="{{ route('admin.solicitudes.index') }}" class='btn btn-success button-crear mb-3'>Solicitudes ({{ $solicitudes->count() }})</a>
                @endif
                <div class="table-responsive">
                    <table class='table table-striped'>
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
                    {{ $desarrolladoras->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
@endsection
