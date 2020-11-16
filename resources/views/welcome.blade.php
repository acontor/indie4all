@extends("layouts.usuario.base")

@section("content")
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __("Dashboard") }}</div>
                    <div class="card-body">
                        <h3>Noticias</h3>
                        @foreach ($noticias as $noticia)
                            {{ $noticia->titulo }}
                            {!! $noticia->contenido !!}
                            {{ $noticia->created_at }}
                            <a href="{{ $noticia->id }}">Leer más</a>
                            <hr>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">Juegos</div>
                    <div class="card-body">
                        <ul>
                            @foreach ($juegos as $juego)
                                <li>{{ $juego->nombre }} - Punt.
                                    {{ $juego->usuarios->sum("pivot.calificacion") / $juego->usuarios->count() }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="card mt-3">
                    <div class="card-header">Desarrolladoras</div>
                    <div class="card-body">
                        <ul>
                            @foreach ($desarrolladoras as $desarrolladora)
                                <li>{{ $desarrolladora->nombre }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="card mt-3">
                    <div class="card-header">Masters</div>
                    <div class="card-body">
                        <ul>
                            @foreach ($masters as $master)
                                <li>{{ $master->usuario->name }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
