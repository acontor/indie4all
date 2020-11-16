@extends("layouts.usuario.base")

@section("content")
    <div class="container p-5">
        <div class="row">
            <div class="col-12 p-0">
                <header>
                    <img class="img-fluid h-auto" src="{{ asset("/images/default.png") }}">
                    <div>
                        <h1 class="font-weight-light">{{ $juego->nombre }}</h1>
                        <ul class="lead">
                            <li>
                                <a href="{{ route("usuario.desarrolladora.show", $juego->desarrolladora->id) }}" target="blank">{{ $juego->desarrolladora->nombre }}</a>
                            </li>
                            <li>
                                <div class="btn-group mt-3">
                                    @if ($usuario == null)
                                        <form method="post" action="{{ route("usuario.juego.follow", $juego->id) }}">
                                            @csrf
                                            <button type="submit" class="btn text-primary">
                                                <i class="far fa-check-circle"></i>
                                            </button>
                                        </form>
                                    @else
                                        <form method="post" action="{{ route("usuario.juego.unfollow", $juego->id) }}">
                                            @csrf
                                            <button type="submit" class="btn text-danger">
                                                <i class="far fa-times-circle"></i>
                                            </button>
                                        </form>
                                        @if ($usuario->pivot->notificacion == 0)
                                            <form method="post"
                                                action="{{ route("usuario.juego.notificacion", [$juego->id, 1]) }}">
                                                @csrf
                                                <button type="submit" class="btn text-primary text-primary">
                                                    <i class="far fa-bell"></i></i>
                                                </button>
                                            </form>
                                        @else
                                            <form method="post"
                                                action="{{ route("usuario.juego.notificacion", [$juego->id, 0]) }}">
                                                @csrf
                                                <button type="submit" class="btn text-danger">
                                                    <i class="far fa-bell-slash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    @endif
                                </div>
                            </li>
                        </ul>
                    </div>
                </header>
            </div>
            <div class="col-md-8 box mt-4">
                <div class="row menu tex-center">
                    <div class="col-3"><a id="general" href="">General</a></div>
                    <div class="col-3"><a id="comprar" href="">Comprar</a></div>
                    <div class="col-3"><a id="noticias" href="">Noticias</a></div>
                    <div class="col-3"><a id="actualizaciones" href="">Actualizaciones</a></div>
                </div>
                <hr>
                <div id="contenido">
                    <div class="general">
                        <h2>General</h2>
                        @if ($juego->posts->count() != 0)
                            @foreach ($juego->posts as $post)
                                <div>
                                    <h4>{{ $post->titulo }}</h4>
                                    <p>{{ $post->contenido }}</p>
                                </div>
                            @endforeach
                        @else
                            Aún no ha publicado ningún post.
                        @endif
                    </div>
                    <div class="comprar d-none">
                        <h2>Comprar</h2>
                    </div>
                    <div class="noticias d-none">
                        <h2>Noticias</h2>
                        @if ($juego->posts->count() != 0)
                            @foreach ($juego->posts as $post)
                                <div>
                                    <h4>{{ $post->titulo }}</h4>
                                    <p>{{ $post->contenido }}</p>
                                </div>
                            @endforeach
                        @else
                            Aún no ha publicado ninguna actualización.
                        @endif
                    </div>
                    <div class="actualizaciones d-none">
                        <h2>Actualizaciones</h2>
                        @if ($juego->posts->count() != 0)
                            @foreach ($juego->posts as $post)
                                <div>
                                    <h4>{{ $post->titulo }}</h4>
                                    <p>{{ $post->contenido }}</p>
                                </div>
                            @endforeach
                        @else
                            Aún no ha publicado ninguna actualización.
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-3 offset-md-1 box mt-4">
                <h4>Recomendaciones</h4>
                <hr>
            </div>
        </div>
    </div>
@endsection
@section("scripts")
    <script>
        $(function() {
            $(".menu").children("div").children("a").click(function(e) {
                e.preventDefault();
                let item = $(this).attr("id");
                $("#contenido").children("div").addClass("d-none");
                $(`.${item}`).removeClass("d-none");
            });
        });

    </script>
@endsection
