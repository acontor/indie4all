@extends("layouts.usuario.base")

@section('styles')
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

</style>
@endsection

@section('content')
    <main class="p-3 pb-5">
        <div class="container box mt-4">
            <div class="row mb-4">
                <div class="col-12 col-md-8">
                    <h3 class="ml-3 text-uppercase font-weight-bold">Recomendaciones</h3>
                    <div class="owl-carousel owl-loop mt-5">
                        @foreach ($recomendados->take('10') as $juego)
                            <div class="item m-2 shadow">
                                <a href="{{ route('usuario.juego.show', $juego->id) }}">
                                    <img src="https://spdc.ulpgc.es/media/ulpgc/images/thumbs/edition-44827-200x256.jpg"
                                        alt="{{ $juego->nombre }}">
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
                            <img class="img-fluid shadow" height="20" src="https://spdc.ulpgc.es/media/ulpgc/images/thumbs/edition-44827-200x256.jpg"
                                alt="{{ $juegos->first()->nombre }}">
                            <div class="carousel-caption d-none">
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
            <hr class="mt-5">
            <div class="row">
                <div class="col-12 col-md-8 pt-5">
                    <div class="shadow p-3">
                        <h2>Últimas noticias
                            @if($coleccion && $coleccion->count() > 0)
                                <a class="btn btn-dark float-right" href="{{ route('usuario.cuenta.index', 'juegos') }}">Colección de juegos</a>
                            @endif
                        </h2>
                        @if($coleccion && $coleccion->count() == 0)
                            @auth
                                <small>Para obtener noticias personalizadas deberías añadir tus juegos favoritos a tu colección.</small>
                            @endauth
                        @endif
                        <div class="noticias">
                            <div class="items">
                                @if($posts->count() == 0)
                                    No existen noticias aún.
                                @else
                                    @foreach ($posts->where('master_id', null)->sortByDesc('created_at') as $post)
                                        <div>
                                            <h4>{{ $post->titulo }} <small>{{ $post->created_at }}</small></h4>
                                            <p>{!! substr($post->contenido, 0, 300) !!}</p>
                                            <form>
                                                <input type="hidden" name="id" value="{{ $post->id }}" />
                                                <a type="submit" class="more">Leer más</a>
                                            </form>
                                        </div>
                                    @endforeach
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
                <div class="col-12 col-md-4 mt-5 mt-md-0">
                    <nav class="pt-5 bg-transparent">
                        <div class="list-group shadow">
                            <ul class="list-group list-group-horizontal text-center text-uppercase font-weight-bold" style="font-size: .5rem;">
                                <a href="" id="nuevos" class="list-group-item list-group-item-action list-buttons">Nuevo</a>
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
        });

    </script>
@endsection
