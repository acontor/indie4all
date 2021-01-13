@extends("layouts.usuario.base")

@section('content')
    <main class="p-3 pb-5">
        <div class="container box mt-4">
            <div class="row mb-4">
                <div class="col-12 col-md-8">
                    <h3 class="ml-3 text-uppercase font-weight-bold">Recomendaciones</h3>
                    <div class="owl-carousel owl-theme mt-5">
                        @foreach ($recomendados->take('10') as $juego)
                            <div class="item m-2 shadow">
                                <a href="{{ route('usuario.juego.show', $juego->id) }}">
                                    @if ($juego->imagen_caratula != null)
                                        <img src="{{ asset('/images/desarrolladoras/' . $juego->desarrolladora->nombre . '/' . $juego->nombre . '/' . $juego->imagen_caratula) }}" alt="{{ $juego->nombre }}">
                                    @else
                                        <img src="{{ asset('/images/desarrolladoras/default-logo-juego.png') }}" alt="{{ $juego->nombre }}">
                                    @endif
                                    <div class="carousel-caption d-none">
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
                    @if($juegos->count() > 0)
                        <div class="mt-4 text-center item">
                            <a href="{{ route('usuario.juego.show', $juegos->first()->id) }}">
                                @if ($juego->imagen_caratula != null)
                                    <img class="img-fluid shadow" src="{{ asset('/images/desarrolladoras/' . $juegos->first()->desarrolladora->nombre . '/' . $juegos->first()->nombre . '/' . $juegos->first()->imagen_caratula) }}" alt="{{ $juegos->first()->nombre }}">
                                @else
                                    <img class="img-fluid shadow" src="{{ asset('/images/desarrolladoras/default-logo-juego.png') }}" alt="{{ $juegos->first()->nombre }}">
                                @endif
                                <div class="carousel-caption mb-5 d-none">
                                    <h6>{{ $juegos->first()->nombre }}</h6>
                                    <small>
                                        {{ $juegos->first()->desarrolladora->nombre }}
                                        <br>
                                        <span class="badge badge-danger">{{ $juegos->first()->genero->nombre }}</span>
                                        <br>
                                        {{ $juegos->first()->precio }} €
                                    </small>
                                </div>
                            </a>
                        </div>
                    @else
                        <span class="text-danger">No hay juegos destacados</span>
                    @endisset
                </div>
            </div>
            <hr class="mt-5 mb-5">
            <div class="row">
                <div class="col-12 col-md-9">
                    <div class="list-group">
                        <ul class="list-group list-group-horizontal text-center text-uppercase font-weight-bold" style="font-size: .5rem;">
                            <a href="" id="noticias" class="list-group-item list-buttons-2 bg-dark text-white text-decoration-none pop-info"
                            data-content="Muestra todas las noticias de los juegos" rel="popover" data-placement="bottom" data-trigger="hover">Últimas noticias</a>
                            <a href="" id="analisis-div" class="list-group-item list-buttons-2 text-dark text-decoration-none pop-info"
                            data-content="Muestra todos los análisis de juegos" rel="popover" data-placement="bottom" data-trigger="hover"">Análisis</a>
                        </ul>
                        <div class="list-group-item flex-column align-items-start listado-2 noticias">
                            <div class="items row mt-4">
                                @if($posts->count() > 0)
                                    @foreach ($posts as $post)
                                        <div class="col-12 col-md-6 berber">
                                            <div class="pildoras mb-3">
                                                <span class="badge badge-pill badge-danger"><a class="text-white text-decoration-none pop-info"
                                                    data-content="Haz click aquí para ver el perfil del juego" rel="popover" data-placement="bottom" data-trigger="hover" href="{{ route('usuario.juego.show', $post->juego->id) }}">{{$post->juego->nombre}}</a></span>
                                                <span class="badge badge-pill badge-light"><a class="text-dark text-decoration-none pop-info"
                                                    data-content="Haz click aquí para todos los juegos de este género" rel="popover" data-placement="bottom" data-trigger="hover" href="/juegos/lista/{{ $post->juego->genero->id }}">{{$post->juego->genero->nombre}}</a></span>
                                                <span class="badge badge-pill badge-primary text-white">Noticia</span>
                                                <span class="float-right"><i class="far fa-comment-alt"></i> {{ $post->comentarios->count() }}</span>
                                            </div>
                                            <h4>{{ $post->titulo }}</h4>
                                            @php
                                                $resumen = explode('</p>', $post->contenido)
                                            @endphp
                                            <p>{!! $resumen[0] !!}</p>
                                            <form class="mb-3">
                                                <input type="hidden" name="id" value="{{ $post->id }}" />
                                                <a type="submit" class="btn btn-light btn-sm more text-dark font-weight-bold pop-info"
                                                data-content="Haz click aquí para ver la noticia del juego, leer los comentarios y participar en ella" rel="popover" data-placement="bottom" data-trigger="hover">Leer más</a>
                                            </form>
                                            <div class="footer-noticias mt-3">
                                                <small>{{ $post->created_at }}</small>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="col-12 berber">No se han encontrado noticias</div>
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
                        <div class="list-group-item flex-column align-items-start listado-2 analisis-div d-none">
                            <div class="items row mt-4">
                                @if($analisis->count() > 0)
                                    @foreach ($analisis as $post)
                                        <div class="col-12 col-md-6 berber">
                                            <div class="pildoras mb-3">
                                                <span class="badge badge-pill badge-danger"><a class="text-white text-decoration-none pop-info"
                                                    data-content="Haz click aquí para ver el perfil del juego" rel="popover" data-placement="bottom" data-trigger="hover" href="{{ route('usuario.juego.show', $post->juego->id) }}">{{$post->juego->nombre}}</a></span>
                                                <span class="badge badge-pill badge-light"><a class="text-dark text-decoration-none pop-info"
                                                    data-content="Haz click aquí para todos los juegos de este género" rel="popover" data-placement="bottom" data-trigger="hover" href="/juegos/lista/{{ $post->juego->genero->id }}">{{$post->juego->genero->nombre}}</a></span>
                                                <span class="badge badge-pill badge-primary text-white">Análisis</span>
                                                <span class="float-right"><i class="far fa-comment-alt"></i> {{ $post->comentarios->count() }}</span>
                                            </div>
                                            <h4>{{ $post->titulo }}</h4>
                                            @php
                                                $resumen = explode('</p>', $post->contenido)
                                            @endphp
                                            <p>{!! $resumen[0] !!}</p>
                                            <form class="mb-3">
                                                <input type="hidden" name="id" value="{{ $post->id }}" />
                                                <a type="submit" class="btn btn-light btn-sm more text-dark font-weight-bold pop-info"
                                                data-content="Haz click aquí para ver el análisis, leer comentarios y participar en ella" rel="popover" data-placement="bottom" data-trigger="hover">Leer más</a>
                                            </form>
                                            <div class="footer-noticias mt-3">
                                                <small class="text-uppercase font-weight-bold"><a class="text-white text-decoration-none pop-info"
                                                    data-content="Haz click aquí para ver el perfil del Master" rel="popover" data-placement="bottom" data-trigger="hover" href="{{ route('usuario.master.show', $post->master->id) }}">{{ $post->master->nombre }}</a></small>
                                                <small>{{ $post->created_at }}</small>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="col-12 berber">No se han encontrado análisis</div>
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
                </div>
                <div class="col-12 col-md-3 mt-3 mt-md-0">
                    <div class="list-group shadow">
                        <ul class="list-group list-group-horizontal text-center text-uppercase font-weight-bold" style="font-size: .5rem;">
                            <a href="" id="nuevos" class="list-group-item list-group-item-action list-buttons bg-dark text-white pop-info"
                            data-content="Últimos juegos añadidos a la plataforma" rel="popover" data-placement="bottom" data-trigger="hover">Nuevo</a>
                            <a href="" id="ventas" class="list-group-item list-group-item-action list-buttons pop-info"
                            data-content="Los juegos con más ventas" rel="popover" data-placement="bottom" data-trigger="hover">Venta</a>
                            <a href="" id="proximo" class="list-group-item list-group-item-action list-buttons pop-info"
                            data-content="Los juegos que aún no se han lanzado al mercado." rel="popover" data-placement="bottom" data-trigger="hover">Próximo</a>
                        </ul>
                        <a href="/juegos/lista" class="btn btn-danger rounded-0 pop-info"
                        data-content="Haz click aquí para ver todos los juegos y filtrarlos a tu gusto" rel="popover" data-placement="bottom" data-trigger="hover">Ver todos</a>
                        @php
                            $fechaHoy = date('Y-m-d');
                        @endphp
                        @if ($juegos->where('fecha_lanzamiento', '<=', $fechaHoy)->count() > 0)
                            @foreach ($juegos->where('fecha_lanzamiento', '<=', $fechaHoy)->sortByDesc('fecha_lanzamiento')->take(5) as $juego)
                                <a href="{{route('usuario.juego.show', $juego->id)}}" class="list-group-item list-group-item-action flex-column align-items-start listado nuevos">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1"><b>{{$juego->nombre}}</b></h6>
                                        <small>{{$juego->fecha_lanzamiento}}</small>
                                    </div>
                                    <p class="mb-1">{{$juego->desarrolladora->nombre}}</p>
                                    <span class="btn btn-dark btn-sm float-right">{{$juego->precio}} €</span>
                                    <small class="badge badge-danger badge-pill mt-2">{{$juego->genero->nombre}}</small>
                                </a>
                            @endforeach
                        @else
                            <div class="list-group-item">No hay recomendaciones</div>
                        @endif
                        @if ($juegos->count() > 0)
                            @foreach ($juegos->take(5) as $juego)
                                <a href="{{route('usuario.juego.show', $juego->id)}}" class="list-group-item list-group-item-action flex-column align-items-start listado d-none ventas">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1"><b>{{$juego->nombre}}</b></h6>
                                        <small>{{$juego->fecha_lanzamiento}}</small>
                                    </div>
                                    <p class="mb-1">{{$juego->desarrolladora->nombre}}</p>
                                    <span class="btn btn-dark btn-sm float-right">{{$juego->precio}} €</span>
                                    <small class="badge badge-danger badge-pill mt-2">{{$juego->genero->nombre}}</small>
                                </a>
                            @endforeach
                        @else
                            <div class="list-group-item">No hay recomendaciones</div>
                        @endif
                        @if ($juegos->where('fecha_lanzamiento', '>=', $fechaHoy)->count() > 0)
                            @foreach ($juegos->where('fecha_lanzamiento', '>=', $fechaHoy)->sortBy('fecha_lanzamiento')->take(5) as $juego)
                                <a href="{{route('usuario.juego.show', $juego->id)}}" class="list-group-item list-group-item-action flex-column align-items-start listado d-none proximo">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1"><b>{{$juego->nombre}}</b></h6>
                                        <small>{{$juego->fecha_lanzamiento}}</small>
                                    </div>
                                    <p class="mb-1">{{$juego->desarrolladora->nombre}}</p>
                                    <span class="btn btn-dark btn-sm float-right">{{$juego->precio}} €</span>
                                    <small class="badge badge-danger badge-pill mt-2">{{$juego->genero->nombre}}</small>
                                </a>
                            @endforeach
                        @else
                            <div class="list-group-item">No hay recomendaciones</div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="more-div container bg-light p-5 shadow-lg rounded mt-4"></div>
        </div>
    </main>
@endsection

@section('scripts')
    <script>
        $(function() {
            $(".more").on('click', function () {
                let checkUser = false;
                let user = {
                    ban: "{{{ (Auth::user()) ? Auth::user()->ban : 1 }}}",
                    email_verified_at: "{{{ (Auth::user()) ? Auth::user()->email_verified_at : null }}}"
                };
                if(user.ban == 0 && user.email_verified_at != null) {
                    checkUser = true;
                }
                let url = '{{ route("usuario.post.show") }}';
                let id = $(this).prev().val();
                let config = '{{ asset("js/ckeditor/config.js") }}';
                more(url, id, config, checkUser);
            });

            let owl = $('.owl-carousel');

            crearOwl(owl, false, 2, 3, 4);
        });

    </script>
@endsection
