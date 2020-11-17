@extends("layouts.usuario.base")

@section("content")
    <main class="py-4">
        <div class="container">
            <div class="box-header">
                <h1>Desarrolladoras ({{ $desarrolladoras->count() }})</h1>
            </div>
            <div class="box">
                @if (App\Models\Cm::where("user_id", Auth::id())->count() == 0)
                    <a href="{{ route('usuario.desarrolladora.create') }}" class="btn btn-primary">Enviar solicitud</a>
                @endif
                @foreach ($desarrolladoras as $desarrolladora)
                    <hr>
                    <div class="row">
                        <a href="{{ route('usuario.desarrolladora.show', $desarrolladora->id) }}">{{ $desarrolladora->nombre }}</a>
                    </div>
                @endforeach
            </div>
        </div>
    </main>
@endsection
