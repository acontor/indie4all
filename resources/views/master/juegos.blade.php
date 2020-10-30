@extends('layouts.base')

@section('content')
    <main class="py-4">
        <div class="container">
            <h5>Juegos</h5>
            @foreach ($juegos as $juego)
                <hr>
                <div class="row">
                    <a
                        href="{{ route('master.juego.show', $juego->id) }}">{{ $juego->nombre }}</a>
                </div>
            @endforeach
        </div>
    </main>
@endsection
