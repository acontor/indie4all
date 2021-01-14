@extends("layouts.usuario.base")

@section("content")
    @if(Auth::user() && Auth::user()->master()->count() != 0 && Auth::user()->master->posts->where('juego_id', $juego->id)->count() == 0)
        <nav class="navbar navbar-expand-md navbar-dark shadow-sm bg-dark text-light">
            <span class="mx-auto">¿Quieres <a href="{{ route('master.analisis.create', $juego->id) }}">analizar</a> éste juego?</span>
        </nav>
    @endif

    <main class="p-3 pb-5">
        <div class="container bg-light p-3 shadow-lg rounded mt-4">
            <header class="header-imagen">
                @if ($juego->imagen_portada != null)
                    <img class="img-fluid shadow" src="{{ asset('/images/desarrolladoras/' . $juego->desarrolladora->nombre . '/' . $juego->nombre . '/' . $juego->imagen_portada) }}" alt="{{ $juego->nombre }}" style="filter: brightness(0.2)">
                @else
                    <img class="img-fluid shadow" src="{{ asset('/images/desarrolladoras/default-portada-juego.png') }}" alt="{{ $juego->nombre }}" style="filter: brightness(0.2)">
                @endif
                <div class="carousel-caption">
                    <h1><strong>{{ $juego->nombre }}</strong></h1>
                    <a class="nav-link mb-0 pop-info"
                    data-content="Haz click aquí para ver el perfil de la desarrolladora" rel="popover" data-placement="bottom" data-trigger="hover" href="{{ route('usuario.desarrolladora.show', $juego->desarrolladora->id) }}"><small>{{ $juego->desarrolladora->nombre }}</small></a>
                    <a class="nav-link mb-0 pop-info"
                    data-content="Haz click aquí para todos los juegos de este género" rel="popover" data-placement="bottom" data-trigger="hover" href="http://www.iestrassierra.net/alumnado/curso2021/DAWS/daws2021a1/indie4all/juegos/lista/{{$juego->genero->id}}"><small class="badge badge-danger">{{ $juego->genero->nombre }}</small></a>
                </div>
            </header>
            <div class="row mb-5">
                <div class="col-12 col-md-3 offset-md-2 p-4">
                    <div class="shadow p-4">
                        <h3 class="text-center">Usuarios</h3>
                        <div class="circle mx-auto nota-usuarios">
                            @if ($juego->seguidores->avg('pivot.calificacion') == null)
                                <span>-</span>
                            @else
                                <span>{{ number_format($juego->seguidores->avg('pivot.calificacion'), 2, '.', '') }}</span>
                            @endif
                            @if (Auth::user() != null && Auth::user()->email_verified_at != null && !Auth::user()->ban && !Auth::user()->master)
                                <select class="btn btn-dark btn-circle select-nota pop-info"
                                data-content="Haz click aquí para calificar el juego" rel="popover" data-placement="bottom" data-trigger="hover" name="" id="">
                                    <option value="null">-</option>
                                    @php
                                        $calificacion = Auth::user()->juegos->where('id', $juego->id)->first();
                                        if($calificacion !== null) {
                                            $nota = $calificacion->pivot->calificacion;
                                        } else {
                                            $nota = null;
                                        }
                                    @endphp
                                    @for ($i = 1; $i <= 10; $i++)
                                        <option value="{{$i}}" @if($nota == $i) selected @endif>{{$i}}</option>
                                    @endfor
                                </select>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-3 offset-md-2 p-4">
                    <div class="shadow p-4">
                        <h3 class="text-center">Masters</h3>
                        <div class="circle mx-auto">
                            @if ($juego->posts->avg('calificacion') == null)
                                -
                            @else
                                {{ $juego->posts->avg('calificacion') }}
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <nav id="submenu" class="navbar navbar-expand-md sticky-top navbar-light shadow bg-white mb-4 pt-3 pb-3">
                <div class="navbar-nav float-right-sm">
                    <div class="d-flex">
                        @auth
                            @if(Auth::user() && Auth::user()->cm()->count() != 0 && Auth::user()->cm->desarrolladora_id == $juego->desarrolladora_id)
                                <a class="btn btn-primary ml-2 pop-info"
                                data-content="Haz click aquí para editar el juego" rel="popover" data-placement="bottom" data-trigger="hover" href="{{ route('cm.juego.show', $juego->id) }}"><i class="fas fa-user-edit"></i></a>
                            @else
                                @if (Auth::user()->juegos->where('id', $juego->id)->count() == 0)
                                    <form method="post" action="{{ route('usuario.juego.follow', $juego->id) }}">
                                        @csrf
                                        <button type="submit" class="btn btn-light text-primary pop-info"
                                        data-content="Haz click aquí para seguir al juego" rel="popover" data-placement="bottom" data-trigger="hover">
                                            <i class="far fa-check-circle"></i>
                                        </button>
                                    </form>
                                @else
                                    <form method="post" action="{{ route('usuario.juego.unfollow', $juego->id) }}">
                                        @csrf
                                        <button type="submit" class="btn btn-light text-danger pop-info"
                                        data-content="Haz click aquí para dejar de seguir el juego" rel="popover" data-placement="bottom" data-trigger="hover">
                                            <i class="far fa-times-circle"></i>
                                        </button>
                                    </form>
                                    @if (Auth::user()->juegos->where('id', $juego->id)->first()->pivot->notificacion == 0)
                                        <form method="post"
                                            action="{{ route('usuario.juego.notificacion', [$juego->id, 1]) }}">
                                            @csrf
                                            <button type="submit" class="btn btn-light text-primary text-primary ml-2 pop-info"
                                            data-content="Haz click aquí para activar las notificaciones del juego" rel="popover" data-placement="bottom" data-trigger="hover">
                                                <i class="far fa-bell"></i></i>
                                            </button>
                                        </form>
                                    @else
                                        <form method="post"
                                            action="{{ route('usuario.juego.notificacion', [$juego->id, 0]) }}">
                                            @csrf
                                            <button type="submit" class="btn btn-light text-danger ml-2 pop-info"
                                            data-content="Haz click aquí para desactivar las notificaciones del juego" rel="popover" data-placement="bottom" data-trigger="hover">
                                                <i class="far fa-bell-slash"></i>
                                            </button>
                                        </form>
                                    @endif
                                @endif
                            @endif
                        @endauth
                        <button class="btn btn-warning compartir ml-2 pop-info"
                        data-content="Haz click aquí para compartir el juego por tus redes sociales" rel="popover" data-placement="bottom" data-trigger="hover"><i class="fas fa-share-alt"></i></button>
                        @auth
                            @if(Auth::user() && !Auth::user()->cm && !Auth::user()->ban && Auth::user()->email_verified_at != null)
                                <a class="btn btn-danger ml-2 pop-info"
                                data-content="Haz click aquí para reportar el perfil de este juego" rel="popover" data-placement="bottom" data-trigger="hover" id='reporteJuego'><i class="fas fa-exclamation-triangle mt-1"></i></a>
                            @endif
                        @endauth
                    </div>
                </div>
                <button class="navbar-toggler ml-1" type="button" data-toggle="collapse" data-target="#collapsingNavbar">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="navbar-collapse collapse justify-content-between align-items-center w-100" id="collapsingNavbar">
                    <ul class="navbar-nav ml-auto submenu-items">
                        <li class="nav-item"><a class="nav-link" id="general" href="">General</a></li>
                        <li class="nav-item"><a class="nav-link" id="comprar" href="">Comprar</a></li>
                        <li class="nav-item"><a class="nav-link" id="noticias" href="">Noticias</a></li>
                        <li class="nav-item"><a class="nav-link" id="analisis-div" href="">Análisis</a></li>
                    </ul>
                </div>
            </nav>

            <div class="row">
                <div class="col-md-9 px-3">
                    <div id="contenido">
                        <div class="general berber mt-4">
                            {!! $juego->contenido !!}
                        </div>
                        <div class="comprar px-4 mt-4 berber d-none">
                            @auth
                                <form action="{{ route('usuario.paypal.pagar') }}" method="post">
                                    @csrf
                                    @method('POST')
                                    <p>Stock: {{$juego->claves->count()}}</p>
                                    <p>El precio es de {{ $juego->precio }} €</p>
                                    @if($juego->claves->count() > 0)
                                    <input type="hidden" name="tipo" value="0" />
                                    <input type="hidden" name="precio" value="{{ $juego->precio }}">
                                    <input type="hidden" name="juegoId" value="{{ $juego->id }}">
                                    <button type="submit" class="btn btn-primary pop-info"
                                    data-content="Haz click aquí para comprar el juego. te redirigirá a la plataforma de pago PayPal" rel="popover" data-placement="bottom" data-trigger="hover"><i class="fab fa-paypal"></i></button>
                                    @else
                                    <p class="text-danger">No hay stock en estos momentos</p>
                                    @endif
                                </form>
                            @else
                                <div class="col-12 berber">Tienes que estar registrado para comprar</div>
                            @endauth
                        </div>
                        <div class="noticias px-4 d-none">
                            <div class="items row mt-4">
                                @if($juego->posts->where('ban', 0)->where('master_id', null)->count() > 0)
                                    @foreach ($juego->posts->where('ban', 0)->where('master_id', null)->sortByDesc('created_at') as $post)
                                        <div class="col-12 col-md-6 berber">
                                            <div class="pildoras mb-3">
                                                <span class="badge badge-pill badge-danger"><a class="text-white text-decoration-none" href="{{ route('usuario.juego.show', $post->juego->id) }}">{{$post->juego->nombre}}</a></span>
                                                <span class="badge badge-pill badge-light"><a class="text-dark text-decoration-none pop-info"
                                                    data-content="Haz click aquí para ver todos los juegos de este género" rel="popover" data-placement="bottom" data-trigger="hover" href="http://www.iestrassierra.net/alumnado/curso2021/DAWS/daws2021a1/indie4all/juegos/lista/{{ $post->juego->genero->id }}">{{$post->juego->genero->nombre}}</a></span>
                                                <span class="badge badge-pill badge-primary text-white">Noticia</span>
                                                <span class="float-right"><i class="far fa-comment-alt"></i> {{ $post->comentarios->count() }}</span>
                                            </div>
                                            <h4>{{ $post->titulo }}</h4>
                                            @php
                                                $resumen = explode('</p>', $post->contenido)
                                            @endphp
                                            <p>{!! $resumen[0] !!}</p>
                                            <form class="mb-3">
                                                <input type="hidden" name="id" value="{{ $post->id }}" />
                                                <a type="submit" class="btn btn-light btn-sm more text-dark font-weight-bold pop-info"
                                                data-content="Haz click aquí para ver la noticia, leer c omentarios y participar en ella" rel="popover" data-placement="bottom" data-trigger="hover">Leer más</a>
                                            </form>
                                            <div class="footer-noticias mt-3">
                                                <small>{{ $post->created_at }}</small>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="col-12 berber">No ha publicado ninguna noticia</div>
                                @endif
                            </div>
                            <div class="pager">
                                <div class="firstPage">&laquo;</div>
                                <div class="previousPage">&lsaquo;</div>
                                <div class="pageNumbers"></div>
                                <div class="nextPage">&rsaquo;</div>
                                <div class="lastPage">&raquo;</div>
                            </div>
                        </div>
                        <div class="analisis-div px-4 d-none">
                            <div class="items row mt-4">
                                @if ($analisis->count() != 0)
                                    @foreach ($analisis as $post)
                                        <div class="col-12 col-md-6 berber">
                                            <div class="pildoras mb-3">
                                                <span class="badge badge-pill badge-danger"><a class="text-white text-decoration-none" href="{{ route('usuario.juego.show', $post->juego->id) }}">{{$post->juego->nombre}}</a></span>
                                                <span class="badge badge-pill badge-light"><a class="text-dark text-decoration-none pop-info"
                                                    data-content="Haz click aquí para ver todos los juegos de este género" rel="popover" data-placement="bottom" data-trigger="hover" href="http://www.iestrassierra.net/alumnado/curso2021/DAWS/daws2021a1/indie4all/juegos/lista/{{ $post->juego->genero->id }}">{{$post->juego->genero->nombre}}</a></span>
                                                <span class="badge badge-pill badge-primary text-white">Análisis</span>
                                                <span class="float-right"><i class="far fa-comment-alt"></i> {{ $post->comentarios->count() }}</span>
                                            </div>
                                            <h4>{{ $post->titulo }}</h4>
                                            @php
                                                $resumen = explode('</p>', $post->contenido)
                                            @endphp
                                            <p>{!! $resumen[0] !!}</p>
                                            <form class="mb-3">
                                                <input type="hidden" name="id" value="{{ $post->id }}" />
                                                <a type="submit" class="btn btn-light btn-sm more text-dark font-weight-bold pop-info"
                                                data-content="Haz click aquí para ver el análisis, leer comentarios y participar en el" rel="popover" data-placement="bottom" data-trigger="hover">Leer más</a>
                                            </form>
                                            <div class="footer-noticias mt-3">
                                                <small class="text-uppercase font-weight-bold"><a class="text-white text-decoration-none pop-info"
                                                    data-content="Haz click aquí para ver el perfil de este Master" rel="popover" data-placement="bottom" data-trigger="hover" href="{{ route('usuario.master.show', $post->master->id) }}">{{ $post->master->nombre }}</a></small>
                                                <small>{{ $post->created_at }}</small>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="col-12 berber">No se ha publicado ningún análisis del juego</div>
                                @endif
                            </div>
                            <div class="pager">
                                <div class="firstPage">&laquo;</div>
                                <div class="previousPage">&lsaquo;</div>
                                <div class="pageNumbers"></div>
                                <div class="nextPage">&rsaquo;</div>
                                <div class="lastPage">&raquo;</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-3 mt-4">
                    <nav class="bg-transparent">
                        <div class="list-group shadow">
                            <ul class="list-group list-group-horizontal text-center text-uppercase font-weight-bold" style="font-size: .5rem;">
                                <li class="list-group-item list-buttons bg-dark text-light">Recomendados</a>
                            </ul>
                            <a href="http://www.iestrassierra.net/alumnado/curso2021/DAWS/daws2021a1/indie4all/juegos/lista" class="btn btn-danger rounded-0 pop-info"
                            data-content="Haz click aquí ver todos los juegos de la plataforma y poder filtrarlos a tu gusto" rel="popover" data-placement="bottom" data-trigger="hover">Ver todos</a>
                            @if ($recomendados->count() > 0)
                                @foreach ($recomendados->take('5') as $recomendado)
                                    <a href="{{route('usuario.juego.show', $recomendado->id)}}" class="list-group-item list-group-item-action flex-column align-items-start listado nuevos">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1"><b>{{$recomendado->nombre}}</b></h6>
                                            <small>{{$recomendado->fecha_lanzamiento}}</small>
                                        </div>
                                        <p class="mb-1">{{$recomendado->desarrolladora->nombre}}</p>
                                        <span class="btn btn-dark btn-sm float-right">{{$recomendado->precio}} €</span>
                                        <small class="badge badge-danger badge-pill mt-2">{{$recomendado->genero->nombre}}</small>
                                    </a>
                                @endforeach
                            @else
                                <div class="list-group-item">No hay recomendaciones</div>
                            @endif
                        </div>
                    </nav>
                </div>
            </div>
            <div class="more-div container bg-light p-5 shadow-lg rounded mt-4"></div>
        </div>
    </main>
@endsection

@section("scripts")
    <script>
        $(function() {
            let juego = {!! $juego !!};

            html = `<h2 class="float-left"><strong>Comparte si te gusta</strong></h2><br><hr>` +
            `<a class="btn btn-primary m-2" href="https://twitter.com/intent/tweet?lang=en&text=He%20descubierto%20el%20juego%20${juego.nombre}%20en%20indie4all.%20¡Échale%20un%20vistazo!?&url=http://www.iestrassierra.net/alumnado/curso2021/DAWS/daws2021a1/indie4all/juego/${juego.id}" target="_blank"><i class="fab fa-twitter fa-2x"></i></a>` +
            `<a class="btn btn-primary m-2" href="https://www.facebook.com/dialog/share?app_id=242615713953725&display=popup&href=http://www.iestrassierra.net/alumnado/curso2021/DAWS/daws2021a1/indie4all/juego/${juego.id}" target="_blank"><i class="fab fa-facebook-f fa-2x"></i></a>` +
            `<a class="btn btn-success m-2" href="https://api.whatsapp.com/send?text=He%20descubierto%20el%20juego%20${juego.nombre}%20en%20indie4all.%20¡Échale%20un%20vistazo!%20http://www.iestrassierra.net/alumnado/curso2021/DAWS/daws2021a1/indie4all/juego/${juego.id}" target="_blank"><i class="fab fa-whatsapp fa-2x"></i></a>` +
            `<hr><div class="input-group"><input type="text" id="input-link" class="form-control" value="http://www.iestrassierra.net/alumnado/curso2021/DAWS/daws2021a1/indie4all/juego/${juego.id}"><button class="btn btn-dark ml-2 copiar">Copiar</button></div>` +
            `<small class="mt-3 float-left">¡Gracias por compartir!</small>`;

            $(".compartir").on('click', {html: html}, compartir);

            $(".more").on('click', function () {
                let checkUser = false;
                let user = {
                    ban: "{{{ (Auth::user()) ? Auth::user()->ban : 1 }}}",
                    email_verified_at: "{{{ (Auth::user()) ? Auth::user()->email_verified_at : null }}}"
                };
                if(user.ban == 0 && user.email_verified_at != null) {
                    checkUser = true;
                }
                let url = '{{ route("usuario.post.show") }}';
                let id = $(this).prev().val();
                let config = '{{ asset("js/ckeditor/config.js") }}';
                more(url, id, config, checkUser);
            });

            $('#reporteJuego').on('click', function(){
                let id = {!! $juego->id !!};
                let url = '{{ route("usuario.reporte") }}';
                reporte(url, id, 'juego_id');
            });

            $('.select-nota').on('change', function() {
                let nota = $('.select-nota option:selected').val();
                $.ajax({
                    url: `http://www.iestrassierra.net/alumnado/curso2021/DAWS/daws2021a1/indie4all/juego/calificar`,
                    type: 'post',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    data: {
                        id: juego.id,
                        calificacion: nota,
                    },
                    success: function (resultado) {
                        $('.nota-usuarios span').text(resultado.calificacion);
                        notificacionEstado(resultado.estado, resultado.mensaje);
                    },
                    error: function () {
                        notificacionEstado('error', 'No se ha podido calificar el juego');
                    }
                });
            });
        });

    </script>
@endsection
