@extends('layouts.base')

@section('content')


    <header>
        <img class="" src="https://i.pinimg.com/736x/38/2c/6a/382c6a6c057a298ea5aa9759d55f36f3.jpg">
        <div>

            <h1 class="font-weight-light">{{ $master->usuario->name }}</h1>
            <ul class="lead">
                <li> Email: {{ $master->email }}</li>
                <li> imagen: {{ $master->imagen }}</li>
            </ul>
        </div>
    </header>


    <main class="py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="row text-center">
                        <div class="col-3"><a href="General">General</a></div>
                        <div class="col-3"><a href="Sorteos">Análisis</a></div>
                    </div>
                    <hr>
                    <h2>Posts</h2>
                </div>

            </div>
        </div>
    </main>
@endsection
