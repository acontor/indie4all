@extends("layouts.usuario.base")
@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
@endsection
@section('content')
    <main class="p-3 pb-5">
        <div class="container box mt-4">
            <div class="row mb-4">
                <h1 class="ml-3">Masters para tí</h1>
            </div>

            <div class="owl-carousel 1">
                @foreach ($masters->take('10') as $master)
                    <div class="item">
                        <a href="{{ route('usuario.master.show', $master->id) }}">
                            <img src="https://spdc.ulpgc.es/media/ulpgc/images/thumbs/edition-44827-200x256.jpg"
                                alt="{{ $master->nombre }}">
                            <div class="carousel-caption mb-5" style="display: none;">
                                <h6><strong>{{ $master->nombre }}</strong></h6>
                                <small class="float-left text-left">Seguidores: {{ $master->usuarios->count() }}</small>
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
        </div>
    </main>
@endsection
@section('scripts')
    <script src="{{ asset('js/paginga.jquery.min.js') }}"></script>
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
