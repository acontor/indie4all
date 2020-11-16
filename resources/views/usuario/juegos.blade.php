@extends("layouts.usuario.base")

@section("content")
    <main class="py-4">
        <div class="container">
            <div class="box-header">
                <h1>Juegos ({{ $juegos->count() }})</h1>
            </div>
            <div class="box">
                @foreach ($juegos as $juego)
                    <hr>
                    <div class="row">
                        <a href="{{ route("usuario.juego.show", $juego->id) }}">{{ $juego->nombre }}</a>
                    </div>
                @endforeach
            </div>
        </div>
    </main>
@endsection
