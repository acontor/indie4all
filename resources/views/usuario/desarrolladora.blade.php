@extends('layouts.base')

@section('content')


    <header>
        <img class="" src="https://i.pinimg.com/736x/38/2c/6a/382c6a6c057a298ea5aa9759d55f36f3.jpg">
        <div>
            <h1 class="font-weight-light">{{ $desarrolladora->nombre }}</h1>
            <ul class="lead">
                <li><a href="http://{{ $desarrolladora->url }}" target="blank">{{ $desarrolladora->url }}</a></li>
                <li><a href="mailto:{{ $desarrolladora->email }}" target="blank">{{ $desarrolladora->email }}</a></li>
                <li>{{ $desarrolladora->direccion }}</li>
                <li>{{ $desarrolladora->telefono }}</li>
            </ul>
        </div>
    </header>


    <main class="py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="row text-center">
                        <div class="col-3"><a href="General">General</a></div>
                        <div class="col-3"><a href="Sorteos">Sorteos</a></div>
                        <div class="col-3"><a href="Encuestas">Encuestas</a></div>
                        <div class="col-3"><a href="Contacto">Contacto</a></div>
                    </div>
                    <hr>
                    <h2>Posts</h2>
                </div>
                <div class="col-md-3 offset-1">
                    <h4>Juegos</h4>
                    <hr>
                    @foreach ($desarrolladora->juegos as $juego)
                        <!-- CAMBIAR ROUTE A JUEGO -->
                        <a href="{{ route('usuario.juego.show', $juego->id) }}">{{ $juego->nombre }}</p>
                    @endforeach
                </div>
            </div>
        </div>
    </main>
@endsection
