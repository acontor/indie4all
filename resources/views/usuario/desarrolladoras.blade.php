@extends("layouts.usuario.base")

@section('content')
    <main class="p-3 pb-5">
        <div class="container box mt-4">
            <div class="row mb-4">
                <h1 class="ml-3">Desarrolladoras para tí</h1>
            </div>

            <div class="owl-carousel 1">
                @foreach ($desarrolladoras->take('10') as $desarrolladora)
                    <div class="item">
                        <a href="{{ route('usuario.desarrolladora.show', $desarrolladora->id) }}">
                            <img src="https://spdc.ulpgc.es/media/ulpgc/images/thumbs/edition-44827-200x256.jpg"
                                alt="{{ $desarrolladora->nombre }}">
                            <div class="carousel-caption" style="display: none;">
                                <h6><strong>{{ $desarrolladora->nombre }}</strong></h6>
                                <small class="float-left text-left">Juegos: {{ $desarrolladora->juegos->count() }}</small>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

            <hr class="mt-4 mb-5">

            <div class="row">
                <div class="col-12 col-md-7">
                    @isset($seguidos)
                        <h2>Últimas noticias de tus desarrolladoras</h2>
                        <div class="noticias">
                            <div class="items">
                                @foreach ($seguidos as $juego)
                                    @foreach ($juego->posts->where('master_id', null) as $post)
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
                            No sigues a ningún juego aún
                        @endauth
                        <h2>Últimas noticias</h2>
                        <div class="noticias">
                            <div class="items">
                                @foreach ($desarrolladoras as $desarrolladora)
                                    @foreach ($desarrolladora->posts as $post)
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
                    @endisset
                </div>

                <div class="col-12 col-md-4 offset-md-1 mt-5 mt-md-0">
                    <div class="owl-carousel owl-theme 2">
                        <div class="item">
                            <h4>Desarrolladoras + seguidores</h4>
                            <hr>
                            @foreach ($desarrolladoras->take(5) as $desarrolladora)
                                {{ $desarrolladora->nombre }}
                                <br>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('scripts')
    <script src="{{ asset('js/paginga/paginga.jquery.min.js') }}"></script>
    <script>
        $(function() {
            $(".noticias").paginga();

            var owl = $('.1');

            owl.owlCarousel({
                loop: true,
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

            $(".item").hover(function() {
                $(this).children('a').children('img').css('filter', 'brightness(0.2)');
                $(this).children('a').children('div').fadeToggle(200, "linear");
            }, function() {
                $(this).children('a').children('img').css('filter', 'brightness(1)');
                $(this).children('a').children('div').fadeToggle(0, "linear");
            });
        });

    </script>
@endsection
