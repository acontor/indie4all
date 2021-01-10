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
                                        <img src="{{ asset('/images/desarrolladoras/' . $juegos->first()->desarrolladora->nombre . '/' . $juegos->first()->nombre . '/' . $juegos->first()->imagen_caratula) }}" alt="{{ $juego->nombre }}">
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
                </div>
            </div>
            <hr class="mt-5 mb-5">
            <div class="row">
                <div class="col-12 col-md-9">
                    <nav class="bg-transparent">
                        <div class="list-group shadow">
                            <ul class="list-group list-group-horizontal text-center text-uppercase font-weight-bold" style="font-size: .5rem;">
                                <a href="" id="noticias" class="list-group-item list-group-item-action list-buttons-2 bg-dark text-white">Últimas noticias</a>
                                <a href="" id="analisis-div" class="list-group-item list-group-item-action list-buttons-2">Análisis</a>
                            </ul>
                            <div class="list-group-item flex-column align-items-start listado-2 noticias">
                                <div class="items mt-4">
                                    @if($posts->where('juego_id', '!=', null)->where('master_id', null)->count() > 0)
                                        @foreach ($posts->where('juego_id', '!=', null)->where('master_id', null) as $post)
                                            <div>
                                                <h4>{{ $post->titulo }}</h4>
                                                <p>{!! $post->contenido !!}</p>
                                                <div class="footer-estados mt-3">
                                                    <small class="text-uppercase font-weight-bold"><a class="text-dark text-decoration-none" href="{{ route('usuario.master.show', $post->master->id) }}">{{ $post->master->nombre }}</a></small>
                                                    <small>{{ $post->created_at }}</small>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <p>No se han encontrado noticias</p>
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
                                            <div class="col-12 col-md-6">
                                                <div class="pildoras mb-3">
                                                    <span class="badge badge-pill badge-danger"><a class="text-white text-decoration-none" href="{{ route('usuario.juego.show', $post->juego->id) }}">{{$post->juego->nombre}}</a></span>
                                                    <span class="badge badge-pill badge-info">{{$post->juego->genero->nombre}}</span>
                                                </div>
                                                <h4>{{ $post->titulo }}</h4>
                                                <p>{!! substr($post->contenido, 0, 300) !!}</p>
                                                <form>
                                                    <input type="hidden" name="id" value="{{ $post->id }}" />
                                                    <a type="submit" class="btn btn-dark btn-sm more">Leer más</a>
                                                </form>
                                                <div class="footer-noticias mt-3">
                                                    <small class="text-uppercase font-weight-bold"><a class="text-dark text-decoration-none" href="{{ route('usuario.master.show', $post->master->id) }}">{{ $post->master->nombre }}</a></small>
                                                    <small>{{ $post->created_at }}</small>
                                                    <span class="float-right"><i class="far fa-comment-alt"></i> {{ $post->comentarios->count() }}</span>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <p>No se han encontrado análisis</p>
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
                    </nav>
                </div>
                <div class="col-12 col-md-3 mt-3 mt-md-0">
                    <nav class="bg-transparent">
                        <div class="list-group shadow">
                            <ul class="list-group list-group-horizontal text-center text-uppercase font-weight-bold" style="font-size: .5rem;">
                                <a href="" id="nuevos" class="list-group-item list-group-item-action list-buttons bg-dark text-white">Nuevo</a>
                                <a href="" id="ventas" class="list-group-item list-group-item-action list-buttons">Venta</a>
                                <a href="" id="proximo" class="list-group-item list-group-item-action list-buttons">Próximo</a>
                            </ul>
                            <a href="/juegos/lista" class="btn btn-danger rounded-0">Ver todos</a>
                            @php
                                $fechaHoy = date('Y-m-d');
                            @endphp
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
                            @foreach ($juegos->where('fecha_lanzamiento', '>=', $fechaHoy)->sortBy('fecha_lanzamiento')->take(5) as $juego)
                                <a href="{{route('usuario.juego.show', $juego->id)}}" class="list-group-item list-group-item-action flex-column align-items-start listado d-none proximo">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1"><b>{{$juego->nombre}}</b></h6>
                                        <small>{{$juego->fecha_lanzamiento}}</small>
                                    </div>
                                    <p class="mb-1">{{$juego->desarrolladora->nombre}}</p>
                                    <span class="btn btn-dark btn-sm float-right">{{$compra->juego->precio}} €</span>
                                    <small class="badge badge-danger badge-pill mt-2">{{$juego->genero->nombre}}</small>
                                </a>
                            @endforeach
                        </div>
                    </nav>
                </div>
            </div>
            <div class="more-div container bg-light p-5 shadow-lg rounded mt-4"></div>
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

            let owl = $('.owl-carousel');

            crearOwl(owl, false, 2, 3, 4);
        });

    </script>
@endsection
