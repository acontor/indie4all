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
        <div class="container box mt-4">
            <div class="row">
                <div class="col-12 col-md-7">
                    <h2>Últimas noticias</h2>
                    <div class="noticias">
                        <div class="items">
                            @if ($noticias->count() != 0)
                                @foreach ($noticias as $noticia)
                                    <div>
                                        <h4>{{ $noticia->titulo }}</h4>
                                        <p>{!! substr($noticia->contenido, 0, 300) !!}...</p>
                                        {{ $noticia->created_at }}
                                        @if ($noticia->comentarios)
                                            <small>Comentarios: {{ $noticia->comentarios->count() }}</small>
                                        @endif
                                        <form>
                                            <input type="hidden" name="id" value="{{ $noticia->id }}" />
                                            <a type="submit" class="more">Leer más</a>
                                        </form>
                                    </div>
                                @endforeach
                            @else
                                Aún no hay publicada ninguna noticia.
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

                <div class="col-12 col-md-4 offset-md-1 mt-5 mt-md-0">
                    <h4>Desarrolladoras</h4>
                    <hr>
                    @foreach ($desarrolladoras as $desarrolladora)
                        <li>{{ $desarrolladora->nombre }}</li>
                    @endforeach
                    <h4 class="mt-5">Juegos + puntuación</h4>
                    <hr>
                    @foreach ($juegos as $juego)
                        <li>{{ $juego->nombre }} - Punt.
                            {{ $juego->seguidores->sum("pivot.calificacion") / $juego->seguidores->count() }}
                        </li>
                    @endforeach
                    <h4 class="mt-5">Masters</h4>
                    <hr>
                    @foreach ($masters as $master)
                        <li>{{ $master->usuario->name }}</li>
                    @endforeach
                </div>
            </div>
            <div class="hola container bg-light p-3 shadow-lg rounded mt-4">Hola</div>
        </div>
    </main>
@endsection

@section("scripts")
    <script src="{{ asset('js/paginga/paginga.jquery.min.js') }}"></script>
    <script src="{{ asset('js/usuario.js') }}"></script>
    <script>
        $(function() {
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
        });

    </script>
@endsection
