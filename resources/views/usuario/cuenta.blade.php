@extends("layouts.usuario.base")

@section('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <link href="{{ asset('css/datatable/datatable.css') }}" rel="stylesheet">
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
                        <li class="nav-item"><a class="nav-link" id="juegos" href="">Colección de juegos</a></li>
                        <li class="nav-item"><a class="nav-link" id="campanias" href="">Campañas</a></li>
                        <li class="nav-item"><a class="nav-link" id="desarrolladoras" href="">Desarrolladoras</a></li>
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
                            <div class="table-responsive p-3">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <td>Juego</td>
                                            <td>Precio</td>
                                            <td>Fecha</td>
                                            <td>Clave</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($usuario->compras->where('campania_id', null) as $compra)
                                            <tr>
                                                <td class="align-middle">{{ $compra->juego->nombre }}</td>
                                                <td class="align-middle">{{ $compra->precio }}</td>
                                                <td class="align-middle">{{ $compra->fecha_compra }}</td>
                                                <td class="align-middle">{{ $compra->key }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
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
                <div class="desarrolladoras p-4 @if($seccion != "desarrolladoras") d-none @endif">
                    <h5 class="mb-3">Desarrolladoras</h5>
                    @if ($usuario->desarrolladoras->count() == 0)
                        Date una vuelta por nuestras <a href="{{ route('usuario.desarrolladoras.index') }}">desarrolladoras</a> y sigue a tus favortias.
                    @else
                    <div class="row mb-4 mt-2">
                        @foreach ($usuario->desarrolladoras as $desarrolladora)
                        <div class="col-md-3 col-sm-6 mt-4 item">
                            <div class="card item-card card-block">
                                @if ($desarrolladora->imagen_portada != null)
                                    <img class="img-fluid shadow" src="{{ asset('/images/desarrolladoras/' . $desarrolladora->nombre . '/' . $desarrolladora->imagen_portada) }}" alt="{{ $desarrolladora->nombre }}">
                                @else
                                    <img class="img-fluid shadow" src="{{ asset('/images/desarrolladoras/default-portada-desarrolladora.png') }}" alt="{{ $desarrolladora->nombre }}">
                                @endif
                                <div class="p-3">
                                    <h5><a href="{{ route('usuario.desarrolladora.show', $desarrolladora->id) }}">{{ $desarrolladora->nombre }}</a></h5>
                                    Sequidores:<small class="float-right"> {{$desarrolladora->seguidores_count}}</small><br>
                                    Juegos:<small class="float-right"> {{$desarrolladora->juegos_count}}</small><br>
                                    Actividad:<small class="float-right"> {{$desarrolladora->posts_count}}</small><br>
                                    <div class="row float-right">
                                        <form action="{{ route('usuario.desarrolladora.unfollow', $desarrolladora->id) }}" method="post">
                                            @csrf
                                            <button type="submit" class="btn btn-light text-danger"><i class="far fa-times-circle"></i></button>
                                        </form>
                                        @if ($desarrolladora->pivot->notificacion == 0)
                                            <form action="{{ route('usuario.desarrolladora.notificacion', [$desarrolladora->id, 1]) }}"
                                                method="post">
                                                @csrf
                                                <button type="submit" class="btn btn-light text-primary text-primary mr-1"><i class="far fa-bell"></i></button>
                                            </form>
                                        @else
                                            <form action="{{ route('usuario.desarrolladora.notificacion', [$desarrolladora->id, 0]) }}"
                                                method="post">
                                                @csrf
                                                <button type="submit" class="btn btn-light text-danger ml-2 mr-1"><i class="far fa-bell-slash"></i></button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
                <div class="juegos p-4 @if($seccion != "juegos") d-none @endif">
                    <h5 class="mb-3">Tu Colección</h5>
                    @if ($usuario->juegos->count() == 0)
                        ¿No te gusta ningún <a href="{{ route('usuario.juegos.index') }}">juego</a>?
                    @else
                        <div class="row mb-4 mt-2">
                            @foreach ($usuario->juegos as $juego)
                                @empty($juego->campania)
                                    <div class="col-md-3 col-sm-6 mt-4 item">
                                        <div class="card item-card card-block">
                                            @if ($juego->imagen_portada != null)
                                                <img class="img-fluid shadow" src="{{ asset('/images/desarrolladoras/' . $juego->desarrolladora->nombre . '/' . $juego->nombre . '/' . $juego->imagen_portada) }}" alt="{{ $juego->nombre }}">
                                            @else
                                                <img class="img-fluid shadow" src="{{ asset('/images/desarrolladoras/default-portada-juego.png') }}" alt="{{ $juego->nombre }}">
                                            @endif
                                            <div class="p-3">
                                                <h5><a href="{{ route('usuario.juego.show', $juego->id) }}">{{ $juego->nombre }}</a></h5>
                                                <a href="/juegos/lista/{{$juego->genero_id}}"><small class="badge badge-danger badge-pill ml-2">{{App\Models\Genero::find($juego->genero_id)->nombre}}</small></a><br>
                                                <small class="float-right"> {{$juego->fecha_lanzamiento}}</small><br>
                                                Popularidad:<small class="float-right"> {{$juego->compras->count()}}</small><br>
                                                Precio:<small class="float-right"> {{$juego->precio}}</small><br>
                                                <div class="row float-right">
                                                    <form method="post" action="{{ route('usuario.juego.unfollow', $juego->id) }}">
                                                        @csrf
                                                        <button type="submit" class="btn btn-light text-danger">
                                                            <i class="far fa-times-circle"></i>
                                                        </button>
                                                    </form>
                                                    @if (Auth::user()->juegos->where('id', $juego->id)->first()->pivot->notificacion == 0)
                                                        <form method="post"
                                                            action="{{ route('usuario.juego.notificacion', [$juego->id, 1]) }}">
                                                            @csrf
                                                            <button type="submit" class="btn btn-light text-primary text-primary mr-1">
                                                                <i class="far fa-bell"></i></i>
                                                            </button>
                                                        </form>
                                                    @else
                                                        <form method="post"
                                                            action="{{ route('usuario.juego.notificacion', [$juego->id, 0]) }}">
                                                            @csrf
                                                            <button type="submit" class="btn btn-light text-danger ml-2 mr-1">
                                                                <i class="far fa-bell-slash"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endempty
                            @endforeach
                        </div>
                    @endif
                </div>
                <div class="masters p-4 @if($seccion != "masters") d-none @endif">
                    <h5>Masters</h5>
                    @if ($usuario->masters->count() == 0)
                        ¡Te animamos a que descubras a nuestros <a href="{{ route('usuario.masters.index') }}">masters</a>!
                    @else
                        <div class="row mb-4 mt-2">
                            @foreach ($usuario->masters as $master)
                                <div class="col-md-3 col-sm-6 mt-4 item">
                                    <div class="card item-card card-block">
                                        @if ($master->imagen_portada != null)
                                            <img class="img-fluid shadow" src="{{ asset('/images/masters/' . $master->nombre . '/' . $master->imagen_portada) }}" alt="{{ $desarrolladora->nombre }}">
                                        @else
                                            <img class="img-fluid shadow" src="{{ asset('/images/masters/default-portada.png') }}" alt="{{ $master->nombre }}">
                                        @endif
                                        <div class="p-3">
                                            <h5><a href="{{ route('usuario.master.show', $master->id) }}">{{ $master->nombre }}</a></h5>
                                            Sequidores:<small class="float-right"> {{$master->seguidores->count()}}</small><br>
                                            Actividad:<small class="float-right"> {{$master->posts->count()}}</small><br>
                                            <div class="row float-right">
                                            <form action="{{ route('usuario.master.unfollow', $master->id) }}" method="post">
                                                @csrf
                                                <button type="submit" class="btn btn-light text-danger"><i class="far fa-times-circle"></i></button>
                                            </form>
                                            @if ($master->pivot->notificacion == 0)
                                                <form action="{{ route('usuario.master.notificacion', [$master->id, 1]) }}"
                                                    method="post">
                                                    @csrf
                                                <button type="submit" class="btn btn-light text-primary"><i class="far fa-bell"></i></button>
                                                </form>
                                            @else
                                                <form action="{{ route('usuario.master.notificacion', [$master->id, 0]) }}"
                                                    method="post">
                                                    @csrf
                                                <button type="submit" class="btn btn-light text-danger ml-2 mr-1"><i class="far fa-bell-slash"></i></button>
                                                </form>
                                            @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
                <div class="campanias p-4 @if($seccion != "campanias") d-none @endif">
                    <h5>Campañas</h5>
                    @if ($usuario->compras->where("campania_id", '!=', null)->count() > 0)
                        <div class="row mb-4 mt-2">
                            @foreach ($usuario->compras->where("campania_id", '!=', null) as $compra)
                            <div class="col-md-3 col-sm-6 mt-4 item">
                                <div class="card item-card card-block">
                                    @if (!$compra->campania->juego->imagen_portada)
                                        <img class="img-fluid h-auto" src="{{ asset('/images/desarrolladoras/default-portada-juego.png') }}">
                                    @else
                                        <img class="img-fluid h-auto animate__animated animate__fadeIn" src="{{ asset('/images/desarrolladoras/' . $compra->campania->juego->desarrolladora->nombre . '/' . $compra->campania->juego->imagen_portada) }}">
                                    @endif
                                    <div class="p-3">
                                        <h5><a href="{{ route('usuario.campania.show', $compra->campania->id) }}">{{ $compra->campania->juego->nombre }}</a></h5>
                                        Aporte:<small class="float-right"> {{$compra->precio}}€</small><br>
                                        Participaciones:<small class="float-right"> {{$compra->campania->compras->count()}}</small><br>
                                        Meta:<small class="float-right"> {{$compra->campania->meta}}€</small><br>
                                        Termina:<small class="float-right"> {{$compra->campania->fecha_fin}}</small>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        ¿A que esperas?, ¡participa en alguna <a href="{{ route('usuario.campanias.all') }}">campaña</a> que te guste!
                    @endif
                </div>
            </div>
        </div>
    </main>
@endsection

@section('scripts')
    <script src="{{ asset('js/datatable/datatable.js') }}"></script>
    <script src="{{ asset('js/datatable/script.js') }}"></script>
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
