@extends("layouts.usuario.base")

@section('content')
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

    .items > div {
        border: 2px solid rgb(0, 0, 0, 0.1);
        padding: 40px;
    }

    .general > div, .sorteos > div, .encuestas > div {
        border: 2px solid rgb(0, 0, 0, 0.1);
    }

    /* MEDIA MOBILE*/
    small {
        font-size: 10px;
    }

</style>
    <main class="p-3 pb-5">
        <div class="container box mt-4">
            <div class="row mb-4">
                <h3 class="col-12 text-center text-uppercase font-weight-bold">Destacados</h3>
                <div class="col-12 offset-md-2 col-md-8">
                    <div class="owl-carousel 1 mt-3">
                        @foreach ($masters->take('10') as $master)
                            <div class="item m-2 shadow">
                                <a href="{{ route('usuario.master.show', $master->id) }}">
                                    <img src="https://spdc.ulpgc.es/media/ulpgc/images/thumbs/edition-44827-200x256.jpg"
                                        alt="{{ $master->nombre }}">
                                    <div class="carousel-caption mb-5 d-none">
                                        <h6><strong>{{ $master->nombre }}</strong></h6>
                                        <small class="float-left text-left">Seguidores: {{ $master->seguidores->count() }}</small>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <hr class="mt-5 mb-5">
            <div class="row">
                <div class="col-12 col-md-8">
                    <nav class="bg-transparent">
                        <div class="list-group shadow">
                            <ul class="list-group list-group-horizontal text-center text-uppercase font-weight-bold" style="font-size: .5rem;">
                                <a href="" id="estados" class="list-group-item list-group-item-action list-buttons">Estados</a>
                                <a href="" id="analisis-div" class="list-group-item list-group-item-action list-buttons">Análisis</a>
                            </ul>
                            <div class="list-group-item list-group-item-action flex-column align-items-start listado estados">
                                Estados
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
                            <div class="list-group-item list-group-item-action flex-column align-items-start listado analisis-div d-none">
                                Análisis
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
                        </div>
                    </nav>
                </div>
                <div class="col-12 col-md-4">
                    <nav class="bg-transparent">
                        <div class="list-group shadow">
                            <ul class="list-group list-group-horizontal text-center text-uppercase font-weight-bold" style="font-size: .5rem;">
                                <li class="list-group-item w-100">Nuevo</li>
                                <a href="/masters/lista" class="list-group-item list-group-item-action bg-danger text-white">Todos</a>
                            </ul>
                            @php
                                $fechaHoy = date('Y-m-d');
                            @endphp
                            @foreach ($masters->sortByDesc('created_at')->take(5) as $master)
                                <a href="{{route('usuario.master.show', $master->id)}}" class="list-group-item list-group-item-action flex-column align-items-start">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1"><b>{{$master->nombre}}</b></h6>
                                        <small>{{$master->created_at}}</small>
                                    </div>
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






            $('img').addClass('img-fluid');
            $('img').addClass('h-auto');

            var owl = $('.1');

            owl.owlCarousel({
                loop: false,
                margin: 10,
                dots: true,
                responsive: {
                    0: {
                        items: 1
                    },
                    600: {
                        items: 3
                    },
                    1000: {
                        items: 5
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
        });

    </script>
@endsection
