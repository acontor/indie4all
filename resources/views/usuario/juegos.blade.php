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
                    <div class="owl-carousel 1 mt-5">
                        @foreach ($recomendados->take('10') as $juego)
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
                    <div class="mt-4 text-center item">
                        <a href="{{ route('usuario.juego.show', $compras->sortByDesc('ventas')->first()->juego->first()->id) }}">
                            <img class="img-fluid shadow" height="20" src="https://spdc.ulpgc.es/media/ulpgc/images/thumbs/edition-44827-200x256.jpg"
                                alt="{{ $compras->sortByDesc('ventas')->first()->juego->first()->nombre }}">
                            <div class="carousel-caption" style="display: none;">
                                <h6>{{ $compras->sortByDesc('ventas')->first()->juego->first()->nombre }}</h6>
                                <small>
                                    {{ $compras->sortByDesc('ventas')->first()->juego->first()->desarrolladora->nombre }}
                                    <br>
                                    <span class="badge badge-danger">{{ $compras->sortByDesc('ventas')->first()->juego->first()->genero->nombre }}</span>
                                    <br>
                                    {{ $compras->sortByDesc('ventas')->first()->juego->first()->precio }} €
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
                        @if($coleccion->count() == 0)
                            @auth
                                Para obtener noticias personalizadas deberías añadir tus juegos favoritos a tu colección.
                            @endauth
                        @endif
                        @if($coleccion->count() > 0)
                            <a class="btn btn-dark" href="{{ route('usuario.cuenta.index', 'juegos') }}">Colección de juegos</a>
                        @endif
                        <h2>Últimas noticias</h2>
                        <div class="noticias">
                            <div class="items">
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
                    <nav class="sticky-top pt-5 bg-transparent">
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
                            @foreach ($compras->sortByDesc('ventas')->take(5) as $compra)
                                <a href="{{route('usuario.juego.show', $compra->juego->id)}}" class="list-group-item list-group-item-action flex-column align-items-start listado d-none ventas">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1"><b>{{$compra->juego->nombre}}</b></h6>
                                        <small>{{$compra->juego->fecha_lanzamiento}}</small>
                                    </div>
                                    <p class="mb-1">{{$compra->juego->desarrolladora->nombre}}</p>
                                    <span class="btn btn-dark btn-sm float-right">{{$compra->juego->precio}} €</span>
                                    <small class="badge badge-danger badge-pill mt-2">{{$compra->juego->genero->nombre}}</small>
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
                    </header>
                </nav>
            </div>
            <div class="hola container bg-light p-3 shadow-lg rounded mt-4">Hola</div>
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
                $(this).children('a').children('div').fadeToggle(0, "linear");
            }, function() {
                $(this).children('a').children('img').css('filter', 'brightness(1)');
                $(this).children('a').children('div').fadeToggle(0, "linear");
            });

            $(".more").click(function () {
                let url = '{{ route("usuario.juego.post", ":id") }}';
                url = url.replace(':id', $(this).prev().val());
                $.ajax({
                    url: url,
                    data: {
                        id: $(this).prev().val(),
                    },
                    success: function(data) {
                        let html = "<button class='btn btn-light volver'>Volver</button>";
                        html += `<div class='post text-justify'><div class="contenido-post">${data.post.contenido}</p></div><hr><textarea class="form-control" name="mensaje" id="editor"></textarea><button class="btn btn-success mt-3 mb-3" id="mensaje-form">Comentar</button><h4>Comentarios</h4><div class="mensajes">`;
                        if(data.mensajes.length > 0) {
                            data.mensajes.forEach(element => {
                                html += `<div class="alert alert-dark" role="alert">${element.name} <small>${element.created_at}</small><p>${element.contenido}</p></div>`;
                            });
                        } else {
                            html += '<div class="mensaje mt-3">No hay ningún mensaje</div>';
                        }
                        html += '</div></div>';
                        window.scrollTo({top: 100, behavior: 'smooth'});
                        $('.hola').html(html);
                        $('.hola').css('left', 0);
                        /* Swal.fire({
                            title: `<h4><strong>${data.post.titulo}</strong></h4>`,
                            html: html,
                            showCloseButton: false,
                            showCancelButton: false,
                            showConfirmButton: false,
                            width: 1000,
                            showClass: {
                                popup: 'animate__animated animate__slideInDown'
                            },
                            hideClass: {
                                popup: 'animate__animated animate__zoomOutDown'
                            }
                        }); */
                        $('.volver').on('click', function(e) {
                            $('.hola').css('left', -10000);
                        })
                        CKEDITOR.replace("mensaje", {
                            customConfig: "{{ asset('js/ckeditor/config.js') }}"
                        });
                        $("#mensaje-form").click(function(e) {
                            e.preventDefault();
                            let mensaje = CKEDITOR.instances.editor.getData();
                            CKEDITOR.instances.editor.setData("");
                            $.ajax({
                                url: '{{ route("usuario.mensaje.store") }}',
                                type: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                data: {
                                    id: data.post.id,
                                    mensaje: mensaje
                                }, success: function(data) {
                                    if ($('.mensajes').children().text() == "No hay ningún mensaje") {
                                        $('.mensaje').html(`<div class="alert alert-dark" role="alert">${data.autor} <small>${data.created_at}</small><p>${data.contenido}</p></div>`);
                                    } else {
                                        $('.mensajes').append(`<div class="alert alert-dark" role="alert">${data.autor} <small>${data.created_at}</small><p>${data.contenido}</p></div>`);
                                    }
                                }
                            });
                        });
                    }
                });
            });
        });

    </script>
@endsection
