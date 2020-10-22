@extends('layouts.admin')
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
                                <td>imagen_portada</td>
                                <td>imagen_caratula</td>
                                <td>sinopsis</td>
                                <td>fecha_lanzamiento</td>
                                <td>precio</td>
                                <td>desarrolladora_id</td>
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
                                    <td class="align-middle">{{ $juego->precio }}</td>
                                    <td class="align-middle">{{ $juego->desarrolladora_id }}</td>
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
