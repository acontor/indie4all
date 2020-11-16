@extends("layouts.usuario.base")

@section("content")
    <main class="py-4">
        <div class="container">
            <h5>Mi cuenta</h5>
            <p>{{ $usuario->name }}</p>

            <h6>Géneros</h6>
            @foreach ($usuario->generos as $genero)
                {{ $genero }}
            @endforeach

            <h5>Logros</h5>
            @foreach ($usuario->logros as $logro)
                {{ $logro }}
            @endforeach
{{--
            <h5>Solicitud</h5>
            {{ $usuario->solicitud->where("user_id", $usuario->id)->get()->count() }}
 --}}
            <h5>Desarrolladoras</h5>
            @foreach ($usuario->desarrolladoras as $desarrolladora)
                {{ $desarrolladora->nombre }}
                <form action="{{ route("usuario.desarrolladora.unfollow", $desarrolladora->id) }}" method="post">
                    @csrf
                    <button type="submit" class="btn text-danger"><i class="far fa-times-circle"></i></button>
                </form>
                @if ($desarrolladora->pivot->notificacion == 0)
                    <form action="{{ route("usuario.desarrolladora.notificacion", [$desarrolladora->id, 1]) }}"
                        method="post">
                        @csrf
                        <button type="submit" class="btn text-primary"><i class="far fa-bell"></i></button>
                    </form>
                @else
                    <form action="{{ route("usuario.desarrolladora.notificacion", [$desarrolladora->id, 0]) }}"
                        method="post">
                        @csrf
                        <button type="submit" class="btn text-danger"><i class="far fa-bell-slash"></i></button>
                    </form>
                @endif
            @endforeach

            <h5>Juegos</h5>
            @foreach ($usuario->juegos as $juego)
                {{ $juego->nombre }}
                <form action="{{ route("usuario.juego.unfollow", $juego->id) }}" method="post">
                    @csrf
                    <button type="submit" class="btn text-danger"><i class="far fa-times-circle"></i></button>
                </form>
                @if ($juego->pivot->notificacion == 0)
                    <form action="{{ route("usuario.juego.notificacion", [$juego->id, 1]) }}"
                        method="post">
                        @csrf
                        <button type="submit" class="btn text-primary"><i class="far fa-bell"></i></button>
                    </form>
                @else
                    <form action="{{ route("usuario.juego.notificacion", [$juego->id, 0]) }}"
                        method="post">
                        @csrf
                        <button type="submit" class="btn text-danger"><i class="far fa-bell-slash"></i></button>
                    </form>
                @endif
            @endforeach

            <h5>Masters</h5>
            @foreach ($usuario->masters as $master)
                {{ $master->nombre }}
                <form action="{{ route("usuario.master.unfollow", $master->id) }}" method="post">
                    @csrf
                    <button type="submit" class="btn text-danger"><i class="far fa-times-circle"></i></button>
                </form>
                @if ($master->pivot->notificacion == 0)
                    <form action="{{ route("usuario.master.notificacion", [$master->id, 1]) }}"
                        method="post">
                        @csrf
                        <button type="submit" class="btn text-primary"><i class="far fa-bell"></i></button>
                    </form>
                @else
                    <form action="{{ route("usuario.master.notificacion", [$master->id, 0]) }}"
                        method="post">
                        @csrf
                        <button type="submit" class="btn text-danger"><i class="far fa-bell-slash"></i></button>
                    </form>
                @endif
            @endforeach

        {{--     <h5>Camapañas</h5>
            @foreach ($usuario->campanias as $campania)
                {{ $campania }}
            @endforeach --}}
        </div>
    </main>
@endsection
