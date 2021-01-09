@extends("layouts.usuario.base")

@section('content')
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
            <div class="row mb-4">
                <h1 class="ml-3">Masters para tí <a href="/masters/lista" class="btn btn-primary">Ver todos</a></h1>
            </div>

            <div class="owl-carousel 1">
                @foreach ($masters->take('10') as $master)
                    <div class="item">
                        <a href="{{ route('usuario.master.show', $master->id) }}">
                            <img src="https://spdc.ulpgc.es/media/ulpgc/images/thumbs/edition-44827-200x256.jpg"
                                alt="{{ $master->nombre }}">
                            <div class="carousel-caption mb-5 d-none">
                                <h6><strong>{{ $master->nombre }}</strong></h6>
                                <small class="float-left text-left">Seguidores: {{ $master->seguidores->count() }}</small>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

            <hr class="mt-4 mb-5">

            <div class="row">
                <div class="col-12 col-md-7">
                    @if($seguidos->count() > 0)
                        <h2>Últimos análisis de tus masters</h2>
                        <div class="noticias">
                            <div class="items">
                                @foreach ($seguidos as $master)
                                    @foreach ($master->posts as $post)
                                        <div>
                                            <h4>{{ $post->titulo }} <small>{{ $post->created_at }}</small></h4>
                                            <p>{!! substr($post->contenido, 0, 300) !!}</p>
                                            <form>
                                                <input type="hidden" name="id" value="{{ $post->id }}" />
                                                <a type="submit" class="more">Leer más</a>
                                            </form>
                                        </div>
                                    @endforeach
                                @endforeach
                            </div>
                            <div class="pager">
                                <div class="firstPage">&laquo;</div>
                                <div class="previousPage">&lsaquo;</div>
                                <div class="pageNumbers"></div>
                                <div class="nextPage">&rsaquo;</div>
                                <div class="lastPage">&raquo;</div>
                            </div>
                        </div>
                    @else
                        @auth
                            No sigues a ningún master aún
                        @endauth
                        <h2>Últimos análisis</h2>
                        <div class="noticias">
                            <div class="items">
                                @foreach ($masters as $master)
                                    @foreach ($master->posts as $post)
                                        <div>
                                            <h4>{{ $post->titulo }} <small>{{ $post->created_at }}</small></h4>
                                            <p>{!! substr($post->contenido, 0, 300) !!}</p>
                                            <form>
                                                <input type="hidden" name="id" value="{{ $post->id }}" />
                                                <a type="submit" class="more">Leer más</a>
                                            </form>
                                        </div>
                                    @endforeach
                                @endforeach
                            </div>
                            <div class="pager">
                                <div class="firstPage">&laquo;</div>
                                <div class="previousPage">&lsaquo;</div>
                                <div class="pageNumbers"></div>
                                <div class="nextPage">&rsaquo;</div>
                                <div class="lastPage">&raquo;</div>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="col-12 col-md-4 offset-md-1 mt-5 mt-md-0">
                    <div class="owl-carousel owl-theme 2">
                        <div class="item">
                            <h4>Masters + seguidores</h4>
                            <hr>
                            @foreach ($masters->take(5) as $master)
                                {{ $master->nombre }}
                                <br>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="hola container bg-light p-3 shadow-lg rounded mt-4">Hola</div>
        </div>
    </main>
@endsection

@section('scripts')
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






            $('img').addClass('img-fluid');
            $('img').addClass('h-auto');

            var owl = $('.1');

            owl.owlCarousel({
                loop: false,
                margin: 10,
                dots: true,
                responsive: {
                    0: {
                        items: 1.5
                    },
                    600: {
                        items: 3.5
                    },
                    1000: {
                        items: 5.5
                    }
                }
            });

            mousewheel(owl);

            var owl2 = $('.2');

            owl2.owlCarousel({
                loop: true,
                margin: 10,
                items: 1,
                navText : ['<i class="fa fa-angle-left" aria-hidden="true"></i>','<i class="fa fa-angle-right" aria-hidden="true"></i>']
            });

            mousewheel(owl2);

            function mousewheel(objeto) {
                objeto.on('mousewheel', '.owl-stage', function(e) {
                    e.preventDefault();
                    if (e.originalEvent.wheelDelta > 0) {
                        objeto.trigger('prev.owl');
                    } else {
                        objeto.trigger('next.owl');
                    }
                });
            }
        });

    </script>
@endsection
