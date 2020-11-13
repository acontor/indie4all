@extends('layouts.base')

@section('content')

    <header>
        <img class="img-fluid" src="{{ asset("/images/default.png") }}" style="height: 500px;">
        <div>
            <h1 class="font-weight-light">{{ $desarrolladora->nombre }}</h1>
            <ul class="lead">
                <li><a href="http://{{ $desarrolladora->url }}" target="blank">{{ $desarrolladora->url }}</a></li>
                <li>
                    <div class="btn-group mt-3">
                        @if ($usuario == null)
                            <form action="{{ route('usuario.desarrolladora.follow', $desarrolladora->id) }}" method='post'>
                                @csrf
                                <button type="submit" class="btn text-primary"><i class="far fa-check-circle"></i></button>
                            </form>
                        @else
                            <form action="{{ route('usuario.desarrolladora.unfollow', $desarrolladora->id) }}"
                                method='post'>
                                @csrf
                                <button type="submit" class="btn text-danger"><i class="far fa-times-circle"></i></button>
                            </form>
                            @if ($usuario->pivot->notificacion == 0)
                                <form action="{{ route('usuario.desarrolladora.notificacion', [$desarrolladora->id, 1]) }}"
                                    method='post'>
                                    @csrf
                                    <button type="submit" class="btn text-primary"><i class="far fa-bell"></i></button>
                                </form>
                            @else
                                <form action="{{ route('usuario.desarrolladora.notificacion', [$desarrolladora->id, 0]) }}"
                                    method='post'>
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

    <main class="py-4">
        <div class="container mt-3">
            <div class="row">
                <div class="col-md-8">
                    <div class="row text-center menu">
                        <div class="col-3"><a id="general" href="">General</a></div>
                        <div class="col-3"><a id="sorteos" href="">Sorteos</a></div>
                        <div class="col-3"><a id="encuestas" href="">Encuestas</a></div>
                        <div class="col-3"><a id="contacto" href="">Contacto</a></div>
                    </div>
                    <hr>
                    <div id="contenido">
                        <div class="general">
                            <h2>Posts</h2>
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
                            <h2>Sorteos</h2>
                        </div>
                        <div class="encuestas d-none">
                            <h2>Encuestas</h2>
                        </div>
                        <div class="contacto d-none">
                            <h2>contacto</h2>
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
                <div class="col-md-3 offset-1">
                    <h4>Juegos</h4>
                    <hr>
                    @foreach ($desarrolladora->juegos as $juego)
                        <a href="{{ route('usuario.juego.show', $juego->id) }}">{{ $juego->nombre }}</p>
                    @endforeach
                </div>
            </div>
        </div>
    </main>
@endsection
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(function() {
        $(".menu").children('div').children('a').click(function(e) {
            e.preventDefault();
            let item = $(this).attr('id');
            $("#contenido").children('div').addClass('d-none');
            $(`.${item}`).removeClass('d-none');
        });
    });

</script>
