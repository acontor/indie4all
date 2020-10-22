@extends('layouts.admin')
@section('content')
    <div class="container">
        <div class='row'>
            <div class='col-sm'>

                <h1 class='display-3'>Juegos </h1>

                <table class='table table-striped table-responsive-lg'>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(function() {
            $(".button-crear").click(function() {
                $(".form-crear").toggleClass("d-none");
                $(this).toggleClass("btn-danger");
                if ($(this).hasClass("btn-danger")) {
                    $(this).text("-");
                } else {
                    $(this).text("+");
                }
            })
        })

    </script>
@endsection
