@extends("layouts.usuario.base")
@section("styles")
    <link href="{{ asset('css/cm.css') }}" rel="stylesheet">
@endsection
@section("content")
    <div class="container">
        <div class="row">
            <div class="col-sm">
                <div class="box-header">
                    <h1 class="d-inline-block">Campañas ({{ $campanias->count() }})</h1>
                </div>
            </div>
        </div>
        <div class="row">
            <section>
                <div class="container">
                    <div class="row">
                        @foreach ($campanias as $campania)
                            <div class="mt-4 mr-4">
                                <div class="card">
                                    <img src="{{url('/images/juegos/portadas/'.$campania->juego->imagen_portada)}}"width="250" height="200" />
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $campania->juego->nombre }}
                                        </h5>
                                        <p class="date-lanzamiento"> {{ $campania->juego->fecha_lanzamiento }}
                                            <span class="genero">{{ $campania->juego->genero->nombre }}</span>
                                        </p>
                                        <p class="card-text">
                                            Meta: {{ $campania->meta }} €<br>
                                            Recaudado: {{$campania->recaudado}} € <br>
                                        </p>
                                        <div class="row">        
                                            <a href="{{route('usuario.campania.show', $campania->id)}}"> Ver Campaña </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection