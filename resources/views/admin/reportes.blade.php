@extends("layouts.admin.base")
@section("styles")
    <link href="{{ asset('css/datatable.css') }}" rel="stylesheet">
@endsection
@section("content")
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="box-header">
                    <h1>Reportes ({{ $desarrolladoras->count() + $posts->count() + $mensajes->count() + $juegos->count() + $campanias->count() + $encuestas->count() + $sorteos->count() + $masters->count() }})</h1>
                </div>
                <div class="row box text-center menu mb-4">
                    @if ($desarrolladoras->count() > 0)
                        <div class="col-4 col-md-3 mb-2"><a id="desarrolladoras" href="">Desarrolladoras</a></div>
                    @endif
                    @if ($juegos->count() > 0)
                        <div class="col-4 col-md-3 mb-2"><a id="juegos" href="">Juegos</a></div>
                    @endif
                    @if ($campanias->count() > 0)
                        <div class="col-4 col-md-3 mb-2"><a id="campanias" href="">Campañas</a></div>
                    @endif
                    @if ($masters->count() > 0)
                        <div class="col-4 col-md-3 mb-2"><a id="masters" href="">Masters</a></div>
                    @endif
                    @if ($sorteos->count() > 0)
                        <div class="col-4 col-md-3"><a id="sorteos" href="">Sorteos</a></div>
                    @endif
                    @if ($encuestas->count() > 0)
                        <div class="col-4 col-md-3"><a id="encuestas" href="">Encuestas</a></div>
                    @endif
                    @if ($posts->count() > 0)
                        <div class="col-4 col-md-3"><a id="posts" href="">Posts</a></div>
                    @endif
                    @if ($mensajes->count() > 0)
                        <div class="col-4 col-md-3"><a id="mensajes" href="">Mensajes</a></div>
                    @endif
                </div>
                <div id="main">
                    @if ($desarrolladoras->count() > 0)
                        <div class="box desarrolladoras">
                            <h2>Desarrolladoras</h2>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <td>Nombre</td>
                                        <td>Número de reportes</td>
                                        <td>Acciones</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($desarrolladoras as $desarrolladora)
                                        <tr>
                                            <td class="align-middle">{{ $desarrolladora->desarrolladora->nombre }}</td>
                                            <td>{{ $reportes->where('desarrolladora_id', $desarrolladora->desarrolladora_id)->count() }}</td>
                                            @foreach ($reportes->where('desarrolladora_id', $desarrolladora->desarrolladora_id) as $reporte)
                                                <td class="align-middle">{{ $reporte->usuario->email }}</td>
                                                <td class="align-middle">{{ $reporte->motivo }}</td>
                                            @endforeach
                                            <td class="align-middle">
                                                <div class="btn-group">
                                                    <form action="">
                                                        <button class="btn btn-success btn-sm round ml-1" type="submit">
                                                            <i class="far fa-check-square"></i>
                                                        </button>
                                                    </form>
                                                    <button class="btn btn-danger btn-sm round ml-1 rechazar-desarrolladora" type="submit">
                                                        <i class="far fa-trash-alt"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                    @if ($posts->count() > 0)
                        <div class="box posts d-none">
                            <h2>Posts</h2>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <td>Título</td>
                                        <td>Número de reportes</td>
                                        <td>Acciones</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($posts as $post)
                                        <tr>
                                            <td class="align-middle">{{ $post->post->titulo }}</td>
                                            <td>{{ $reportes->where('post_id', $post->post_id)->count() }}</td>
                                            @foreach ($reportes->where('post_id', $post->post_id) as $reporte)
                                                <td class="align-middle">{{ $reporte->usuario->email }}</td>
                                                <td class="align-middle">{{ $reporte->motivo }}</td>
                                            @endforeach
                                            <td class="align-middle">
                                                <div class="btn-group">
                                                    <form action="">
                                                        <button class="btn btn-success btn-sm round ml-1" type="submit">
                                                            <i class="far fa-check-square"></i>
                                                        </button>
                                                    </form>
                                                    <button class="btn btn-danger btn-sm round ml-1 rechazar-desarrolladora" type="submit">
                                                        <i class="far fa-trash-alt"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                    @if ($mensajes->count() > 0)
                        <div class="box mensajes d-none">
                            <h2>Mensajes</h2>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <td>Título</td>
                                        <td>Número de reportes</td>
                                        <td>Acciones</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($mensajes as $mensaje)
                                        <tr>
                                            <td class="align-middle">{!! $mensaje->mensaje->contenido !!}</td>
                                            <td>{{ $reportes->where('mensaje_id', $mensaje->mensaje_id)->count() }}</td>
                                            @foreach ($reportes->where('mensaje_id', $mensaje->mensaje_id) as $reporte)
                                                <td class="align-middle">{{ $reporte->usuario->email }}</td>
                                                <td class="align-middle">{{ $reporte->motivo }}</td>
                                            @endforeach
                                            <td class="align-middle">
                                                <div class="btn-group">
                                                    <form action="">
                                                        <button class="btn btn-success btn-sm round ml-1" type="submit">
                                                            <i class="far fa-check-square"></i>
                                                        </button>
                                                    </form>
                                                    <button class="btn btn-danger btn-sm round ml-1 rechazar-desarrolladora" type="submit">
                                                        <i class="far fa-trash-alt"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                    @if ($juegos->count() > 0)
                        <div class="box juegos d-none">
                            <h2>Juegos</h2>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <td>Nombre</td>
                                        <td>Número de reportes</td>
                                        <td>Acciones</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($juegos as $juego)
                                        <tr>
                                            <td class="align-middle">{{ $juego->juego->nombre }}</td>
                                            <td>{{ $reportes->where('juego_id', $juego->juego_id)->count() }}</td>
                                            @foreach ($reportes->where('juego_id', $juego->juego_id) as $reporte)
                                                <td class="align-middle">{{ $reporte->usuario->email }}</td>
                                                <td class="align-middle">{{ $reporte->motivo }}</td>
                                            @endforeach
                                            <td class="align-middle">
                                                <div class="btn-group">
                                                    <form action="">
                                                        <button class="btn btn-success btn-sm round ml-1" type="submit">
                                                            <i class="far fa-check-square"></i>
                                                        </button>
                                                    </form>
                                                    <button class="btn btn-danger btn-sm round ml-1 rechazar-desarrolladora" type="submit">
                                                        <i class="far fa-trash-alt"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                    @if ($campanias->count() > 0)
                        <div class="box campanias d-none">
                            <h2>Campañas</h2>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <td>Nombre</td>
                                        <td>Número de reportes</td>
                                        <td>Acciones</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($campanias as $campania)
                                        <tr>
                                            <td class="align-middle">{{ $campania->campania->juego->nombre }}</td>
                                            <td>{{ $reportes->where('campania_id', $campania->campania_id)->count() }}</td>
                                            @foreach ($reportes->where('campania_id', $campania->campania_id) as $reporte)
                                                <td class="align-middle">{{ $reporte->usuario->email }}</td>
                                                <td class="align-middle">{{ $reporte->motivo }}</td>
                                            @endforeach
                                            <td class="align-middle">
                                                <div class="btn-group">
                                                    <form action="">
                                                        <button class="btn btn-success btn-sm round ml-1" type="submit">
                                                            <i class="far fa-check-square"></i>
                                                        </button>
                                                    </form>
                                                    <button class="btn btn-danger btn-sm round ml-1 rechazar-desarrolladora" type="submit">
                                                        <i class="far fa-trash-alt"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                    @if ($encuestas->count() > 0)
                        <div class="box encuestas d-none">
                            <h2>Encuestas</h2>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <td>Pregunta</td>
                                        <td>Número de reportes</td>
                                        <td>Acciones</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($encuestas as $encuesta)
                                        <tr>
                                            <td class="align-middle">{{ $encuesta->encuesta->pregunta }}</td>
                                            <td>{{ $reportes->where('encuesta_id', $encuesta->encuesta_id)->count() }}</td>
                                            @foreach ($reportes->where('encuesta_id', $encuesta->encuesta_id) as $reporte)
                                                <td class="align-middle">{{ $reporte->usuario->email }}</td>
                                                <td class="align-middle">{{ $reporte->motivo }}</td>
                                            @endforeach
                                            <td class="align-middle">
                                                <div class="btn-group">
                                                    <form action="">
                                                        <button class="btn btn-success btn-sm round ml-1" type="submit">
                                                            <i class="far fa-check-square"></i>
                                                        </button>
                                                    </form>
                                                    <button class="btn btn-danger btn-sm round ml-1 rechazar-desarrolladora" type="submit">
                                                        <i class="far fa-trash-alt"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                    @if ($sorteos->count() > 0)
                        <div class="box sorteos d-none">
                            <h2>Sorteos</h2>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <td>Título</td>
                                        <td>Número de reportes</td>
                                        <td>Acciones</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sorteos as $sorteo)
                                        <tr>
                                            <td class="align-middle">{{ $sorteo->sorteo->pregunta }}</td>
                                            <td>{{ $reportes->where('sorteo_id', $sorteo->sorteo_id)->count() }}</td>
                                            @foreach ($reportes->where('sorteo_id', $sorteo->sorteo_id) as $reporte)
                                                <td class="align-middle">{{ $reporte->usuario->email }}</td>
                                                <td class="align-middle">{{ $reporte->motivo }}</td>
                                            @endforeach
                                            <td class="align-middle">
                                                <div class="btn-group">
                                                    <form action="">
                                                        <button class="btn btn-success btn-sm round ml-1" type="submit">
                                                            <i class="far fa-check-square"></i>
                                                        </button>
                                                    </form>
                                                    <button class="btn btn-danger btn-sm round ml-1 rechazar-desarrolladora" type="submit">
                                                        <i class="far fa-trash-alt"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                    @if ($masters->count() > 0)
                        <div class="box masters d-none">
                            <h2>Masters</h2>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <td>Nombre</td>
                                        <td>Número de reportes</td>
                                        <td>Acciones</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($masters as $master)
                                        <tr>
                                            <td class="align-middle">{{ $master->master->usuario->username }}</td>
                                            <td>{{ $reportes->where('master_id', $master->master_id)->count() }}</td>
                                            @foreach ($reportes->where('master_id', $master->master_id) as $reporte)
                                                <td class="align-middle">{{ $reporte->usuario->email }}</td>
                                                <td class="align-middle">{{ $reporte->motivo }}</td>
                                            @endforeach
                                            <td class="align-middle">
                                                <div class="btn-group">
                                                    <form action="">
                                                        <button class="btn btn-success btn-sm round ml-1" type="submit">
                                                            <i class="far fa-check-square"></i>
                                                        </button>
                                                    </form>
                                                    <button class="btn btn-danger btn-sm round ml-1 rechazar-desarrolladora" type="submit">
                                                        <i class="far fa-trash-alt"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
@section("scripts")
    <script src="{{ asset('js/datatable.js') }}"></script>
    <script type="text/javascript">
        $(function() {

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
