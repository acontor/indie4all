@extends('layouts.admin.base')
@section('content')
    <div class="container">
        <div class='row'>
            <div class='col-sm'>
                <h1 class='display-5'>Juegos ({{ $juegos->count() }})</h1>
                <div class="table-responsive">
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
                    {{ $juegos->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
@endsection
