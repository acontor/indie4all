@extends("layouts.usuario.base")

@section('content')
    <main class="p-3 pb-5">
        <div class="container box mt-4">
            <div class="row mb-4">
                <h3 class="col-12 text-center text-uppercase font-weight-bold">Destacados</h3>
                <div class="col-12 offset-md-2 col-md-8">
                    <div class="owl-carousel owl-theme mt-3">
                        @foreach ($masters->take('10') as $master)
                            <div class="item m-2 shadow">
                                <a href="{{ route('usuario.master.show', $master->id) }}">
                                    @if ($master->imagen_logo != null)
                                        <img class="img-fluid" src="{{ asset('/images/masters/' . $master->nombre . '/' . $master->imagen_logo) }}" alt="{{ $master->nombre }}">
                                    @else
                                        <img class="img-fluid" src="{{ asset('/images/masters/default-logo.png') }}" alt="{{ $master->nombre }}">
                                    @endif
                                    <div class="carousel-caption mb-2 d-none">
                                        <h6><strong>{{ $master->nombre }}</strong></h6>
                                        <small>Seguidores: {{ $master->seguidores_count }}</small>
                                        <small>Actividad: {{ $master->posts_count }}</small>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <hr class="mt-5 mb-5">
            <div class="row">
                <div class="col-12 col-md-9">
                    <div class="list-group">
                        <ul class="list-group list-group-horizontal text-center text-uppercase font-weight-bold" style="font-size: .5rem;">
                            <a href="" id="estados" class="list-group-item list-buttons bg-dark text-white text-decoration-none pop-info"
                            data-content="Muestra los estados de todos los Masters de la plataforma"
                            rel="popover" data-placement="bottom" data-trigger="hover">Estados</a>
                            <a href="" id="analisis-div" class="list-group-item list-buttons text-dark text-decoration-none pop-info"
                            data-content="Muestra los análisis de todos los Masters de la plataforma" rel="popover" data-placement="bottom" data-trigger="hover">Análisis</a>
                        </ul>
                        <div class="list-group-item flex-column align-items-start listado estados">
                            <div class="items mt-4">
                                @if($posts->where('juego_id', null)->count() > 0)
                                    @foreach ($posts->where('juego_id', null) as $post)
                                        <div class="berber">
                                            <h4>{{ $post->titulo }}</h4>
                                            <p>{!! $post->contenido !!}</p>
                                            <div class="footer-estados mt-3">
                                                <small class="text-uppercase font-weight-bold"><a class="text-white text-decoration-none" href="{{ route('usuario.master.show', $post->master->id) }}">{{ $post->master->nombre }}</a></small>
                                                <small>{{ $post->created_at }}</small>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="col-12 berber">No se han encontrado estados</div>
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
                        <div class="list-group-item flex-column align-items-start listado analisis-div d-none">
                            <div class="items row mt-4">
                                @if($posts->where('juego_id', '!=', null)->count() > 0)
                                    @foreach ($posts->where('juego_id', '!=', null) as $post)
                                        <div class="col-12 berber col-md-6">
                                            <div class="pildoras mb-3">
                                                <span class="badge badge-pill badge-danger"><a class="text-white text-decoration-none pop-info"
                                                    data-content="Haz click aquí para ir a la página del juego" rel="popover" data-placement="bottom" data-trigger="hover"
                                                    href="{{ route('usuario.juego.show', $post->juego->id) }}">{{$post->juego->nombre}}</a></span>
                                                <span class="badge badge-pill badge-light"><a class="text-dark text-decoration-none pop-info"
                                                    data-content="Haz click aquí para ver todos los juegos de este género" rel="popover" data-placement="bottom" data-trigger="hover"
                                                    href="http://www.iestrassierra.net/alumnado/curso2021/DAWS/daws2021a1/indie4all/juegos/lista/{{ $post->juego->genero->id }}">{{$post->juego->genero->nombre}}</a></span>
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
                                                data-content="Haz click aquí para ver el análisis, leer los comentarios y poder participar en el" rel="popover" data-placement="bottom" data-trigger="hover">Leer más</a>
                                            </form>
                                            <div class="footer-noticias">
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
                            <li class="list-group-item w-100 bg-dark text-white">Nuevo</li>
                            <a href="http://www.iestrassierra.net/alumnado/curso2021/DAWS/daws2021a1/indie4all/masters/lista" class="list-group-item list-group-item-action bg-danger text-white pop-info"
                            data-content="Haz click aquí para ver todos los Masters y filtralos a tu gusto" rel="popover" data-placement="bottom" data-trigger="hover">Todos</a>
                        </ul>
                        @if ($masters->count() > 0)
                            @foreach ($masters->sortByDesc('created_at')->take(5) as $master)
                                <a href="{{route('usuario.master.show', $master->id)}}" class="list-group-item list-group-item-action flex-column align-items-start">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1"><b>{{$master->nombre}}</b></h6>
                                        <small>{{$master->created_at}}</small>
                                    </div>
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

            $('img').addClass('img-fluid');
            $('img').addClass('h-auto');
        });

    </script>
@endsection
