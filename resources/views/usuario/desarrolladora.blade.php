@extends("layouts.usuario.base")


@section("content")

<style>
    .container {
        position: relative;
    }

    .hola {
        width: 100%;
        height: 100% !important;
        background-color: white !important;
        position: absolute;
        top: 0%;
        margin: 0 !important;
        z-index: 1030;
        left: -10000px;
        transition: left .5s;
        overflow: auto;
    }

    .items > div {
        border: 2px solid rgb(0, 0, 0, 0.1);
        padding: 40px;
    }

    .general > div, .sorteos > div, .encuestas > div {
        border: 2px solid rgb(0, 0, 0, 0.1);
    }

    /* MEDIA MOBILE*/
    small {
        font-size: 10px;
    }

</style>


    <main class="p-3 pb-5">
        <div class="container bg-light p-3 shadow-lg rounded mt-4">
            <header>
                @if (!$desarrolladora->imagen_portada)
                    <img class="img-fluid h-auto" src="{{ url('/images/default.png') }}" style="filter: brightness(0.2)">
                @else
                    <img class="img-fluid h-auto" src="{{ url('/images/desarrolladoras/portadas/' . $desarrolladora->imagen_portada) }}">
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



            <nav id="submenu" class="navbar navbar-expand-md sticky-top navbar-light shadow bg-white mt-4 mb-4 pt-3 pb-3 px-md-5">
                <div class="navbar-nav float-right-sm">
                    <div class="d-flex">
                        @auth
                            @if(Auth::user() && Auth::user()->cm()->count() != 0 && Auth::user()->cm->desarrolladora_id == $desarrolladora->id)
                                <a class="btn btn-primary ml-2" href="{{ route('cm.desarrolladora.index') }}"><i class="fas fa-user-edit"></i></a>
                            @else
                                @auth
                                    @if (Auth::user()->desarrolladoras->where('id', $desarrolladora->id)->count() == 0)
                                        <form action="{{ route('usuario.desarrolladora.follow', $desarrolladora->id) }}" method="post">
                                            @csrf
                                            <button type="submit" class="btn text-primary"><i class="far fa-check-circle"></i></button>
                                        </form>
                                    @else
                                        <form action="{{ route('usuario.desarrolladora.unfollow', $desarrolladora->id) }}"
                                            method="post">
                                            @csrf
                                            <button type="submit" class="btn text-danger"><i class="far fa-times-circle"></i></button>
                                        </form>
                                        @if (Auth::user()->desarrolladoras->where('id', $desarrolladora->id)->first()->pivot->notificacion == 0)
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
                                    @endif
                                @endauth
                            @endif
                        @endauth
                        <button class="btn btn-warning compartir ml-2"><i class="fas fa-share-alt"></i></button>
                        <a class="btn btn-dark web ml-2" href="{{ $desarrolladora->url }}" target="_blank"><i class="fas fa-external-link-alt"></i></a>
                        @auth
                            @if(Auth::user() && !Auth::user()->cm)
                                <a class="btn btn-danger ml-2" id='reporteDesarrolladora'><i class="fas fa-exclamation-triangle mt-1"></i></a>
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
                <div class="col-md-9 mt-4">
                    <div id="contenido">
                        <div class="general p-1">
                            <div class="shadow p-4 p-md-5">
                                {!! $desarrolladora->contenido !!}
                            </div>
                        </div>
                        <div class="noticias d-none">
                            @if ($desarrolladora->posts->count() != 0)
                                <div class="items">
                                    @foreach ($desarrolladora->posts as $post)
                                        <div class="shadow mb-4">
                                            <h4>{{ $post->titulo }}</h4>
                                            <p>{!! substr($post->contenido, 0, 300) !!}...</p>
                                            <small>Comentarios: {{ $post->mensajes->count() }}</small>
                                            <br>
                                            <input type="hidden" name="id" value="{{ $post->id }}" />
                                            <a type="submit" class="more">Leer más</a>
                                            </div>
                                    @endforeach
                                </div>
                                <div class="pager">
                                    <div class="firstPage">&laquo;</div>
                                    <div class="previousPage">&lsaquo;</div>
                                    <div class="pageNumbers"></div>
                                    <div class="nextPage">&rsaquo;</div>
                                    <div class="lastPage">&raquo;</div>
                                </div>
                            @else
                                La desarrolladora aún no ha publicado ningún post.
                            @endif
                        </div>
                        <div class="sorteos d-none">
                            <div class="shadow p-4 p-md-5">
                                <h3>Sorteos</h3>
                                <div class="row">
                                    @auth
                                        @foreach ($desarrolladora->sorteos as $sorteo)
                                            <div class="col-12 col-md-6">
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
                                                            <button type="submit" class="participar-sorteo btn btn-success">Participar</button>
                                                        </div>
                                                    @endif
                                                @endisset
                                                <p class="mt-3">{{ $sorteo->fecha_fin }}</p>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="col-12">Tienes que registrarte para participar en los sorteos.</div>
                                    @endauth
                                </div>
                            </div>
                        </div>
                        <div class="encuestas d-none">
                            <div class="shadow p-4 p-md-5">
                                <h3>Encuestas</h3>
                                    <div class="row">
                                        @auth
                                            @foreach ($desarrolladora->encuestas as $encuesta)
                                                <div class="col-12 col-md-6">
                                                    <h4>{{ $encuesta->pregunta }}</h4>
                                                    @if (Auth::user()->opciones->where('encuesta_id', $encuesta->id)->count() > 0 || Auth::user()->cm && Auth::user()->cm->where('desarrolladora_id', $desarrolladora->id))
                                                        @php
                                                            $total = 0
                                                        @endphp
                                                        @foreach ($encuesta->opciones as $opcion)
                                                            @php
                                                                $total+=$opcion->participantes->count()
                                                            @endphp
                                                        @endforeach
                                                        @if($total == 0)
                                                            Aún no ha participaciones
                                                        @else
                                                            @foreach ($encuesta->opciones as $opcion)

                                                                @if($opcion->participantes->where('id',Auth::id())->count() > 0)
                                                                    <span class="bg-primary">{{$opcion->descripcion}}</span>
                                                                @else
                                                                    {{$opcion->descripcion}}
                                                                @endif
                                                                {{($opcion->participantes->count() / $total) * 100}} %
                                                                <br>
                                                            @endforeach
                                                        @endif
                                                    @else
                                                        <div class="opciones">
                                                            @foreach ($encuesta->opciones as $opcion)
                                                                <label for="respuesta">{{ $opcion->descripcion }}</label>
                                                                <input type="radio" name="respuesta{{ $encuesta->id }}" id="respuesta" value="{{ $opcion->id }}">
                                                            @endforeach
                                                        </div>
                                                        <input type="hidden" name="id" value="{{ $encuesta->id }}">
                                                        @if(Auth::user()->ban)
                                                            Tu cuenta está baneada
                                                        @elseif(Auth::user()->email_verified_at == null)
                                                            Tu cuenta no está verificada
                                                        @else
                                                            <div class="participar-encuesta-div">
                                                                <button type="submit" class="participar-encuesta btn btn-success">Participar</button>
                                                            </div>
                                                        @endif
                                                    @endif
                                                    <p>{{ $encuesta->fecha_fin }}</p>
                                                </div>
                                            @endforeach
                                    @else
                                        <div class="col-12">Tienes que registrarte para participar en las encuestas.</div>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mt-4 pr-3 pr-md-4">
                    <h4>Juegos</h4>
                    <hr>
                    <div class="owl-carousel 1">
                        @foreach ($desarrolladora->juegos as $juego)
                            @empty($juego->campania)
                                <div class="item">
                                    <a href="{{ route('usuario.juego.show', $juego->id) }}">
                                        <img src="https://spdc.ulpgc.es/media/ulpgc/images/thumbs/edition-44827-200x256.jpg"
                                            alt="{{ $juego->nombre }}">
                                        <div class="carousel-caption" style="display: none;">
                                            <h6><strong>{{ $juego->nombre }}</strong></h6>
                                            <small>{{ $juego->desarrolladora->nombre }}</small>
                                            <hr>
                                            <small class="float-left text-left">{{ $juego->genero->nombre }}
                                                <br>
                                                {{ $juego->precio }} €
                                                <br>
                                                {{ $juego->fecha_lanzamiento }}
                                            </small>
                                        </div>
                                    </a>
                                </div>
                            @endempty
                        @endforeach
                    </div>
                    @if($desarrolladora->juegos()->has('campania')->count() > 0)
                        <h4 class="mt-5">Campañas</h4>
                        <hr>
                        <div class="owl-carousel 2">
                            @foreach ($desarrolladora->juegos()->has('campania')->get() as $juego)
                                <div class="item">
                                    <a href="{{ route('usuario.campania.show', $juego->campania->id) }}">
                                        <img src="https://spdc.ulpgc.es/media/ulpgc/images/thumbs/edition-44827-200x256.jpg"
                                            alt="{{ $juego->nombre }}">
                                        <div class="carousel-caption" style="display: none;">
                                            <h6><strong>{{ $juego->nombre }}</strong></h6>
                                            <small>{{ $juego->desarrolladora->nombre }}</small>
                                            <hr>
                                            <small class="float-left text-left">{{ $juego->genero->nombre }}
                                                <br>
                                                {{ $juego->precio }} €
                                                <br>
                                                {{ $juego->fecha_lanzamiento }}
                                            </small>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>



            <div class="hola container bg-light p-3 shadow-lg rounded mt-4">Hola</div>


        </div>
    </main>




@endsection
@section("scripts")
    <script src="{{ asset('js/paginga/paginga.jquery.min.js') }}"></script>
    <script src="https://www.google.com/recaptcha/api.js"></script>
    <script src="{{ asset('js/usuario.js') }}"></script>
    <script>
        $(function() {
            $('img').addClass('img-fluid');

            let desarrolladora = {!! json_encode($desarrolladora) !!};

            html = `<h2 class="float-left"><strong>Comparte si te gusta</strong></h2><br><hr>` +
            `<a class="btn btn-primary m-2" href="https://twitter.com/intent/tweet?lang=en&text=He%20descubierto%20la%20desarrolladora%20${desarrolladora.nombre}%20en%20indie4all.%20¡Échale%20un%20vistazo!?&url=http://127.0.0.1:8000/desarrolladora/${desarrolladora.id}" target="_blank"><i class="fab fa-twitter fa-2x"></i></a>` +
            `<a class="btn btn-primary m-2" href="https://www.facebook.com/dialog/share?app_id=242615713953725&display=popup&href=http://127.0.0.1:8000/desarrolladora/${desarrolladora.id}" target="_blank"><i class="fab fa-facebook-f fa-2x"></i></a>` +
            `<a class="btn btn-success m-2" href="https://api.whatsapp.com/send?text=He%20descubierto%20la%desarrolladora%20${desarrolladora.nombre}%20en%20indie4all.%20¡Échale%20un%20vistazo!%20http://127.0.0.1:8000/desarrolladora/${desarrolladora.id}" target="_blank"><i class="fab fa-whatsapp fa-2x"></i></a>` +
            `<hr><div class="input-group"><input type="text" id="input-link" class="form-control" value="http://127.0.0.1:8000/desarrolladora/${desarrolladora.id}"><button class="btn btn-dark ml-2 copiar">Copiar</button></div>` +
            `<small class="mt-3 float-left">¡Gracias por compartir!</small>`;

            $(".compartir").on('click', {html: html}, compartir);

            $(".more").on('click', function () {
                let checkUser = false;
                let user = "{{{ (Auth::user()) ? Auth::user() : null }}}";
                if(user != '' && user.ban == 0 && user.email_verified_at != null) {
                    checkUser = true;
                }
                let url = '{{ route("usuario.post.show") }}';
                let id = $(this).prev().val();
                let config = '{{ asset("js/ckeditor/config.js") }}';
                more(url, id, config, checkUser);
            });

            $('#reporteDesarrolladora').click(function(){
                let id = {!! $desarrolladora->id !!};
                let url = '{{ route("usuario.reporte") }}';
                reporte(url, id, 'desarrolladora_id');
            });












            var owl = $('.1');

            owl.owlCarousel({
                loop: true,
                margin: 10,
                items: 1.5,
            });

            owl.on('mousewheel', '.owl-stage', function(e) {
                if (e.originalEvent.wheelDelta > 0) {
                    owl.trigger('prev.owl');
                } else {
                    owl.trigger('next.owl');
                }
                e.preventDefault();
            });

            var owl2 = $('.2');

            let items = 1;

            if($('.2').children('div').length > 1) {
                let items = 1.5;
            }

            owl2.owlCarousel({
                loop: true,
                margin: 10,
                items: items
            });

            owl2.on('mousewheel', '.owl-stage', function(e) {
                if (e.originalEvent.wheelDelta > 0) {
                    owl2.trigger('prev.owl');
                } else {
                    owl2.trigger('next.owl');
                }
                e.preventDefault();
            });

        });

    </script>
@endsection
