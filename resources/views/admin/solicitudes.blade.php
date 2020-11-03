@extends('layouts.admin.base')
@section('content')
    <div class="container">
        <div class='row'>
            <div class='col-sm'>
                <h1 class='display-5'>Solicitudes ({{ $desarrolladoras->count() + $masters->count() }})</h1>
                @if ($desarrolladoras->count() > 0)
                    <h2>Desarrolladoras</h2>
                    <div class="table-responsive mb-3">
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
                                @foreach ($desarrolladoras as $desarrolladora)
                                    <tr>
                                        <form method='post' action="{{ route('admin.solicitudes.aceptarDesarrolladora', [$desarrolladora->id, $desarrolladora->user_id]) }}">
                                            @csrf
                                            <td class="align-middle"><input type="text" value="{{ $desarrolladora->nombre }}" name="nombre"></td>
                                            <td class="align-middle"><input type="text" value="{{ $desarrolladora->email }}" name="email"></td>
                                            <td class="align-middle"><input type="text" value="{{ $desarrolladora->direccion }}" name="direccion"></td>
                                            <td class="align-middle"><input type="text" value="{{ $desarrolladora->telefono }}" name="telefono"></td>
                                            <td class="align-middle"><input type="text" value="{{ $desarrolladora->url }}" name="url"></td>
                                            <td class="align-middle">{{ $desarrolladora->usuario->name }}</td>
                                            <td class="align-middle"><button class='btn btn-success' type='submit'>Aceptar</button></td>
                                        </form>
                                        <td>
                                            <form action="{{ route('admin.solicitudes.rechazarDesarrolladora', $desarrolladora->id) }}" method='post'>
                                                @csrf
                                                @method('DELETE')
                                                <button class='btn btn-danger' type='submit'>Rechazar</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $desarrolladoras->links('pagination::bootstrap-4') }}
                    </div>
                @endif
                @if ($masters->count() > 0)
                    <h2>Masters</h2>
                    <div class="table-responsive mb-3">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <td>Nombre</td>
                                    <td>Email</td>
                                    <td>Solicitante</td>
                                    <td>Aceptar</td>
                                    <td>Rechazar</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($masters as $master)
                                    <tr>
                                        <form method='post' action="">
                                            @method('PATCH')
                                            @csrf
                                            <td class="align-middle">{{ $master->nombre }}</td>
                                            <td class="align-middle">{{ $master->email }}</td>
                                            <td class="align-middle">{{ $master->usuario->name }}</td>
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
                        {{ $masters->links('pagination::bootstrap-4') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
