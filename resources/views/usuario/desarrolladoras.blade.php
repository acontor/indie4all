@extends('layouts.base')

@section('content')
    <main class="py-4">
        <div class="container">
            <h5>Desarrolladoras</h5>
            <a href="{{ route('usuario.desarrolladora.create') }}" class="btn btn-primary">Enviar solicitud</a>
            @foreach ($desarrolladoras as $desarrolladora)
                <hr>
                <div class="row">
                    <a href="{{ route('usuario.desarrolladora.show', $desarrolladora->id) }}">{{ $desarrolladora->nombre }}</a>
                </div>
            @endforeach
        </div>
    </main>
@endsection
