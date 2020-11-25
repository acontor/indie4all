@extends("layouts.usuario.base")
@section("styles")
    <link href="{{ asset('css/cm.css') }}" rel="stylesheet">
@endsection
@section("content")
    <main class="py-4">
        <div class="container">
            <div class="row">
                <div class="col-sm">
                    <div class="box-header">
                        <h1 class="d-inline-block">Juegos ({{ $juegos->count() }})</h1>
                    </div>
                </div>
            </div>
            <div class="row">
                <section>
                    <div class="container">
                        <div class="row">
                            @foreach ($juegos as $juego)
                                <div class="mt-4 mr-4">
                                    <div class="card">
                                        <img src="{{url('/images/juegos/portadas/'.$juego->imagen_portada)}}"width="250" height="200" />
                                        <div class="card-body">
                                            <h5 class="card-title">
                                                <a href="{{ route('usuario.juego.show', $juego->id) }}">{{ $juego->nombre }}</a>
                                            </h5>
                                            <p class="date-lanzamiento"> {{ $juego->fecha_lanzamiento }}
                                                <span class="genero">{{ $juego->genero->nombre }}</span>
                                            </p>
                                            <p class="card-text">
                                                {{ $juego->sinopsis }}
                                            </p>
                                            <div class="row">
                                            {{-- Botonos de follow/unfollow notificaciones --}}
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
    </main>
@endsection
