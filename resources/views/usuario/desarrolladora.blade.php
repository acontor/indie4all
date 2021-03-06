@extends("layouts.usuario.base")


@section("content")
    <main class="p-3 pb-5">
        <div class="container bg-light p-3 shadow-lg rounded mt-4">
            <header class="header-imagen">
                @if ($desarrolladora->imagen_portada != null)
                    <img class="img-fluid shadow" src="{{ asset('/images/desarrolladoras/' . $desarrolladora->nombre . '/' . $desarrolladora->imagen_portada) }}" alt="{{ $desarrolladora->nombre }}" style="filter: brightness(0.2)">
                @else
                    <img class="img-fluid shadow" src="{{ asset('/images/desarrolladoras/default-portada-desarrolladora.png') }}" alt="{{ $desarrolladora->nombre }}" style="filter: brightness(0.2)">
                @endif
                <div class="carousel-caption ">
                    <h1><strong>{{ $desarrolladora->nombre }}</strong></h1>
                    <small>{{ $desarrolladora->direccion }}</small>
                    <br>
                    <small>{{ $desarrolladora->email }}</small>
                    <br>
                    <small>{{ $desarrolladora->telefono }}</small>
                </div>
            </header>
            <nav id="submenu" class="navbar navbar-expand-md sticky-top navbar-light shadow bg-white mt-4 mt-md-0 mb-4 pt-3 pb-3 px-md-5">
                <div class="navbar-nav float-right-sm">
                    <div class="d-flex">
                        @auth
                            @if(Auth::user() && Auth::user()->cm()->count() != 0 && Auth::user()->cm->desarrolladora_id == $desarrolladora->id)
                                <a class="btn btn-primary ml-2 pop-info"
                                data-content="Haz click aquí para editar el perfil de la desarrolladora" rel="popover" data-placement="bottom" data-trigger="hover" href="{{ route('cm.desarrolladora.index') }}"><i class="fas fa-user-edit"></i></a>
                            @else
                                @auth
                                    @if (Auth::user()->desarrolladoras->where('id', $desarrolladora->id)->count() == 0)
                                        <form action="{{ route('usuario.desarrolladora.follow', $desarrolladora->id) }}" method="post">
                                            @csrf
                                            <button type="submit" class="btn btn-light text-primary pop-info"
                                            data-content="Haz click aquí para seguir a la desarrolladora" rel="popover" data-placement="bottom" data-trigger="hover"><i class="far fa-check-circle"></i></button>
                                        </form>
                                    @else
                                        <form action="{{ route('usuario.desarrolladora.unfollow', $desarrolladora->id) }}"
                                            method="post">
                                            @csrf
                                            <button type="submit" class="btn btn-light text-danger pop-info"
                                            data-content="Haz click aquí para dejar de seguir a la desarrolladora" rel="popover" data-placement="bottom" data-trigger="hover"><i class="far fa-times-circle"></i></button>
                                        </form>
                                        @if (Auth::user()->desarrolladoras->where('id', $desarrolladora->id)->first()->pivot->notificacion == 0)
                                            <form action="{{ route('usuario.desarrolladora.notificacion', [$desarrolladora->id, 1]) }}"
                                                method="post">
                                                @csrf
                                                <button type="submit" class="btn btn-light text-primary pop-info"
                                                data-content="Haz click aquí para activar las notificaciones de la desarrolladora" rel="popover" data-placement="bottom" data-trigger="hover"><i class="far fa-bell"></i></button>
                                            </form>
                                        @else
                                            <form action="{{ route('usuario.desarrolladora.notificacion', [$desarrolladora->id, 0]) }}"
                                                method="post">
                                                @csrf
                                                <button type="submit" class="btn btn-light text-danger pop-info"
                                                data-content="Haz click aquí para desactivar las notificaciones de la desarrolladora" rel="popover" data-placement="bottom" data-trigger="hover"><i class="far fa-bell-slash"></i></button>
                                            </form>
                                        @endif
                                    @endif
                                @endauth
                            @endif
                        @endauth
                        <button class="btn btn-warning compartir ml-2 pop-info"
                        data-content="Haz click aquí para compratir el perfil por tus redes sociales" rel="popover" data-placement="bottom" data-trigger="hover"><i class="fas fa-share-alt"></i></button>
                        <a class="btn btn-dark web ml-2 pop-info"
                        data-content="Haz click aquí para ver la web de la desarrolladora, se le redirigirá a su página web externa a la plataforma" rel="popover" data-placement="bottom" data-trigger="hover" href="{{ $desarrolladora->url }}" target="_blank"><i class="fas fa-external-link-alt"></i></a>
                        @auth
                            @if(Auth::user() && !Auth::user()->cm && !Auth::user()->ban && Auth::user()->email_verified_at != null)
                                <a class="btn btn-danger ml-2 pop-info"
                                data-content="Haz click aquí para reportar el perfil de la desarrolladora" rel="popover" data-placement="bottom" data-trigger="hover" id='reporteDesarrolladora'><i class="fas fa-exclamation-triangle mt-1"></i></a>
                            @endif
                        @endauth
                    </div>
                </div>
                <button class="navbar-toggler ml-1" type="button" data-toggle="collapse" data-target="#collapsingNavbar">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="navbar-collapse collapse justify-content-between align-items-center w-100" id="collapsingNavbar">
                    <hr class="mt-4 mb-3">
                    <ul class="navbar-nav ml-auto submenu-items">
                        <li class="nav-item"><a class="nav-link" id="general" href="">General</a></li>
                        <li class="nav-item"><a class="nav-link" id="noticias" href="">Noticias</a></li>
                        <li class="nav-item"><a class="nav-link" id="sorteos" href="">Sorteos</a></li>
                        <li class="nav-item"><a class="nav-link" id="encuestas" href="">Encuestas</a></li>
                    </ul>
                </div>
            </nav>
            <div class="row">
                <div class="col-md-9 px-3">
                    <div id="contenido">
                        <div class="general berber mt-4">
                            {!! $desarrolladora->contenido !!}
                        </div>
                        <div class="noticias px-4 d-none">
                            <div class="items row mt-4">
                                @if($desarrolladora->posts->where('ban', 0)->count() > 0)
                                    @foreach ($desarrolladora->posts->where('ban', 0)->sortByDesc('created_at') as $post)
                                        <div class="col-12 berber col-md-6">
                                            <div class="pildoras mb-3">
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
                                                data-content="Haz click aquí para ver la noticia, leer comentarios y participar en ella" rel="popover" data-placement="bottom" data-trigger="hover">Leer más</a>
                                            </form>
                                            <div class="footer-noticias ">
                                                <small class="text-uppercase font-weight-bold"><a class="text-white text-decoration-none" href="{{ route('usuario.desarrolladora.show', $post->desarrolladora->id) }}">{{ $post->desarrolladora->nombre }}</a></small>
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
                        <div class="sorteos px-3 d-none">
                            <div class="items row mt-4">
                                @auth
                                    @if ($desarrolladora->sorteos->count() > 0)
                                        @foreach ($desarrolladora->sorteos as $sorteo)
                                            <div class="col-12 col-md-6 berber">
                                                <h4>{{ $sorteo->titulo }}</h4>
                                                <p>{{ $sorteo->descripcion }}</p>
                                                @isset($sorteo->user_id)
                                                    El sorteo ha finalizado.
                                                    Ganador: {{$sorteo->ganador->username}}
                                                @else
                                                    <input type="hidden" name="id" value="{{ $sorteo->id }}">
                                                    @if(Auth::user()->cm && Auth::user()->cm->where('desarrolladora_id', $desarrolladora->id))
                                                        Eres CM de ésta desarrolladora
                                                    @elseif(Auth::user()->ban)
                                                        Tu cuenta está baneada
                                                    @elseif(Auth::user()->email_verified_at == null)
                                                        Tu cuenta no está verificada
                                                    @elseif(Auth::user()->sorteos->where('id', $sorteo->id)->count() != 0)
                                                        Ya has participado
                                                    @else
                                                        <div class="participar-sorteo-div">
                                                            <button type="submit" class="participar-sorteo btn btn-success pop-info"
                                                            data-content="Haz click aquí para participar en el sorteo" rel="popover" data-placement="bottom" data-trigger="hover">Participar</button>
                                                        </div>
                                                    @endif
                                                @endisset
                                                <div class="sorteo-footer mt-3">
                                                    <small class="mb-4">Termina el {{ $sorteo->fecha_fin }}</small>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="col-12 berber">Aún no se han publicado sorteos.</div>
                                    @endif
                                @else
                                    <div class="col-12 berber">Tienes que registrarte para participar en los sorteos.</div>
                                @endauth
                            </div>
                        </div>
                        <div class="encuestas px-3 d-none">
                            <div class="items row mt-4">
                                @auth
                                    @if ($desarrolladora->encuestas->count() > 0)
                                        @foreach ($desarrolladora->encuestas as $encuesta)
                                            <div class="col-12 col-md-6 berber">
                                                <h4 class="mb-4">{{ $encuesta->pregunta }}</h4>
                                                @if (Auth::user()->opciones->where('encuesta_id', $encuesta->id)->count() > 0 || Auth::user()->cm && Auth::user()->cm->where('desarrolladora_id', $desarrolladora->id))
                                                    @php
                                                        $total = 0
                                                    @endphp
                                                    @foreach ($encuesta->opciones as $opcion)
                                                        @php
                                                            $total += $opcion->participantes->count()
                                                        @endphp
                                                    @endforeach
                                                    @if($total == 0)
                                                        Aún no hay participaciones
                                                    @else
                                                        <div class="row">
                                                            @foreach ($encuesta->opciones as $opcion)
                                                                <div class="col-6-col-md-6 d-flex justify-content-center text-center">
                                                                    @php
                                                                        $porcentaje = ($opcion->participantes->count() / $total) * 100;
                                                                    @endphp
                                                                    @if($opcion->participantes->where('id', Auth::id())->count() > 0)
                                                                        <div class="row">
                                                                            <div class="col-12 d-flex justify-content-center text-center">
                                                                                <p class="font-weight-bold">{{$opcion->descripcion}}</p>
                                                                            </div>
                                                                            <div class="col-12">
                                                                                <div class="progress progress-bar-vertical">
                                                                                    <div class="progress-bar bg-danger" role="progressbar" aria-valuenow="{{ $porcentaje }}" aria-valuemin="0" aria-valuemax="100" style="height: {{ $porcentaje }}%;"></div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @else
                                                                        <div class="row">
                                                                            <div class="col-12 d-flex justify-content-center text-center">
                                                                                <p class="font-weight-bold">{{$opcion->descripcion}}</p>
                                                                            </div>
                                                                            <div class="col-12">
                                                                                <div class="progress progress-bar-vertical">
                                                                                    <div class="progress-bar bg-primary" role="progressbar" aria-valuenow="{{ $porcentaje }}" aria-valuemin="0" aria-valuemax="100" style="height: {{ $porcentaje }}%;"></div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            @endforeach
                                                            <div class="encuesta-info mt-3 ml-3">
                                                                <span class="badge badge-danger">Opción escogida</span>
                                                                <span class="badge badge-primary">Otras opciones</span>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @else
                                                    <div class="opciones">
                                                        @foreach ($encuesta->opciones as $opcion)
                                                            <label class="radio-button mod-label-below">
                                                                <input type="radio" name="respuesta{{ $encuesta->id }}" id="respuesta" value="{{ $opcion->id }}" style="appearance: none;" />
                                                                <div class="btn btn-light font-weight-bold pop-info"
                                                                data-content="Haz click aquí para escoger esta opcion" rel="popover" data-placement="bottom" data-trigger="hover">{{ $opcion->descripcion }}</div>
                                                            </label>
                                                        @endforeach
                                                    </div>
                                                    <input type="hidden" name="id" value="{{ $encuesta->id }}">
                                                    @if(Auth::user()->ban)
                                                        Tu cuenta está baneada
                                                    @elseif(Auth::user()->email_verified_at == null)
                                                        Tu cuenta no está verificada
                                                    @else
                                                        <div class="participar-encuesta-div mt-4">
                                                            <button type="submit" class="participar-encuesta btn btn-success pop-info"
                                                            data-content="Haz click aquí para participar en la encuesta" rel="popover" data-placement="bottom" data-trigger="hover">Participar</button>
                                                        </div>
                                                    @endif
                                                @endif
                                                <div class="encuesta-footer mt-3">
                                                    <small class="mb-4">Termina el {{ $encuesta->fecha_fin }}</small>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="col-12 berber">Aún no se han publicado encuestas.</div>
                                    @endif
                                @else
                                    <div class="col-12 berber">Tienes que registrarte para participar en las encuestas.</div>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mt-4 pr-3 pr-md-4">
                    @if($desarrolladora->juegos()->doesnthave('campania')->where('ban', 0)->count() > 0)
                        <h4>Juegos</h4>
                        <hr>
                        <div class="owl-carousel owl-theme juegos">
                            @foreach ($desarrolladora->juegos->where('ban', 0) as $juego)
                                @empty($juego->campania)
                                    <div class="item">
                                        <a href="{{ route('usuario.juego.show', $juego->id) }}">
                                            @if ($juego->imagen_caratula != null)
                                                <img class="img-fluid shadow" src="{{ asset('/images/desarrolladoras/' . $desarrolladora->nombre . '/' . $juego->nombre . '/' . $juego->imagen_caratula) }}" alt="{{ $juego->nombre }}">
                                            @else
                                                <img class="img-fluid shadow" src="{{ asset('/images/desarrolladoras/default-logo-juego.png') }}" alt="{{ $juego->nombre }}">
                                            @endif
                                            <div class="carousel-caption d-none">
                                                <h6>{{ $juego->nombre }}</h6>
                                                <small>
                                                    <span class="badge badge-danger">{{ $juego->genero->nombre }}</span>
                                                    <span class="d-block">{{ $juego->precio }} €</span>
                                                </small>
                                            </div>
                                        </a>
                                    </div>
                                @endempty
                            @endforeach
                        </div>
                    @endif
                    @if($campanias->count() > 0)
                        <h4 class="mt-5">Campañas</h4>
                        <hr>
                        <div class="owl-carousel owl-theme campanias">
                            @foreach ($campanias as $campania)
                                <div class="item">
                                    <a href="{{ route('usuario.campania.show', $campania->id) }}">
                                        @if ($campania->juego->imagen_caratula != null)
                                            <img class="img-fluid shadow" src="{{ asset('/images/desarrolladoras/' . $desarrolladora->nombre . '/' . $campania->juego->nombre . '/' . $campania->juego->imagen_caratula) }}" alt="{{ $campania->juego->nombre }}">
                                        @else
                                            <img class="img-fluid shadow" src="{{ asset('/images/desarrolladoras/default-logo-juego.png') }}" alt="{{ $campania->juego->nombre }}">
                                        @endif
                                        <div class="carousel-caption d-none">
                                            <h6>{{ $campania->juego->nombre }}</h6>
                                            <small>
                                                <span class="badge badge-danger">{{ $campania->juego->genero->nombre }}</span>
                                            </small>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
            <div class="more-div container bg-light p-5 shadow-lg rounded mt-4"></div>
        </div>
    </main>
@endsection
@section("scripts")
    <script>
        $(function() {
            $('.general p img').addClass('w-100');

            let desarrolladora = {!! json_encode($desarrolladora) !!};

            html = `<h2 class="float-left"><strong>Comparte si te gusta</strong></h2><br><hr>` +
            `<a class="btn btn-primary m-2" href="https://twitter.com/intent/tweet?lang=en&text=He%20descubierto%20la%20desarrolladora%20${desarrolladora.nombre}%20en%20indie4all.%20¡Échale%20un%20vistazo!?&url=http://www.iestrassierra.net/alumnado/curso2021/DAWS/daws2021a1/indie4all/desarrolladora/${desarrolladora.id}" target="_blank"><i class="fab fa-twitter fa-2x"></i></a>` +
            `<a class="btn btn-primary m-2" href="https://www.facebook.com/dialog/share?app_id=242615713953725&display=popup&href=http://www.iestrassierra.net/alumnado/curso2021/DAWS/daws2021a1/indie4all/desarrolladora/${desarrolladora.id}" target="_blank"><i class="fab fa-facebook-f fa-2x"></i></a>` +
            `<a class="btn btn-success m-2" href="https://api.whatsapp.com/send?text=He%20descubierto%20la%desarrolladora%20${desarrolladora.nombre}%20en%20indie4all.%20¡Échale%20un%20vistazo!%20http://www.iestrassierra.net/alumnado/curso2021/DAWS/daws2021a1/indie4all/desarrolladora/${desarrolladora.id}" target="_blank"><i class="fab fa-whatsapp fa-2x"></i></a>` +
            `<hr><div class="input-group"><input type="text" id="input-link" class="form-control" value="http://www.iestrassierra.net/alumnado/curso2021/DAWS/daws2021a1/indie4all/desarrolladora/${desarrolladora.id}"><button class="btn btn-dark ml-2 copiar">Copiar</button></div>` +
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

            $('#reporteDesarrolladora').on('click', function(){
                let id = {!! $desarrolladora->id !!};
                let url = '{{ route("usuario.reporte") }}';
                reporte(url, id, 'desarrolladora_id');
            });

            crearOwl($('.owl-carousel.juegos'), false, 2, 2, 2);

            crearOwl($('.owl-carousel.campanias'), false, 2, 2, 2);

            $('.mod-label-below').on('click', function() {
                $('.mod-label-below').children().removeClass('btn-primary').addClass('btn-light');
                $(this).children().removeClass('btn-light').addClass('btn-primary');
            });

            $(".participar-encuesta").on('click', function (e) {
                e.preventDefault();
                let encuesta = $(this).parent().prev().val();
                let opcion = $(`input[name=respuesta${encuesta}]:checked`).val();
                Swal.fire({
                    title: 'Confirmar Participación',
                    html: '<div id="recaptcha" class="mb-3"></div>',
                    didOpen: function () {
                        grecaptcha.render('recaptcha', {
                            'sitekey': '6Lc2ufwZAAAAAFtjN9fasxuJc0OEf670ruHSTEfP'
                        });
                    },
                    preConfirm: function () {
                        if (grecaptcha.getResponse().length === 0) {
                            Swal.showValidationMessage(`Por favor, verifica que no eres un robot`)
                        } else {
                            $.ajax({
                                url: '{{ route("usuario.desarrolladora.encuesta") }}',
                                type: 'post',
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                data: {
                                    opcion: opcion,
                                },
                                success: function () {
                                    $(".participar-encuesta-div").html("Gracias por participar");
                                    notificacionEstado('success', 'Participación registrada')
                                },
                                error: function () {
                                    notificacionEstado('error', 'No ha podido participar')
                                }
                            });
                        }
                    }
                });
                $('.opciones').remove();
            });

            $(".participar-sorteo").on('click', function (e) {
                e.preventDefault();
                let id = $(this).parent().prev().val();
                Swal.fire({
                    title: 'Confirmar Participación',
                    html: '<div id="recaptcha" class="mb-3"></div>',
                    didOpen: function () {
                        grecaptcha.render('recaptcha', {
                            'sitekey': '6Lc2ufwZAAAAAFtjN9fasxuJc0OEf670ruHSTEfP'
                        });
                    },
                    preConfirm: function () {
                        if (grecaptcha.getResponse().length === 0) {
                            Swal.showValidationMessage(`Por favor, verifica que no eres un robot`)
                        } else {
                            $.ajax({
                                url: '{{ route("usuario.desarrolladora.sorteo") }}',
                                type: 'post',
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                data: {
                                    id: id,
                                },
                                success: function () {
                                    $(".participar-sorteo-div").html("Participación registrada");
                                    notificacionEstado('success', 'Participación registrada')
                                },
                                error: function () {
                                    notificacionEstado('error', 'No ha podido participar')
                                }
                            });
                        }
                    }
                })
            });
        });

    </script>
@endsection
