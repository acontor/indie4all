@extends("layouts.usuario.base")

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/calendar/simple-calendar.css') }}">
@endsection

@section("content")
    <main class="p-3 pb-5">
        <div class="container box mt-4">
            <div class="row">
                <div class="col-12 col-md-8">
                    <div class="list-group shadow">
                        <ul class="list-group list-group-horizontal text-center text-uppercase font-weight-bold" style="font-size: .5rem;">
                            <li class="list-group-item bg-dark text-white">Últimas noticias</li>
                        </ul>
                        <div class="list-group-item flex-column align-items-start noticias">
                            <div class="items row mt-4">
                                @if($posts->count() > 0)
                                    @foreach ($posts->where('titulo', '!=', null)->sortByDesc('created_at') as $post)
                                        <div class="col-12 col-md-6">
                                            @if ($post->master_id != null)
                                                <div class="pildoras mb-3">
                                                    <span class="badge badge-pill badge-danger"><a class="text-white text-decoration-none" href="{{ route('usuario.juego.show', $post->juego->id) }}">{{$post->juego->nombre}}</a></span>
                                                    <span class="badge badge-pill badge-dark"><a class="text-white text-decoration-none" href="/juegos/lista/{{ $post->juego->genero->id }}">{{$post->juego->genero->nombre}}</a></span>
                                                    <span class="badge badge-pill badge-primary text-white">Análisis</span>
                                                </div>
                                            @elseif ($post->juego_id != null && $post->master_id == null)
                                                <div class="pildoras mb-3">
                                                    <span class="badge badge-pill badge-danger"><a class="text-white text-decoration-none" href="{{ route('usuario.juego.show', $post->juego->id) }}">{{$post->juego->nombre}}</a></span>
                                                    <span class="badge badge-pill badge-dark"><a class="text-white text-decoration-none" href="/juegos/lista/{{ $post->juego->genero->id }}">{{$post->juego->genero->nombre}}</a></span>
                                                    <span class="badge badge-pill badge-primary text-white">Noticia</span>
                                                </div>
                                            @elseif ($post->desarrolladora_id != null)
                                                <div class="pildoras mb-3">
                                                    <span class="badge badge-pill badge-primary text-white">Noticia</span>
                                                </div>
                                            @endif
                                            <h4>{{ $post->titulo }}</h4>
                                            <p>{!! substr($post->contenido, 0, 100) !!}</p>
                                            <form>
                                                <input type="hidden" name="id" value="{{ $post->id }}" />
                                                <a type="submit" class="btn btn-dark btn-sm more">Leer más</a>
                                            </form>
                                            <div class="footer-noticias mt-3">
                                                @if ($post->master_id != null && $post->juego_id != null)
                                                    <a class="text-decoration-none text-dark" href="{{ route('usuario.master.show', $post->master->id) }}">{{$post->master->nombre}}</a>
                                                @elseif ($post->juego_id != null && $post->master_id == null)
                                                    <a class="text-decoration-none text-dark" href="{{ route('usuario.desarrolladora.show', $post->juego->desarrolladora->id) }}">{{$post->juego->desarrolladora->nombre}}</a>
                                                @elseif ($post->desarrolladora_id != null)
                                                    <a class="text-decoration-none text-dark" href="{{ route('usuario.desarrolladora.show', $post->desarrolladora->id) }}">{{$post->desarrolladora->nombre}}</a>
                                                @endif
                                                <small>{{ $post->created_at }}</small>
                                                <span class="float-right"><i class="far fa-comment-alt"></i> {{ $post->comentarios->count() }}</span>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <p>No se han encontrado noticias. Sigue a desarrolladoras, masters y juegos para enterarte de las últimas noticias.</p>
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




                <div class="col-12 col-md-4 mt-5 mt-md-0 px-4">
                    <div class="shadow p-4">
                        <h4 class="text-uppercase font-weight-bold">Próximos juegos</h4>
                        <div id="container" class="calendar-container mb-0"></div>
                        <hr class="mb-5">
                        <h4 class="text-uppercase font-weight-bold">Campañas activas</h4>
                        @if ($campanias != '')
                            <div class="list-group shadow">
                                @foreach ($campanias as $campania)
                                    <a href="{{route('usuario.campania.show', $campania->id)}}" class="list-group-item list-group-item-action flex-column align-items-start">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1"><b>{{$campania->juego->nombre}}</b></h6>
                                            <small>{{$campania->fecha_fin}}</small>
                                        </div>
                                        <p class="mb-1">{{$campania->juego->desarrolladora->nombre}}</p>
                                        <span class="btn btn-dark btn-sm float-right">{{$campania->recaudado}} €</span>
                                        <small class="badge badge-danger badge-pill mt-2">{{$campania->juego->genero->nombre}}</small>
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <p>¿Has pensado en participar en alguna <a href="/campanias">campaña</a>?</p>
                        @endif
                        <hr class="mb-5 mt-5">
                        <h4 class="text-uppercase font-weight-bold">Enlaces de interés</h4>
                        <ul class="list-unstyled">
                            <li><a href="{{ route('usuario.cuenta.index', 'compras') }}">Historial de compras</a></li>
                            <li><a href="{{ route('usuario.cuenta.index', 'juegos') }}">Colección de juegos</a></li>
                            <li><a href="{{ route('usuario.cuenta.index', 'masters') }}">Masters seguidos</a></li>
                            <li><a href="{{ route('usuario.cuenta.index', 'desarrolladoras') }}">Desarrolladoras seguidas</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="more-div container bg-light p-5 shadow-lg rounded mt-4"></div>
        </div>
    </main>
@endsection

@section("scripts")
    <script src="{{ asset('js/paginga/paginga.jquery.min.js') }}"></script>
    <script src="{{ asset('js/calendar/jquery.simple-calendar.min.js') }}"></script>
    <script src="{{ asset('js/usuario.js') }}"></script>
    <script>
        $(function () {
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

            let juegos = {!! json_encode($juegos) !!};
            let events = [];

            juegos.forEach(element => {
                events.push({
                    'startDate': element.fecha_lanzamiento,
                    'endDate': element.fecha_lanzamiento,
                    'summary': element.nombre
                })
            });

            $("#container").simpleCalendar({
                months: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                days: ['Domingo', 'Luneas', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
                displayYear:true,
                fixedStartDay: true,
                disableEmptyDetails: true,
                events: events,
            });
        });
    </script>
@endsection
