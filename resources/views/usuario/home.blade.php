@extends("layouts.usuario.base")

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/calendar/simple-calendar.css') }}">
@endsection

@section("content")
    <main class="p-3 pb-5">
        <div class="container box mt-4">
            <div class="row">
                <div class="col-12 col-md-8">
                    <div class="list-group">
                        <ul class="list-group list-group-horizontal text-center text-uppercase font-weight-bold" style="font-size: .5rem;">
                            <a href="" id="juegos" class="list-group-item list-buttons bg-dark text-white text-decoration-none">Noticias juegos</a>
                            <a href="" id="desarrolladoras" class="list-group-item list-buttons text-dark text-decoration-none">Noticias desarrolladoras</a>
                            <a href="" id="masters" class="list-group-item list-buttons text-dark text-decoration-none">Noticias masters</a>
                        </ul>
                        @if($posts->count() > 0)
                            <div class="list-group-item flex-column align-items-start listado masters d-none">
                                <div class="items row mt-4">
                                    @foreach ($posts->where('master_id', '!=', null)->where('juego_id', '!=', null)->sortByDesc('created_at') as $post)
                                        <div class="col-12 berber col-md-6">
                                            <div class="pildoras mb-3">
                                                <span class="badge badge-pill badge-danger"><a class="text-white text-decoration-none" href="{{ route('usuario.juego.show', $post->juego->id) }}">{{$post->juego->nombre}}</a></span>
                                                <span class="badge badge-pill badge-light"><a class="text-dark text-decoration-none" href="http://www.iestrassierra.net/alumnado/curso2021/DAWS/daws2021a1/indie4all/juegos/lista/{{ $post->juego->genero->id }}">{{$post->juego->genero->nombre}}</a></span>
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
                                                <a type="submit" class="btn btn-light btn-sm more text-dark font-weight-bold">Leer más</a>
                                            </form>
                                            <div class="footer-noticias mt-3">
                                                <a class="text-decoration-none text-white" href="{{ route('usuario.master.show', $post->master->id) }}">{{$post->master->nombre}}</a>
                                                <small>{{ $post->created_at }}</small>
                                            </div>
                                        </div>
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
                            <div class="list-group-item flex-column align-items-start listado juegos">
                                <div class="items row mt-4">
                                    @foreach ($posts->where('master_id', null)->where('juego_id', '!=', null)->sortByDesc('created_at') as $post)
                                        <div class="col-12 berber col-md-6">
                                            <div class="pildoras mb-3">
                                                <span class="badge badge-pill badge-danger"><a class="text-white text-decoration-none" href="{{ route('usuario.juego.show', $post->juego->id) }}">{{$post->juego->nombre}}</a></span>
                                                <span class="badge badge-pill badge-light"><a class="text-dark text-decoration-none" href="http://www.iestrassierra.net/alumnado/curso2021/DAWS/daws2021a1/indie4all/juegos/lista/{{ $post->juego->genero->id }}">{{$post->juego->genero->nombre}}</a></span>
                                                <span class="badge badge-pill badge-primary text-white">Noticia</span>
                                                @if ($post->desarrolladora_id != null)
                                                    <span class="badge badge-pill badge-primary text-white">Noticia</span>
                                                @endif
                                                <span class="float-right"><i class="far fa-comment-alt"></i> {{ $post->comentarios->count() }}</span>
                                            </div>
                                            <h4>{{ $post->titulo }}</h4>
                                            @php
                                                $resumen = explode('</p>', $post->contenido)
                                            @endphp
                                            <p>{!! $resumen[0] !!}</p>
                                            <form class="mb-3">
                                                <input type="hidden" name="id" value="{{ $post->id }}" />
                                                <a type="submit" class="btn btn-light btn-sm more text-dark font-weight-bold">Leer más</a>
                                            </form>
                                            <div class="footer-noticias mt-3">
                                                <a class="text-decoration-none text-white" href="{{ route('usuario.desarrolladora.show', $post->juego->desarrolladora->id) }}">{{$post->juego->desarrolladora->nombre}}</a>
                                                @if ($post->desarrolladora_id != null)
                                                    <a class="text-decoration-none text-white" href="{{ route('usuario.desarrolladora.show', $post->desarrolladora->id) }}">{{$post->desarrolladora->nombre}}</a>
                                                @endif
                                                <small>{{ $post->created_at }}</small>
                                            </div>
                                        </div>
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
                            <div class="list-group-item flex-column align-items-start listado desarrolladoras d-none">
                                <div class="items row mt-4">
                                    @foreach ($posts->where('desarrolladora_id', '!=', null)->sortByDesc('created_at') as $post)
                                        <div class="col-12 berber col-md-6">
                                            <div class="pildoras mb-3">
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
                                                <a type="submit" class="btn btn-light btn-sm more text-dark font-weight-bold">Leer más</a>
                                            </form>
                                            <div class="footer-noticias mt-3">
                                                <a class="text-decoration-none text-white" href="{{ route('usuario.desarrolladora.show', $post->desarrolladora->id) }}">{{$post->desarrolladora->nombre}}</a>
                                                <small>{{ $post->created_at }}</small>
                                            </div>
                                        </div>
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
                            <div class="berber mt-4">No se han encontrado noticias. Sigue a desarrolladoras, masters y juegos para enterarte de las últimas noticias.</div>
                        @endif
                    </div>
                </div>
                <div class="col-12 col-md-4 mt-5 mt-md-0 px-4">
                    <div class="shadow p-4">
                        <h4 class="text-uppercase font-weight-bold">Próximos juegos</h4>
                        <div id="container" class="calendar-container mb-0"></div>
                        <hr class="mb-5">
                        <h4 class="text-uppercase font-weight-bold">Campañas activas</h4>
                        @if ($compras != '')
                            <div class="list-group shadow">
                                @foreach ($compras as $compra)
                                    <a href="{{route('usuario.campania.show', $compra->campania->id)}}" class="list-group-item list-group-item-action flex-column align-items-start">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1"><b>{{$compra->campania->juego->nombre}}</b></h6>
                                            <small>{{$compra->campania->fecha_fin}}</small>
                                        </div>
                                        <p class="mb-1">{{$compra->campania->juego->desarrolladora->nombre}}</p>
                                        <span class="btn btn-dark btn-sm float-right">{{$compra->campania->recaudado}} €</span>
                                        <small class="badge badge-danger badge-pill mt-2">{{$compra->campania->juego->genero->nombre}}</small>
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <p>¿Has pensado en participar en alguna <a href="http://www.iestrassierra.net/alumnado/curso2021/DAWS/daws2021a1/indie4all/campanias">campaña</a>?</p>
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
    <script src="{{ asset('js/calendar/jquery.simple-calendar.min.js') }}"></script>
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
