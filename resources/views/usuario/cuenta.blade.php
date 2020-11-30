@extends("layouts.usuario.base")
@section("content")
    <main class="py-4">
        <div class="container">
            <div class="row box text-center menu">
                <div class="col-4 col-md-2"><a id="preferencias" href="">Preferencias</a></div>
                <div class="col-4 col-md-2"><a id="compras" href="">Compras</a></div>
                @if ($usuario->solicitud)
                    <div class="col-4 col-md-2"><a id="solicitud" href="">Solicitud</a></div>
                @endif
                <div class="col-4 col-md-2"><a id="desarrolladoras" href="">Desarrolladoras</a></div>
                <div class="col-4 col-md-2"><a id="juegos" href="">Juegos</a></div>
                <div class="col-4 col-md-2"><a id="masters" href="">Masters</a></div>
                <div class="col-4 col-md-2"><a id="campanias" href="">Campañas</a></div>
            </div>
            {{$usuario->mensajes->count()}}
            <div id="main">
                <div class="preferencias">
                    <div class="box">
                        <h5 class="mb-3">Mi cuenta</h5>
                        <form action="{{ route('usuario.cuenta.usuario') }}" method="post">
                            @method("PATCH")
                            @csrf
                            <div class="row form-group">
                                <div class="col-md-4">
                                    <label for="nombre">Nombre:</label>
                                    <input type="text" name="nombre" class="form-control" id="nombre" value="{{ $usuario->name }}">
                                </div>
                                <div class="col-md-4 mt-3 mt-md-0">
                                    <label for="username">Nombre de usuario:</label>
                                    <input type="text" name="username" class="form-control" id="username">
                                </div>
                                <div class="col-md-4 mt-3 mt-md-0">
                                    <label for="email">Email:</label>
                                    <input type="email" name="email" class="form-control" id="email" value="{{ $usuario->email }}">
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-4 mt-3 mt-md-0">
                                    <label for="password">Nueva contraseña:</label>
                                    <input type="password" name="password" class="form-control" id="password">
                                </div>
                                <div class="col-md-4 mt-3 mt-md-0">
                                    <label for="password1">Repetir contraseña:</label>
                                    <input type="password" name="password1" class="form-control" id="password1">
                                </div>
                            </div>
                            <div class="row form-group align-items-end">
                                <div class="col-md-4">
                                    <label for="verify">Contraseña actual:</label>
                                    <input type="password" name="verify" class="form-control" id="verify">
                                </div>
                                <div class="col-md-4 mt-3">
                                    <button type="submit" class="btn btn-success">Editar</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    @if (session()->get("danger"))
                                        <div class="alert alert-danger">
                                            {{ session()->get("danger") }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="box align-items-center mt-4">
                        <h5 class="mb-3">Géneros</h5>
                        <form action="{{ route('usuario.cuenta.generos') }}" method="post">
                            @csrf
                            <select class="form-control select2" name="generos[]" id="generos" multiple>
                                @foreach ($generos as $genero)
                                    <option value="{{ $genero->id }}" @if ($genero->usuarios->contains(Auth::id())) selected @endif>{{ $genero->nombre }}<option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn btn-success">Guardar</button>
                        </form>
                    </div>
                    <div class="box mt-4">
                        <h5 class="mb-3">Logros</h5>
                        <div class="row">
                            @foreach ($logros as $logro)
                                <div class="col-2">
                                    <h5 class="text-center @if (!$logro->usuarios->contains(Auth::id())) text-muted @else text-primary @endif"><i class="{{ $logro->icono }}"></i> {{ $logro->nombre }}</h5>
                                    <p class="@if (!$logro->usuarios->contains(Auth::id())) text-muted @else text-primary @endif">{{ $logro->descripcion }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @if ($usuario->compras)
                <div class="compras d-none">
                    <div class="box-header mt-4">
                        <h5>Compras</h5>
                    </div>
                    <div class="box">
                        {{ $usuario->compras->count() }}
                    </div>
                </div>
                @endif
                @if ($usuario->solicitud)
                <div class="solicitud d-none">
                    <div class="box-header mt-4">
                        <h5>Solicitud</h5>
                    </div>
                    <div class="box">
                        {{ $usuario->solicitud->where("user_id", $usuario->id)->get()->count() }}
                    </div>
                </div>
                @endif
                <div class="desarrolladoras d-none">
                    <div class="box mt-4">
                        <h5 class="mb-3">Desarrolladoras</h5>
                        @if ($usuario->desarrolladoras->count() == 0)
                            Date una vuelta por nuestras <a href="{{ route('usuario.desarrolladoras.index') }}">desarrolladoras</a> y sigue a tus favortias.
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
                </div>
                <div class="juegos d-none">
                    <div class="box mt-4">
                        <h5 class="mb-3">Juegos</h5>
                        @if ($usuario->juegos->count() == 0)
                            ¿No te gusta ningún <a href="{{ route('usuario.juegos.index') }}">juego</a>?
                        @else
                            <div class="row">
                                @foreach ($usuario->juegos as $juego)
                                <div class="col-2">
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
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
                <div class="masters d-none">
                    <div class="box mt-4">
                        <h5 class="mb-3">Masters</h5>
                        @if ($usuario->masters->count() == 0)
                            ¡Te animamos a que descubras a nuestros <a href="{{ route('usuario.masters.index') }}">masters</a>!
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
                </div>
                <div class="campanias d-none">
                    <div class="box mt-4">
                        <h5 class="mb-3">Campañas</h5>
                        @if ($usuario->compras->where("campania_id", '!=', null)->count() > 0)
                            @foreach ($usuario->compras->where("campania_id", '!=', null) as $campania)
                                {{ $campania }}
                            @endforeach
                        @else
                            ¿A que esperas?, ¡participa en alguna <a href="{{ route('usuario.campanias.index') }}">campaña</a> que te guste!
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
@section('scripts')
    <script>
        $(function() {
            $("#generos").select2({
                language: "es",
                width: "auto",
                placeholder: "Géneros",
            });
            $(".menu").children("div").children("a").click(function(e) {
                console.log($(this).attr("id"))
                e.preventDefault();
                let item = $(this).attr("id");
                $("#main").children("div").addClass("d-none");
                $(`.${item}`).removeClass("d-none");
            });
        });

    </script>
@endsection
