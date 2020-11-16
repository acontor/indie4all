@extends("layouts.usuario.base")

@section("content")
<div class="container p-5">
    <div class="row">
        <div class="col-12 p-0">
            <header>
                <img class="img-fluid h-auto" src="{{ asset("/images/default.png") }}">
                <div>
                    <h1 class="font-weight-light">{{ $desarrolladora->nombre }}</h1>
                    <ul class="lead">
                        <li><a href="http://{{ $desarrolladora->url }}" target="blank">{{ $desarrolladora->url }}</a></li>
                        <li>
                            <div class="btn-group mt-3">
                                @if ($usuario == null)
                                    <form action="{{ route("usuario.desarrolladora.follow", $desarrolladora->id) }}" method="post">
                                        @csrf
                                        <button type="submit" class="btn text-primary"><i class="far fa-check-circle"></i></button>
                                    </form>
                                @else
                                    <form action="{{ route("usuario.desarrolladora.unfollow", $desarrolladora->id) }}"
                                        method="post">
                                        @csrf
                                        <button type="submit" class="btn text-danger"><i class="far fa-times-circle"></i></button>
                                    </form>
                                    @if ($usuario->pivot->notificacion == 0)
                                        <form action="{{ route("usuario.desarrolladora.notificacion", [$desarrolladora->id, 1]) }}"
                                            method="post">
                                            @csrf
                                            <button type="submit" class="btn text-primary"><i class="far fa-bell"></i></button>
                                        </form>
                                    @else
                                        <form action="{{ route("usuario.desarrolladora.notificacion", [$desarrolladora->id, 0]) }}"
                                            method="post">
                                            @csrf
                                            <button type="submit" class="btn text-danger"><i class="far fa-bell-slash"></i></button>
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
            <div class="row text-center menu">
                <div class="col-4 col-md-2 offset-md-1"><a id="general" href="">General</a></div>
                <div class="col-4 col-md-2"><a id="noticias" href="">Noticias</a></div>
                <div class="col-4 col-md-2"><a id="sorteos" href="">Sorteos</a></div>
                <div class="col-4 col-md-2"><a id="encuestas" href="">Encuestas</a></div>
                <div class="col-4 col-md-2"><a id="contacto" href="">Contacto</a></div>
            </div>
            <hr>
            <div id="contenido">
                <div class="general">
                    <h3>Contenido</h3>
                </div>
                <div class="noticias d-none">
                    <h3>Posts</h3>
                    @if ($desarrolladora->posts->count() != 0)
                        @foreach ($desarrolladora->posts as $post)
                            <div>
                                <h4>{{ $post->titulo }}</h4>
                                <p>{{ $post->contenido }}</p>
                            </div>
                        @endforeach
                    @else
                        La desarrolladora aún no ha publicado ningún post.
                    @endif
                </div>
                <div class="sorteos d-none">
                    <h3>Sorteos</h3>
                    <div class="row">
                        @foreach ($desarrolladora->sorteos as $sorteo)
                            <div class="col-6">
                                <h4>{{ $sorteo->titulo }}</h4>
                                <p>{{ $sorteo->descripcion }}</p>
                                <p>{{ $sorteo->fecha_fin }}</p>
                                <button class="btn btn-success">Participar</button>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="encuestas d-none">
                    <h3>Encuestas</h3>
                </div>
                <div class="contacto d-none">
                    <h3>Contacto</h3>
                    <ul class="lead">
                        <li><a href="http://{{ $desarrolladora->url }}"
                                target="blank">{{ $desarrolladora->url }}</a>
                        </li>
                        <li><a href="mailto:{{ $desarrolladora->email }}"
                                target="blank">{{ $desarrolladora->email }}</a></li>
                        <li>{{ $desarrolladora->direccion }}</li>
                        <li>{{ $desarrolladora->telefono }}</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-3 offset-md-1 box mt-4">
            <h4>Juegos</h4>
            <hr>
            <ul>
                @foreach ($desarrolladora->juegos as $juego)
                    <li><a href="{{ route("usuario.juego.show", $juego->id) }}">{{ $juego->nombre }}</a></li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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
