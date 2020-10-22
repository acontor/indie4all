@extends('layouts.admin')
@section('content')
    <div class="container">
        <div class='row'>
            <div class='col-sm'>
                <h1 class='display-5'>Desarrolladoras ({{ $desarrolladoras->count() }})</h1>
                @if ($solicitudes->count() > 0)
                <a class='btn btn-success button-crear mb-3'>Solicitudes ({{ $solicitudes->count() }})</a>
                <div class="d-none form-crear table-responsive mb-3">
                    <!-- Tabla de solicitudes -->
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <td>Nombre</td>
                                    <td>Email</td>
                                    <td>Dirección</td>
                                    <td>Teléfono</td>
                                    <td>Url</td>
                                    <td>Solicitante</td>
                                    <td>Aceptar</td>
                                    <td>Rechazar</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($solicitudes as $solicitud)
                                    <tr>
                                        <form method='post' action="">
                                            @method('PATCH')
                                            @csrf
                                            <td class="align-middle">{{ $solicitud->nombre }}</td>
                                            <td class="align-middle">{{ $solicitud->email }}</td>
                                            <td class="align-middle">{{ $solicitud->direccion }}</td>
                                            <td class="align-middle">{{ $solicitud->telefono }}</td>
                                            <td class="align-middle">{{ $solicitud->url }}</td>
                                            <td class="align-middle">{{ $solicitud->usuario->name }}</td>
                                            <td class="align-middle"><button class='btn btn-success' type='submit'>Aceptar</button></td>
                                        </form>
                                        <td class="align-middle">
                                            <form action="" method='post'>
                                                @csrf
                                                @method('DELETE')
                                                <button class='btn btn-danger' type='submit'>Rechazar</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $solicitudes->links('pagination::bootstrap-4') }}
                </div>
                @endif
                <div class="table-responsive">
                    <table class='table table-striped table-responsive'>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(function() {
            $(".button-crear").click(function() {
                $(".form-crear").toggleClass("d-none");
                $(this).toggleClass("btn-danger");
            });
        });
    </script>
@endsection
