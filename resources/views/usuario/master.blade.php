@extends("layouts.usuario.base")

@section("content")
    <main class="p-3 pb-5">
        <div class="container bg-light p-3 shadow-lg rounded mt-4">
            <header class="header-imagen">
                @if ($master->imagen_portada != null)
                    <img class="img-fluid" src="{{ asset('/images/masters/' . $master->nombre . '/' . $master->imagen_portada) }}" alt="{{ $desarrolladora->nombre }}" style="filter: brightness(0.2)">
                @else
                    <img class="img-fluid" src="{{ asset('/images/masters/default-portada.png') }}" alt="{{ $master->nombre }}" style="filter: brightness(0.2)">
                @endif
                <div class="carousel-caption ">
                    <h1><strong>{{ $master->nombre }}</strong></h1>
                    <small>{{ $master->email }}</small>
                </div>
            </header>
            <nav id="submenu" class="navbar navbar-expand-md sticky-top navbar-light shadow bg-white mt-4 mt-md-0 mb-4 pt-3 pb-3 px-md-5">
                <div class="navbar-nav float-right-sm">
                    <div class="d-flex">
                        @auth
                            @if(Auth::user() && Auth::user()->master()->count() != 0 && Auth::user()->master->id == $master->id)
                                <a class="btn btn-primary ml-2" href="{{ route('master.perfil.index') }}"><i class="fas fa-user-edit"></i></a>
                            @else
                                @auth
                                    @if (Auth::user()->masters->where('id', $master->id)->count() == 0)
                                        <form method="post" action="{{ route('usuario.master.follow', $master->id) }}">
                                            @csrf
                                            <button type="submit" class="btn btn-light text-primary"><i class="far fa-check-circle"></i></button>
                                        </form>
                                    @else
                                        <form method="post" action="{{ route('usuario.master.unfollow', $master->id) }}">
                                            @csrf
                                            <button type="submit" class="btn btn-light text-danger"><i class="far fa-times-circle"></i></button>
                                        </form>
                                        @if (Auth::user()->masters->where('id', $master->id)->first()->pivot->notificacion == 0)
                                            <form method="post" action="{{ route('usuario.master.notificacion', [$master->id, 1]) }}">
                                                @csrf
                                                <button type="submit" class="btn btn-light text-primary"><i class="far fa-bell"></i></i></button>
                                            </form>
                                        @else
                                            <form method="post" action="{{ route('usuario.master.notificacion', [$master->id, 0]) }}">
                                                @csrf
                                                <button type="submit" class=" btn btn-light text-danger"><i class="far fa-bell-slash"></i></button>
                                            </form>
                                        @endif
                                    @endif
                                @endauth
                            @endif
                        @endauth
                        <button class="btn btn-warning compartir ml-2"><i class="fas fa-share-alt"></i></button>
                        @auth
                            @if(Auth::user() && !Auth::user()->master && !Auth::user()->ban && Auth::user()->email_verified_at != null)
                                <a class="btn btn-danger ml-2" id='reporteMaster'><i class="fas fa-exclamation-triangle mt-1"></i></a>
                            @endif
                        @endauth
                    </div>
                </div>
                <button class="navbar-toggler ml-1" type="button" data-toggle="collapse" data-target="#collapsingNavbar">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="navbar-collapse collapse justify-content-between align-items-center w-100" id="collapsingNavbar">
                    <ul class="navbar-nav ml-auto submenu-items">
                        <li class="nav-item"><a class="nav-link" id="estados" href="">Estados</a></li>
                        <li class="nav-item"><a class="nav-link" id="analisis-div" href="">Análisis</a></li>
                        <li class="nav-item"><a class="nav-link" id="notas" href="">Notas</a></li>
                    </ul>
                </div>
            </nav>
            <div class="row">
                <div class="col-12 col-md-9 px-3">
                    <div id="contenido">
                        <div class="estados">
                            <div class="items mt-4">
                                @if($master->posts->where('juego_id', null)->count() > 0)
                                    @foreach ($master->posts->where('juego_id', null)->sortByDesc('created_at') as $post)
                                        <div class="berber">
                                            <h4>{{ $post->titulo }}</h4>
                                            <p>{!! $post->contenido !!}</p>
                                            <div class="footer-estados mt-3">
                                                <small class="text-uppercase font-weight-bold"><a class="text-decoration-none" href="{{ route('usuario.master.show', $post->master->id) }}">{{ $post->master->nombre }}</a></small>
                                                <small>{{ $post->created_at }}</small>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="col-12 berber">No ha publicado ningún estado</div>
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
                                @if($master->posts->where('juego_id', '!=', null)->where('ban', 0)->count() > 0)
                                    @foreach ($master->posts->where('juego_id', '!=', null)->where('ban', 0)->sortByDesc('created_at') as $post)
                                        <div class="col-12 berber col-md-6">
                                            <div class="pildoras mb-3">
                                                <span class="badge badge-pill badge-danger"><a class="text-white font-weight-bold text-decoration-none" href="{{ route('usuario.juego.show', $post->juego->id) }}">{{$post->juego->nombre}}</a></span>
                                                <span class="badge badge-pill badge-light"><a class="text-dark font-weight-bold text-decoration-none" href="/juegos/lista/{{ $post->juego->genero->id }}">{{$post->juego->genero->nombre}}</a></span>
                                                <span class="badge badge-pill badge-primary text-white font-weight-bold">Análisis</span>
                                                <span class="float-right"><i class="far fa-comment-alt"></i> {{ $post->comentarios->count() }}</span>
                                            </div>
                                            <h4>{{ $post->titulo }}</h4>
                                            @php
                                                $resumen = explode('</p>', $post->contenido)
                                            @endphp
                                            <p>{!! $resumen[0] !!}</p>
                                            <form class="mb-3">
                                                <input type="hidden" name="id" value="{{ $post->id }}" />
                                                <a type="submit" class="btn btn-light btn-sm more text-dark font-weight-bold">Leer más</a>
                                            </form>
                                            <div class="footer-noticias">
                                                <small class="text-uppercase font-weight-bold"><a class="text-decoration-none" href="{{ route('usuario.master.show', $post->master->id) }}">{{ $post->master->nombre }}</a></small>
                                                <small>{{ $post->created_at }}</small>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="col-12 berber">No ha publicado ningún análisis</div>
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
                        <div class="notas d-none mt-4">
                            @if ($master->posts->where('juego_id', '!=', null)->where('ban', 0)->count() != 0)
                                @foreach ($master->posts->where('juego_id', '!=', null)->where('ban', 0)->sortByDesc('created_at') as $post)
                                    <div class="berber mb-2">
                                        <div class="berber-image d-none d-md-block">
                                            @if ($post->juego->imagen_caratula != null)
                                                <img class="img-fluid shadow" src="{{ asset('/images/desarrolladoras/' . $post->juego->desarrolladora->nombre . '/' . $post->juego->nombre . '/' . $post->juego->imagen_caratula) }}" alt="{{ $post->juego->nombre }}">
                                            @else
                                                <img class="img-fluid shadow" src="{{ asset('/images/desarrolladoras/default-logo-juego.png') }}" alt="{{ $post->juego->nombre }}">
                                            @endif
                                        </div>
                                        <div class="circle-lista float-right">{{$post->calificacion}}</div>
                                        <div class="berber-fullname"><a href="/juego/{{$post->juego->id}}">{{$post->juego->nombre}}</a></div>
                                        <div class="berber-dukkan">
                                            <input type="hidden" name="id" value="{{ $post->id }}" />
                                            <a type="submit" class="more">{{$post->titulo}}</a>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="col-12 berber">No ha publicado ningún análisis</div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-3 mt-4">
                    <div class="list-group shadow">
                        <ul class="list-group list-group-horizontal text-center text-uppercase font-weight-bold" style="font-size: .5rem;">
                            <li class="list-group-item w-100 bg-dark text-white">Recomendados</li>
                            <a href="/juegos/lista" class="list-group-item list-group-item-action bg-danger text-white">Todos</a>
                        </ul>
                        @if ($master->posts->where('juego_id', '!=', null)->where('destacado', 1)->count() != 0)
                            @foreach ($master->posts->where('juego_id', '!=', null)->where('destacado', 1) as $destacado)
                                <a href="{{route('usuario.juego.show', $destacado->juego->id)}}" class="list-group-item list-group-item-action flex-column align-items-start">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1"><b>{{$destacado->juego->nombre}}</b></h6>
                                        <small>{{$destacado->juego->fecha_lanzamiento}}</small>
                                    </div>
                                    <p class="mb-1">{{$destacado->juego->desarrolladora->nombre}}</p>
                                    <span class="btn btn-dark btn-sm float-right">{{$destacado->juego->precio}} €</span>
                                    <small class="badge badge-danger badge-pill mt-2">{{$destacado->juego->genero->nombre}}</small>
                                </a>
                            @endforeach
                        @else
                            <span class="list-group-item">No ha recomendado ningún juego</span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="more-div container bg-light p-5 shadow-lg rounded mt-4"></div>
        </div>
    </main>
@endsection
@section("scripts")
    <script>
        $(function() {
            let master = {!! json_encode($master) !!};

            let html = `<h2 class="float-left"><strong>Comparte si te gusta</strong></h2><br><hr>` +
            `<a class="btn btn-primary m-2" href="https://twitter.com/intent/tweet?lang=en&text=He%20descubierto%20el%20master%20${master.nombre}%20en%20indie4all.%20¡Échale%20un%20vistazo!?&url=http://127.0.0.1:8000/master/${master.id}" target="_blank"><i class="fab fa-twitter fa-2x"></i></a>` +
            `<a class="btn btn-primary m-2" href="https://www.facebook.com/dialog/share?app_id=242615713953725&display=popup&href=http://127.0.0.1:8000/master/${master.id}" target="_blank"><i class="fab fa-facebook-f fa-2x"></i></a>` +
            `<a class="btn btn-success m-2" href="https://api.whatsapp.com/send?text=He%20descubierto%20el%20master%20${master.nombre}%20en%20indie4all.%20¡Échale%20un%20vistazo!%20http://127.0.0.1:8000/master/${master.id}" target="_blank"><i class="fab fa-whatsapp fa-2x"></i></a>` +
            `<hr><div class="input-group"><input type="text" id="input-link" class="form-control" value="http://127.0.0.1:8000/master/${master.id}"><button class="btn btn-dark ml-2 copiar">Copiar</button></div>` +
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

            $('#reporteMaster').on('click', function(){
                let id = {!! $master->id !!};
                let url = '{{ route("usuario.reporte") }}';
                reporte(url, id, 'master_id');
            });
        });

    </script>
@endsection
