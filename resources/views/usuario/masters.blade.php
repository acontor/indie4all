@extends('layouts.base')

@section('content')
    <main class="py-4">
        <div class="container">
            <h5>Usuarios Masters</h5>
            @foreach ($masters as $master)
                <hr>
                <div class="row">
                    <a
                        href="{{ route('usuario.master.show', $master->id) }}">{{ $master->usuario->name }}</a>
                </div>
            @endforeach
        </div>
    </main>
@endsection
