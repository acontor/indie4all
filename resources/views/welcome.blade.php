@extends("layouts.usuario.base")

@section("content")
    <main class="p-3 pb-5">
        <div class="container box mt-4">
            <div class="row">
                <div class="col-12 col-md-8">
                    <div class="list-group">
                        <ul class="list-group list-group-horizontal text-center text-uppercase font-weight-bold" style="font-size: .5rem;">
                            <li class="list-group-item bg-dark text-white">Noticias generales</li>
                        </ul>
                        <div class="list-group-item flex-column align-items-start noticias">
                            <div class="items row mt-4">
                                @if($noticias->count() > 0)
                                    @foreach ($noticias as $post)
                                        <div class="col-12 berber">
                                            <div class="pildoras mb-3">
                                                <span class="badge badge-pill badge-primary text-white">Administración</span>
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
                                            <div class="footer-noticias">
                                                <small>{{ $post->created_at }}</small>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="col-12 berber">No se han publicado noticias.</div>
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
                    <h5 class="font-weight-bold text-uppercase">Juegos</h5>
                    <div class="list-group shadow">
                        <ul class="list-group list-group-horizontal text-center text-uppercase font-weight-bold" style="font-size: .5rem;">
                            <a href="" id="nuevos-juegos" class="list-group-item list-group-item-action list-buttons-juegos bg-dark text-white">Nuevo</a>
                            <a href="" id="tops-juegos" class="list-group-item list-group-item-action list-buttons-juegos">Tops</a>
                            <a href="" id="proximo-juegos" class="list-group-item list-group-item-action list-buttons-juegos">Próximo</a>
                        </ul>
                        <a href="/juegos/lista" class="btn btn-danger rounded-0">Ver todos</a>
                        @php
                            $fechaHoy = date('Y-m-d');
                        @endphp
                        @foreach ($juegos->where('fecha_lanzamiento', '<=', $fechaHoy)->sortByDesc('fecha_lanzamiento') as $juego)
                            <a href="{{route('usuario.juego.show', $juego->id)}}" class="list-group-item list-group-item-action flex-column align-items-start listado-juegos nuevos-juegos">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1"><b>{{$juego->nombre}}</b></h6>
                                    <small>{{$juego->fecha_lanzamiento}}</small>
                                </div>
                                <p class="mb-1">{{$juego->desarrolladora->nombre}}</p>
                                <span class="btn btn-dark btn-sm float-right">{{$juego->precio}} €</span>
                                <small class="badge badge-danger badge-pill mt-2">{{$juego->genero->nombre}}</small>
                            </a>
                        @endforeach
                        @foreach ($juegosVentas as $juego)
                            <a href="{{route('usuario.juego.show', $juego->id)}}" class="list-group-item list-group-item-action flex-column align-items-start listado-juegos d-none tops-juegos">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1"><b>{{$juego->nombre}}</b></h6>
                                    <small>{{$juego->fecha_lanzamiento}}</small>
                                </div>
                                <p class="mb-1">{{$juego->desarrolladora->nombre}}</p>
                                <span class="btn btn-dark btn-sm float-right">{{$juego->precio}} €</span>
                                <small class="badge badge-danger badge-pill mt-2">{{$juego->genero->nombre}}</small>
                            </a>
                        @endforeach
                        @if ($juegos->where('fecha_lanzamiento', '>=', $fechaHoy)->count() > 0)
                            @foreach ($juegos->where('fecha_lanzamiento', '>=', $fechaHoy)->sortBy('fecha_lanzamiento') as $juego)
                                <a href="{{route('usuario.juego.show', $juego->id)}}" class="list-group-item list-group-item-action flex-column align-items-start listado-juegos d-none proximo-juegos">
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
                            <div class="list-group-item flex-column align-items-start listado-juegos proximo-juegos d-none">
                                No hay ningún lanzamiento anunciado
                            </div>
                        @endif
                    </div>

                    <h5 class="font-weight-bold text-uppercase mt-4">Campañas</h5>
                    <div class="list-group shadow">
                        <ul class="list-group list-group-horizontal text-center text-uppercase font-weight-bold" style="font-size: .5rem;">
                            <a href="" id="nuevos-campanias" class="list-group-item list-group-item-action list-buttons-campanias bg-dark text-white">Nuevo</a>
                            <a href="" id="tops-campanias" class="list-group-item list-group-item-action list-buttons-campanias">Tops</a>
                            <a href="" id="proximo-campanias" class="list-group-item list-group-item-action list-buttons-campanias">Próximo</a>
                        </ul>
                        <a href="/campanias/lista" class="btn btn-danger rounded-0">Ver todos</a>
                        @php
                            $fechaHoy = date('Y-m-d');
                        @endphp
                        @if($campanias->where('fecha_fin', '>', $fechaHoy)->count() > 0)
                            @foreach ($campanias->where('fecha_fin', '>', $fechaHoy)->sortBy('created_at') as $campania)
                                <a href="{{route('usuario.campania.show', $campania->id)}}" class="list-group-item list-group-item-action flex-column align-items-start listado-campanias nuevos-campanias">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1"><b>{{$campania->juego->nombre}}</b></h6>
                                        <small>{{$campania->fecha_fin}}</small>
                                    </div>
                                    <p class="mb-1">{{$campania->nombre}}</p>
                                    <span class="btn btn-dark btn-sm float-right">{{$campania->meta}} €</span>
                                    <small class="badge badge-danger badge-pill mt-2">{{$campania->juego->genero->nombre}}</small>
                                </a>
                            @endforeach
                        @else
                            <div class="list-group-item flex-column align-items-start listado-campanias nuevos-campanias">
                                No hay ninguna campaña activa
                            </div>
                        @endif
                        @if($campaniasVentas->where('fecha_fin', '>', $fechaHoy)->count() > 0)
                            @foreach ($campaniasVentas->where('fecha_fin', '>', $fechaHoy) as $campania)
                                <a href="{{route('usuario.campania.show', $campania->id)}}" class="list-group-item list-group-item-action flex-column align-items-start listado-campanias d-none tops-campanias">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1"><b>{{$campania->juego->nombre}}</b></h6>
                                        <small>{{$campania->fecha_fin}}</small>
                                    </div>
                                    <p class="mb-1">{{$campania->juego->desarrolladora->nombre}}</p>
                                    <span class="btn btn-dark btn-sm float-right">{{$campania->recaudado}} €</span>
                                    <small class="badge badge-danger badge-pill mt-2">{{$campania->juego->genero->nombre}}</small>
                                </a>
                            @endforeach
                        @else
                            <div class="list-group-item flex-column align-items-start listado-campanias tops-campanias d-none">
                                No hay ninguna campaña activa
                            </div>
                        @endif
                        @if($campanias->where('fecha_fin', '>', $fechaHoy)->count() > 0)
                            @foreach ($campanias->where('fecha_fin', '>=', $fechaHoy)->sortBy('fecha_fin') as $campania)
                                <a href="{{route('usuario.campania.show', $campania->id)}}" class="list-group-item list-group-item-action flex-column align-items-start listado-campanias d-none proximo-campanias">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1"><b>{{$campania->juego->nombre}}</b></h6>
                                        <small>{{$campania->fecha_fin}}</small>
                                    </div>
                                    <p class="mb-1">{{$campania->juego->desarrolladora->nombre}}</p>
                                    <span class="btn btn-dark btn-sm float-right">{{$campania->meta}} €</span>
                                    <small class="badge badge-danger badge-pill mt-2">{{$campania->juego->genero->nombre}}</small>
                                </a>
                            @endforeach
                        @else
                            <div class="list-group-item flex-column align-items-start listado-campanias proximo-campanias d-none">
                                No hay ninguna campaña activa
                            </div>
                        @endif
                    </div>

                    <h5 class="font-weight-bold text-uppercase mt-4">Masters</h5>
                    <div class="list-group shadow">
                        <ul class="list-group list-group-horizontal text-center text-uppercase font-weight-bold" style="font-size: .5rem;">
                            <a href="" id="nuevos-masters" class="list-group-item list-group-item-action list-buttons-masters bg-dark text-white">Nuevo</a>
                            <a href="" id="tops-masters" class="list-group-item list-group-item-action list-buttons-masters">Top</a>
                        </ul>
                        <a href="/masters/lista" class="btn btn-danger rounded-0">Ver todos</a>
                        @php
                            $fechaHoy = date('Y-m-d');
                        @endphp
                        @foreach ($masters->sortByDesc('created_at') as $master)
                            @if ($master->usuario->ban != 1)
                                <a href="{{route('usuario.master.show', $master->id)}}" class="list-group-item list-group-item-action flex-column align-items-start listado-masters nuevos-masters">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1"><b>{{$master->nombre}}</b></h6>
                                        <small>{{$master->created_at}}</small>
                                    </div>
                                </a>
                            @endif
                        @endforeach
                        @foreach ($masters as $master)
                            @if ($master->usuario->ban != 1)
                                <a href="{{route('usuario.master.show', $master->id)}}" class="list-group-item list-group-item-action flex-column align-items-start listado-masters tops-masters d-none">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1"><b>{{$master->nombre}}</b></h6>
                                        <small>{{$master->created_at}}</small>
                                    </div>
                                </a>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="more-div container bg-light p-5 shadow-lg rounded mt-4"></div>
        </div>
    </main>
@endsection

@section("scripts")
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
