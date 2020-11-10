@extends('layouts.admin.base')
@section('content')
    <div class="container">
        <div class='row'>
            <div class='col-sm'>
                <div class="box-header">
                    <h1>Solicitudes ({{ $desarrolladoras->count() + $masters->count() }})</h1>
                </div>
                @if ($desarrolladoras->count() > 0)
                    <div class="box">
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
                                        <td>Acciones</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($desarrolladoras as $desarrolladora)
                                        <tr>
                                            <form method='post'
                                                action="{{ route('admin.solicitudes.aceptarDesarrolladora', [$desarrolladora->id, $desarrolladora->user_id]) }}">
                                                @csrf
                                                <td class="align-middle"><input type="text"
                                                        value="{{ $desarrolladora->nombre }}" name="nombre"></td>
                                                <td class="align-middle"><input type="text" value="{{ $desarrolladora->email }}"
                                                        name="email"></td>
                                                <td class="align-middle"><input type="text"
                                                        value="{{ $desarrolladora->direccion }}" name="direccion"></td>
                                                <td class="align-middle"><input type="text"
                                                        value="{{ $desarrolladora->telefono }}" name="telefono"></td>
                                                <td class="align-middle"><input type="text" value="{{ $desarrolladora->url }}"
                                                        name="url"></td>
                                                <td class="align-middle">{{ $desarrolladora->usuario->name }}</td>
                                                <td class="align-middle">
                                                    <div class="btn-group">
                                                    <button class='btn btn-success ml-1' type='submit'><i class="far fa-check-square"></i></button>
                                                    </form>
                                                    <form
                                                        action="{{ route('admin.solicitudes.rechazarDesarrolladora', $desarrolladora->id) }}"
                                                        method='post'>
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class='btn btn-danger ml-1' type='submit'><i class="far fa-trash-alt"></i></button>
                                                    </form>
                                                </div>
                                                </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $desarrolladoras->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                @endif
                @if ($masters->count() > 0)
                    <div class="box">
                        <h2>Masters</h2>
                        <div class="table-responsive mb-3">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <td>Nombre</td>
                                        <td>Email</td>
                                        <td>Solicitante</td>
                                        <td>Acciones</td>
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
                                                <td class="align-middle">
                                                    <button class='btn btn-success' type='submit'>Aceptar</button>
                                                    <form action="" method='post'>
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class='btn btn-danger' type='submit'>Rechazar</button>
                                                    </form>
                                                </td>
                                            </form>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $masters->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
