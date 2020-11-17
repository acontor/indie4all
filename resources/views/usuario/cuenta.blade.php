@extends("layouts.usuario.base")

@section("content")
    <main class="py-4">
        <div class="container">
            <div class="box-header mt-4">
                <h5>Mi cuenta</h5>
            </div>
            <div class="box">
                <p>{{ $usuario->name }}</p>
                Datos para poder editarlos
            </div>

            <div class="box-header mt-4">
                <h6>Géneros</h6>
            </div>
            <div class="box align-items-center">
                @foreach ($generos as $genero)
                    <input type="checkbox" name="generos[]"> {{ $genero->nombre }}
                @endforeach
            </div>
            <div class="box-header mt-4">
                <h5>Logros</h5>
            </div>
            <div class="box">
                @foreach ($logros as $logro)
                    @foreach ($usuario->logros as $conseguido)
                    <p><i class="{{ $logro->icono }}"></i> {{ $logro->nombre }} - {{ $logro->descripcion }} @if ($conseguido->nombre == $logro->nombre) !Conseguido¡ @endif</p>
                    @endforeach
                @endforeach
            </div>
{{--
            <h5>Solicitud</h5>
            {{ $usuario->solicitud->where("user_id", $usuario->id)->get()->count() }}
 --}}
            <div class="box-header mt-4">
                <h5>Desarrolladoras</h5>
            </div>
            <div class="box">
                @if ($usuario->desarrolladoras->count() == 0)
                    Date una vuelta por nuestras desarrolladoras y sigue a tus favortias.
                @else
                    @foreach ($usuario->desarrolladoras as $desarrolladora)
                        {{ $desarrolladora->nombre }}
                        <form action="{{ route('usuario.desarrolladora.unfollow', $desarrolladora->id) }}" method="post">
                            @csrf
                            <button type="submit" class="btn text-danger"><i class="far fa-times-circle"></i></button>
                        </form>
                        @if ($desarrolladora->pivot->notificacion == 0)
                            <form action="{{ route('usuario.desarrolladora.notificacion', [$desarrolladora->id, 1]) }}"
                                method="post">
                                @csrf
                                <button type="submit" class="btn text-primary"><i class="far fa-bell"></i></button>
                            </form>
                        @else
                            <form action="{{ route('usuario.desarrolladora.notificacion', [$desarrolladora->id, 0]) }}"
                                method="post">
                                @csrf
                                <button type="submit" class="btn text-danger"><i class="far fa-bell-slash"></i></button>
                            </form>
                        @endif
                    @endforeach
                @endif
            </div>
            <div class="box-header mt-4">
                <h5>Juegos</h5>
            </div>
            <div class="box">
                @if ($usuario->juegos->count() == 0)
                    ¿No te gusta ningún juego?
                @else
                    @foreach ($usuario->juegos as $juego)
                        {{ $juego->nombre }}
                        <form action="{{ route('usuario.juego.unfollow', $juego->id) }}" method="post">
                            @csrf
                            <button type="submit" class="btn text-danger"><i class="far fa-times-circle"></i></button>
                        </form>
                        @if ($juego->pivot->notificacion == 0)
                            <form action="{{ route('usuario.juego.notificacion', [$juego->id, 1]) }}"
                                method="post">
                                @csrf
                                <button type="submit" class="btn text-primary"><i class="far fa-bell"></i></button>
                            </form>
                        @else
                            <form action="{{ route('usuario.juego.notificacion', [$juego->id, 0]) }}"
                                method="post">
                                @csrf
                                <button type="submit" class="btn text-danger"><i class="far fa-bell-slash"></i></button>
                            </form>
                        @endif
                    @endforeach
                @endif
            </div>
            <div class="box-header mt-4">
                <h5>Masters</h5>
            </div>
            <div class="box">
                @if ($usuario->masters->count() == 0)
                    ¡Te animamos a que descubras a nuestros masters!
                @else
                    @foreach ($usuario->masters as $master)
                        {{ $master->nombre }}
                        <form action="{{ route('usuario.master.unfollow', $master->id) }}" method="post">
                            @csrf
                            <button type="submit" class="btn text-danger"><i class="far fa-times-circle"></i></button>
                        </form>
                        @if ($master->pivot->notificacion == 0)
                            <form action="{{ route('usuario.master.notificacion', [$master->id, 1]) }}"
                                method="post">
                                @csrf
                                <button type="submit" class="btn text-primary"><i class="far fa-bell"></i></button>
                            </form>
                        @else
                            <form action="{{ route('usuario.master.notificacion', [$master->id, 0]) }}"
                                method="post">
                                @csrf
                                <button type="submit" class="btn text-danger"><i class="far fa-bell-slash"></i></button>
                            </form>
                        @endif
                    @endforeach
                @endif
            </div>

        {{--     <h5>Camapañas</h5>
            @foreach ($usuario->campanias as $campania)
                {{ $campania }}
            @endforeach --}}
        </div>
    </main>
@endsection
