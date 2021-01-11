@extends("layouts.usuario.base")

@section('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section("content")
    <main class="p-3 pb-5">
        <div class="container bg-light p-3 shadow-lg rounded mt-4">
            <nav id="submenu" class="navbar navbar-expand-md sticky-top navbar-light shadow bg-white mt-4 mb-4 pt-3 pb-3">
                <button class="navbar-toggler ml-1" type="button" data-toggle="collapse" data-target="#collapsingNavbar">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="navbar-collapse collapse justify-content-between align-items-center w-100" id="collapsingNavbar">
                    <ul class="navbar-nav mx-auto submenu-items">
                        <li class="nav-item"><a class="nav-link" id="preferencias" href="">Preferencias</a></li>
                        @if ($usuario->solicitud)
                            <li class="nav-item"><a class="nav-link" id="solicitud" href="">Solicitud</a></li>
                        @endif
                        <li class="nav-item"><a class="nav-link" id="compras" href="">Compras</a></li>
                        <li class="nav-item"><a class="nav-link" id="desarrolladoras" href="">Desarrolladoras</a></li>
                        <li class="nav-item"><a class="nav-link" id="juegos" href="">Juegos</a></li>
                        <li class="nav-item"><a class="nav-link" id="campanias" href="">Campañas</a></li>
                        <li class="nav-item"><a class="nav-link" id="masters" href="">Masters</a></li>
                    </ul>
                </div>
            </nav>


            <div id="contenido">
                <div class="preferencias @if($seccion != null) d-none @endif">
                    <h2 class="mb-3">Mi cuenta</h2>
                    @if($usuario->ban)
                    <div class="alert alert-danger mb-3">
                        <h5>Motivo del ban:</h5>
                        <p>{{$usuario->motivo}}</p>
                        <small>Puede recibir más información poniéndose en contacto con soporte@indie4all.com</small>
                    </div>
                    @endif
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
                                <input type="text" name="username" class="form-control" id="username" value="{{ $usuario->username }}">
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
                    <div class="align-items-center mt-4">
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
                    <div class="mt-4">
                        <h5 class="mb-3">Logros</h5>
                        <div class="row">
                            @foreach ($logros as $logro)
                                <div class="col-6 col-md-4">
                                    <h5 class="text-center @if (!$logro->usuarios->contains(Auth::id())) text-muted @else text-primary @endif"><i class="{{ $logro->icono }}"></i> {{ $logro->nombre }}</h5>
                                    <p class="@if (!$logro->usuarios->contains(Auth::id())) text-muted @else text-primary @endif">{{ $logro->descripcion }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="compras @if($seccion != "compras") d-none @endif">
                    <div class="mt-4">
                        <h1>Compras</h1>
                        <hr>
                        @if ($usuario->compras->count() > 0)
                            @foreach ($usuario->compras as $compra)
                                {{ $compra }}
                            @endforeach
                        @else
                            No has realizado ninguna compra.
                        @endif
                    </div>
                </div>
                @if ($usuario->solicitud)
                    <div class="solicitud @if($seccion != "solicitud") d-none @endif">
                        <div class="mt-4">
                            <h1>Solicitud</h1>
                            <hr>
                            Tipo de la solicitud: {{ $usuario->solicitud->tipo }}
                            <br>
                            Nombre: {{ $usuario->solicitud->nombre }}
                            <br>
                            Email: {{ $usuario->solicitud->email }}
                            <br>
                            @if ($usuario->solicitud->tipo == "Desarrolladora")
                                Dirección: {{ $usuario->solicitud->direccion }}
                                <br>
                                Teléfono: {{ $usuario->solicitud->telefono }}
                                <br>
                                Url: {{ $usuario->solicitud->url }}
                                <br>
                                Comentario: {{ $usuario->solicitud->comentario }}
                            @endif
                        </div>
                    </div>
                @endif
                <div class="desarrolladoras @if($seccion != "desarrolladoras") d-none @endif">
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
                <div class="juegos @if($seccion != "juegos") d-none @endif">
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
                <div class="masters @if($seccion != "masters") d-none @endif">
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
                <div class="campanias @if($seccion != "campanias") d-none @endif">
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script>
        $(function() {
            $("#generos").select2({
                language: "es",
                width: "auto",
                placeholder: "Géneros",
            });
        });

    </script>
@endsection
