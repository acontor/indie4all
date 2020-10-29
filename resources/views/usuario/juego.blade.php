@extends('layouts.base')

@section('content')


    <header>
        <img class="" src="https://i.pinimg.com/736x/38/2c/6a/382c6a6c057a298ea5aa9759d55f36f3.jpg">
        <div>
            <h1 class="font-weight-light">{{ $juego->nombre }}</h1>
            <ul class="lead">
                <li><a href="{{ route('usuario.desarrolladora.show', $juego->desarrolladora->id) }}" target="blank">{{ $juego->desarrolladora->nombre }}</a></li>
            </ul>
        </div>
    </header>


    <main class="py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="row text-center">
                        <div class="col-3"><a href="General">General</a></div>
                        <div class="col-3"><a href="Sorteos">Actualizaciones</a></div>
                    </div>
                    <hr>
                    <h2>Posts</h2>
                </div>
                <div class="col-md-3 offset-1">
                    <h4>Juegos</h4>
                    <hr>
                </div>
            </div>
        </div>
    </main>
@endsection
