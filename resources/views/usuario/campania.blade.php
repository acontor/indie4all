@extends("layouts.usuario.base")
@section('styles')
    <link href="{{ asset('css/cm.css') }}" rel="stylesheet">
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm">
                <div class="box-header">
                    <h1 class="d-inline-block">Campaña para {{ $campania->juego->nombre }}</h1>
                </div>
            </div>
        </div>
        <div class="row">
            <section>
                <div class="container">
                    <div class="row">

                        <div class="box">

                            <h5 class="card-title">{{ $campania->juego->nombre }}
                            </h5>
                            <p class="date-lanzamiento"> {{ $campania->juego->fecha_lanzamiento }}
                                <span class="genero">{{ $campania->juego->genero->nombre }}</span>
                            </p>
                            <p> {{ $campania->juego->sinopsis }}</p>
                            <p class="card-text">
                                Meta: {{ $campania->meta }} €<br>
                                Recaudado: {{ $campania->recaudado }} € <br>
                            </p>
                            <div class="row">
                                <a href=""> participar</a>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
        </section>
    </div>
    </div>
@endsection
