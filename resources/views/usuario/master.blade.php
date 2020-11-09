@extends('layouts.base')

@section('content')


    <header>
        <img class="img-fluid" src="{{ asset('/images/default.png') }}" style="height: 500px;">
        <div>

            <h1 class="font-weight-light">{{ $master->usuario->name }}</h1>
            <ul class="lead">
                <li> Email: {{ $master->email }}</li>
                <li> imagen: {{ $master->imagen }}</li>
                <li>
                    <div class="btn-group mt-3">
                        @if ($usuario == null)
                            <form method='post' action="{{ route('usuario.master.follow', $master->id) }}">
                                @csrf
                                <button type="submit" class="btn text-primary"><i class="far fa-check-circle"></i></button>
                            </form>
                        @else
                            <form method='post' action="{{ route('usuario.master.unfollow', $master->id) }}">
                                @csrf
                                <button type="submit" class="btn text-danger"><i class="far fa-times-circle"></i></button>
                            </form>
                            @if ($usuario->pivot->notificacion == 0)
                                <form method='post' action="{{ route('usuario.master.notificacion', [$master->id, 1]) }}">
                                    @csrf
                                    <button type="submit" class="btn text-primary"><i class="far fa-bell"></i></i></button>
                                </form>
                            @else
                                <form method='post' action="{{ route('usuario.master.notificacion', [$master->id, 0]) }}">
                                    @csrf
                                    <button type="submit" class=" btn text-danger"><i class="far fa-bell-slash"></i></button>
                                </form>
                            @endif
                        @endif
                    </div>
                </li>
            </ul>
        </div>
    </header>


    <main class="py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="row text-center menu">
                        <div class="col-3"><a id="general" href="">General</a></div>
                        <div class="col-3"><a id="analisis" href="">Análisis</a></div>
                    </div>
                    <hr>
                    <div id="contenido">
                        <div class="general">
                            <h2>General</h2>
                            @if ($master->posts->count() != 0)
                                @foreach ($master->posts as $post)
                                    <div>
                                        <h4>{{ $post->titulo }}</h4>
                                        <p>{{ $post->contenido }}</p>
                                    </div>
                                @endforeach
                            @else
                                Aún no ha publicado ningún post.
                            @endif
                        </div>
                        <div class="analisis d-none">
                            <h2>Análisis</h2>
                            @if ($master->posts->count() != 0)
                                @foreach ($master->posts as $post)
                                    <div>
                                        <h4>{{ $post->titulo }}</h4>
                                        <p>{{ $post->contenido }}</p>
                                    </div>
                                @endforeach
                            @else
                                Aún no ha publicado ningún análisis.
                            @endif
                        </div>
                    </div>
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
