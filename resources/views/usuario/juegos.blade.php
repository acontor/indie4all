@extends("layouts.usuario.base")

@section('content')
    <main class="p-3 pb-5">
        <div class="container box mt-4">
            <div class="row mb-4">
                <div class="col-12 col-md-8">
                    <h3 class="ml-3 text-uppercase font-weight-bold">Recomendaciones</h3>
                    <div class="owl-carousel 1 mt-5">
                        @foreach ($juegos->take('10') as $juego)
                            <div class="item m-2 shadow">
                                <a href="{{ route('usuario.juego.show', $juego->id) }}">
                                    <img src="https://spdc.ulpgc.es/media/ulpgc/images/thumbs/edition-44827-200x256.jpg"
                                        alt="{{ $juego->nombre }}">
                                    <div class="carousel-caption" style="display: none;">
                                        <h6>{{ $juego->nombre }}</h6>
                                        <small>
                                            {{ $juego->desarrolladora->nombre }}
                                            <br>
                                            <span class="badge badge-danger">{{ $juego->genero->nombre }}</span>
                                            <br>
                                            {{ $juego->precio }} €
                                        </small>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-12 col-md-4 mx-auto">
                    <h3 class="text-uppercase font-weight-bold text-center">Destacados</h3>
                    <div class="mt-4 text-center">
                        <a href="{{ route('usuario.juego.show', $juego->first()->id) }}">
                            <img class="img-fluid" height="20" src="https://spdc.ulpgc.es/media/ulpgc/images/thumbs/edition-44827-200x256.jpg"
                                alt="{{ $juego->first()->nombre }}">
                            <div class="carousel-caption" style="display: none;">
                                <h6>{{ $juego->first()->nombre }}</h6>
                                <small>
                                    {{ $juego->first()->desarrolladora->nombre }}
                                    <br>
                                    <span class="badge badge-danger">{{ $juego->first()->genero->nombre }}</span>
                                    <br>
                                    {{ $juego->first()->precio }} €
                                </small>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <hr class="mt-5">
            <div class="row">
                <div class="col-12 col-md-8 pt-5">
                    <div class="shadow p-3">
                        @isset($seguidos)
                            <h2>Últimas noticias de tus juegos</h2>
                            <p>asdasd</p>
                            <p>asdasd</p>
                            <p>asdasd</p>
                            <p>asdasd</p>
                            <p>asdasd</p>
                            <p>asdasd</p>
                            <p>asdasd</p>
                            <p>asdasd</p>
                            <p>asdasd</p>
                            <p>asdasd</p>
                            <p>asdasd</p>
                            <p>asdasd</p>
                            <p>asdasd</p>
                            <p>asdasd</p>
                            <p>asdasd</p>
                            <p>asdasd</p>
                            <p>asdasd</p>
                            <p>asdasd</p>
                            <p>asdasd</p>
                            <p>asdasd</p>
                            <p>asdasd</p>
                            <p>asdasd</p>
                            <p>asdasd</p>
                            <p>asdasd</p>
                            <p>asdasd</p>
                            <p>asdasd</p>
                            <p>asdasd</p>
                            <p>asdasd</p>
                            <p>asdasd</p>
                            <p>asdasd</p>
                            <p>asdasd</p>
                            <p>asdasd</p>
                            <p>asdasd</p>
                            <p>asdasd</p>
                            <p>asdasd</p>
                            <p>asdasd</p>
                            <p>asdasd</p>
                            <p>asdasd</p>
                            <p>asdasd</p>
                            <p>asdasd</p>
                            <p>asdasd</p>
                            <p>asdasd</p>
                            <p>asdasd</p>
                            <p>asdasd</p>
                            <p>asdasd</p>
                            <p>asdasd</p>
                            <p>asdasd</p>
                            <p>asdasd</p>
                            <p>asdasd</p>
                            <p>asdasd</p>
                            <p>asdasd</p>
                            <p>asdasd</p>
                            <p>asdasd</p>
                            <p>asdasd</p>
                            <p>asdasd</p>
                            <p>asdasd</p>
                            <p>asdasd</p>
                            <p>asdasd</p>
                            <p>asdasd</p>
                            <p>asdasd</p>
                            <p>asdasd</p>
                            <p>asdasd</p>
                            <p>asdasd</p>
                            <p>asdasd</p>
                            <p>asdasd</p>
                            <p>asdasd</p>
                            <p>asdasd</p>
                            <p>asdasd</p>
                            <p>asdasd</p>
                            <p>asdasd</p>
                            <p>asdasd</p>
                            <p>asdasd</p>
                            <p>asdasd</p>
                            <p>asdasd</p>
                            <p>asdasd</p>
                            <p>asdasd</p>
                            <p>asdasd</p>
                            <p>asdasd</p>
                            <p>asdasd</p>
                            <p>asdasd</p>
                            <p>asdasd</p>
                            <p>asdasd</p>
                            <p>asdasd</p>
                            <p>asdasd</p>
                            <p>asdasd</p>
                            <p>asdasd</p>
                            <p>asdasd</p>
                            <p>asdasd</p>
                            <p>asdasd</p>
                            <p>asdasd</p>
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
                                    @foreach ($juegos as $juego)
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
                        @endisset
                    </div>
                </div>
                <div class="col-12 col-md-4 mt-5 mt-md-0">
                    <nav class="sticky-top pt-5 bg-transparent">
                        <div class="list-group shadow">
                            <ul class="list-group list-group-horizontal text-center text-uppercase font-weight-bold" style="font-size: .5rem;">
                                <a href="" id="nuevos" class="list-group-item list-group-item-action list-buttons">Nuevo</a>
                                <a href="" id="ventas" class="list-group-item list-group-item-action list-buttons">Venta</a>
                                <a href="" id="populares" class="list-group-item list-group-item-action list-buttons">Popular</a>
                            </ul>
                            <a href="/juegos/lista" class="btn btn-danger rounded-0">Ver todos</a>
                            @foreach ($juegos->take(5) as $juego)
                                <a href="{{route('usuario.juego.show', $juego->id)}}" class="list-group-item list-group-item-action flex-column align-items-start listado nuevos">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1"><b>{{$juego->nombre}}</b></h6>
                                        <small>Seguidores: {{$juego->seguidores->count()}}</small>
                                    </div>
                                    <p class="mb-1">{{$juego->desarrolladora->nombre}}</p>
                                    <span class="btn btn-dark btn-sm float-right">{{$juego->precio}} €</span>
                                    <small class="badge badge-danger badge-pill mt-2">{{$juego->genero->nombre}}</small>
                                </a>
                            @endforeach
                            @foreach ($juegos->take(5) as $juego)
                                <a href="{{route('usuario.juego.show', $juego->id)}}" class="list-group-item list-group-item-action flex-column align-items-start listado d-none ventas">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1"><b>{{$juego->nombre}}</b></h6>
                                        <small>Seguidores: {{$juego->seguidores->count()}}</small>
                                    </div>
                                    <p class="mb-1">{{$juego->desarrolladora->nombre}}</p>
                                    <span class="btn btn-dark btn-sm float-right">{{$juego->precio}} €</span>
                                    <small class="badge badge-danger badge-pill mt-2">{{$juego->genero->nombre}}</small>
                                </a>
                            @endforeach
                            @foreach ($juegos->take(5) as $juego)
                                <a href="{{route('usuario.juego.show', $juego->id)}}" class="list-group-item list-group-item-action flex-column align-items-start listado d-none populares">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1"><b>{{$juego->nombre}}</b></h6>
                                        <small>Seguidores: {{$juego->seguidores->count()}}</small>
                                    </div>
                                    <p class="mb-1">{{$juego->desarrolladora->nombre}}</p>
                                    <span class="btn btn-dark btn-sm float-right">{{$juego->precio}} €</span>
                                    <small class="badge badge-danger badge-pill mt-2">{{$juego->genero->nombre}}</small>
                                </a>
                            @endforeach
                        </div>
                    </header>
                </nav>
            </div>
        </div>
    </main>
@endsection

@section('scripts')
    <script src="{{ asset('js/paginga/paginga.jquery.min.js') }}"></script>
    <script>
        $(function() {
            $('.list-buttons').on('click', function(e) {
                e.preventDefault();
                let item = $(this).attr('id');
                $('.listado').each(function () {
                    if (!$(this).hasClass("d-none")) {
                        $(this).addClass('d-none');
                    }
                });
                $('.' + item).removeClass('d-none');
            });

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
                        items: 4.5
                    }
                }
            });

            mousewheel(owl);

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
