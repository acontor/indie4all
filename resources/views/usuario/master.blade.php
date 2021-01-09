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
                @if (!$master->imagen_portada)
                    <img class="img-fluid h-auto" src="{{ url('/images/default.png') }}" style="filter: brightness(0.2)">
                @else
                    <img class="img-fluid h-auto" src="{{ url('/images/masters/' . $master->nombre . '/' . $master->imagen_portada) }}">
                @endif
                <div class="carousel-caption ">
                    <h1><strong>{{ $master->nombre }}</strong></h1>
                    <small>{{ $master->email }}</small>
                </div>
            </header>



            <nav id="submenu" class="navbar navbar-expand-md sticky-top navbar-light shadow bg-white mt-4 mb-4 pt-3 pb-3">
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
                                            <button type="submit" class="btn text-primary"><i class="far fa-check-circle"></i></button>
                                        </form>
                                    @else
                                        <form method="post" action="{{ route('usuario.master.unfollow', $master->id) }}">
                                            @csrf
                                            <button type="submit" class="btn text-danger"><i class="far fa-times-circle"></i></button>
                                        </form>
                                        @if (Auth::user()->masters->where('id', $master->id)->first()->pivot->notificacion == 0)
                                            <form method="post" action="{{ route('usuario.master.notificacion', [$master->id, 1]) }}">
                                                @csrf
                                                <button type="submit" class="btn text-primary"><i class="far fa-bell"></i></i></button>
                                            </form>
                                        @else
                                            <form method="post" action="{{ route('usuario.master.notificacion', [$master->id, 0]) }}">
                                                @csrf
                                                <button type="submit" class=" btn text-danger"><i class="far fa-bell-slash"></i></button>
                                            </form>
                                        @endif
                                    @endif
                                @endauth
                            @endif
                        @endauth
                        <button class="btn btn-warning compartir ml-2"><i class="fas fa-share-alt"></i></button>
                        @auth
                            @if(Auth::user() && !Auth::user()->master)
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
                <div class="col-md-8 mt-4">
                    <div id="contenido">
                        <div class="estados">
                            <h3>Estados</h3>
                            @if ($master->posts->where('juego_id', null)->count() != 0)
                                @foreach ($master->posts->where('juego_id', null) as $post)
                                    <div class="alert alert-dark">
                                        {!! $post->contenido !!}
                                        @if(Auth::user() && Auth::user()->master != null && $master->id == Auth::user()->master->id)
                                            <form action="{{ route('master.estado.destroy', $post->id) }}" method="post">
                                                @csrf
                                                @method("DELETE")
                                                <button class="btn btn-danger btn-sm round ml-1 eliminar-estado" type="submit">
                                                    <i class="far fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                @endforeach
                            @else
                                Aún no ha publicado ninguna actualización.
                            @endif
                        </div>
                        <div class="analisis-div d-none">
                            <h3>Análisis</h3>
                            @if ($master->posts->where('juego_id', '!=', null)->count() != 0)
                                @foreach ($master->posts->where('juego_id', '!=', null) as $post)
                                <hr>
                                    <div>
                                        <h4>{{ $post->titulo }}</h4>
                                        <p>{!! substr($post->contenido, 0, 300) !!}...</p>
                                        <small>Comentarios: {{ $post->mensajes->count() }}</small>
                                        <form>
                                            <input type="hidden" name="id" value="{{ $post->id }}" />
                                            <a type="submit" class="more">Leer más</a>
                                        </form>
                                    </div>
                                @endforeach
                            @else
                                Aún no ha publicado ningún análisis.
                            @endif
                        </div>
                        <div class="notas d-none">
                            <h3>Notas</h3>
                            @if ($master->posts->where('juego_id', '!=', null)->count() != 0)
                                @foreach ($master->posts->where('juego_id', '!=', null) as $post)
                                    <div>
                                        <h4>{{ $post->titulo }}</h4>
                                        <p>{!! $post->calificacion !!}</p>
                                    </div>
                                @endforeach
                            @else
                                Aún no ha publicado ningún análisis.
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-3 offset-md-1 mt-4">
                    @if ($master->posts->where('juego_id', '!=', null)->where('destacado', 1)->count() != 0)
                        <h2>Top 5</h2>
                        <hr>
                        @foreach ($master->posts->where('juego_id', '!=', null)->where('destacado', 1) as $post)
                            {{$post->juego->nombre}}
                        @endforeach
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
                let user = "{{{ (Auth::user()) ? Auth::user() : null }}}";
                if(user != '' && user.ban == 0 && user.email_verified_at != null) {
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
