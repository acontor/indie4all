<body>
    <h4>Hola {{ $name }}</h4>
    <!-- Logo corporativo -->
    <img src="{{ asset('/images/default.png') }}" height="100" />
    @if ($postsJuegos->count() + $postsDesarrolladoras->count() + $postsMasters->count() > 0)
        @if ($postsJuegos->count() > 0)
            @foreach ($postsJuegos->take(2) as $post)
                <h4>{{ $post->titulo }}</h4>
                <p>{!! substr($post->contenido, 0, 100) !!}</p>
                <small>Noticia de {{ $post->juego->nombre }}</small>
                <a href="http:127.0.0.1:8000/juego/{{ $post->juego->id }}">Visitar juego</a>
                <hr>
            @endforeach
        @endif
        @if ($postsDesarrolladoras->count() > 0)
            @foreach ($postsDesarrolladoras->take(2) as $post)
                <h4>{{ $post->titulo }}</h4>
                <p>{!! substr($post->contenido, 0, 100) !!}</p>
                <small>Noticia de {{ $post->desarrolladora->nombre }}</small>
                <a href="http:127.0.0.1:8000/desarrolladora/{{ $post->desarrolladora->id }}">Visitar desarrolladora</a>
                <hr>
            @endforeach
        @endif
        @if ($postsMasters->count() > 0)
            @foreach ($postsMasters->take(2) as $post)
                <h4>{{ $post->titulo }}</h4>
                <p>{!! substr($post->contenido, 0, 100) !!}</p>
                <small>Análisis de {{ $post->master->nombre }}</small>
                <a href="/master/{{ $post->master->id }}">Visitar master</a>
                <hr>
            @endforeach
        @endif
    @endif
    @if ($estrenos->count() > 0)
        <ul>
            @foreach ($estrenos as $juego)
                <li><a href="http:127.0.0.1:8000/juego/{{ $juego->id }}">{{ $juego->nombre }}</a></li>
            @endforeach
        </ul>
    @endif
    <br>
    <small>Le saluda cordialmente, Indie4all</small>
</body>
