@extends("layouts.usuario.base")

@section("content")
    <main class="p-3 pb-5">
        <div class="container">
            <div class="box-header">
                <h1>Masters ({{ $masters->count() }})</h1>
            </div>
            <div class="box">
                @foreach ($masters as $master)
                    <hr>
                    <div class="row">
                        <a href="{{ route('usuario.master.show', $master->id) }}">{{ $master->usuario->name }}</a>
                    </div>
                @endforeach
            </div>
        </div>
    </main>
@endsection
