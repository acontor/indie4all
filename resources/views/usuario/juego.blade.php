@extends("layouts.usuario.base")

@section("content")
    <div class="container p-5">
        <div class="row">
            <div class="col-12 p-0">
                <header>
                    @if (!$juego->imagen_portada)
                        <img class="img-fluid h-auto" src="{{url('/images/default.png')}}">
                    @else
                        <img class="img-fluid h-auto" src="{{url('/images/juegos/portadas/' . $juego->imagen_portada)}}">
                    @endif
                    <div>
                        <h1 class="font-weight-light">{{ $juego->nombre }}</h1>
                        <ul class="lead">
                            <li>
                                <a href="{{ route('usuario.desarrolladora.show', $juego->desarrolladora->id) }}" target="blank">{{ $juego->desarrolladora->nombre }}</a>
                            </li>
                            <li>
                                <div class="btn-group mt-3">
                                    @if ($usuario == null)
                                        <form method="post" action="{{ route('usuario.juego.follow', $juego->id) }}">
                                            @csrf
                                            <button type="submit" class="btn text-primary">
                                                <i class="far fa-check-circle"></i>
                                            </button>
                                        </form>
                                    @else
                                        <form method="post" action="{{ route('usuario.juego.unfollow', $juego->id) }}">
                                            @csrf
                                            <button type="submit" class="btn text-danger">
                                                <i class="far fa-times-circle"></i>
                                            </button>
                                        </form>
                                        @if ($usuario->pivot->notificacion == 0)
                                            <form method="post"
                                                action="{{ route('usuario.juego.notificacion', [$juego->id, 1]) }}">
                                                @csrf
                                                <button type="submit" class="btn text-primary text-primary">
                                                    <i class="far fa-bell"></i></i>
                                                </button>
                                            </form>
                                        @else
                                            <form method="post"
                                                action="{{ route('usuario.juego.notificacion', [$juego->id, 0]) }}">
                                                @csrf
                                                <button type="submit" class="btn text-danger">
                                                    <i class="far fa-bell-slash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    @endif
                                </div>
                            </li>
                        </ul>
                    </div>
                </header>
            </div>
            <div class="col-md-8 box mt-4">
                <div class="row menu tex-center">
                    <div class="col-3"><a id="general" href="">General</a></div>
                    <div class="col-3"><a id="comprar" href="">Comprar</a></div>
                    <div class="col-3"><a id="noticias" href="">Noticias</a></div>
                    <div class="col-3"><a id="analisis" href="">Análisis</a></div>
                </div>
                <hr>
                <div id="contenido">
                    <div class="general">
                        <h2>General</h2>
                        Contenido que quiera la desarrolladora.
                        Hay que crear un atributo en la tabla juegos llamado contenido.
                    </div>
                    <div class="comprar d-none">
                        <h2>Comprar</h2>
                    </div>
                    <div class="noticias d-none">
                        <h2>Noticias</h2>
                        @if ($juego->posts->count() != 0)
                            @foreach ($juego->posts as $post)
                                <div>
                                    <h4>{{ $post->titulo }}</h4>
                                    <p>{{ $post->contenido }}</p>
                                </div>
                                <small>Comentarios: {{ $post->mensajes->count() }}</small>
                                <form>
                                    <input type="hidden" name="id" value="{{ $post->id }}" />
                                    <a type="submit" class="more">Leer más</a>
                                </form>
                            @endforeach
                        @else
                            Aún no ha publicado ninguna actualización.
                        @endif
                    </div>
                    <div class="analisis d-none">
                        <h2>Análisis</h2>
                        @if ($juego->posts->count() != 0)
                            @foreach ($juego->posts as $post)
                                <div>
                                    <h4>{{ $post->titulo }}</h4>
                                    <p>{{ $post->contenido }}</p>
                                </div>
                            @endforeach
                        @else
                            Aún no se han creado análisis del juego.
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-3 offset-md-1 box mt-4">
                <h4>Recomendaciones</h4>
                <hr>
            </div>
        </div>
    </div>
@endsection
@section("scripts")
    <script src="https://cdn.ckeditor.com/4.15.0/standard/ckeditor.js"></script>
    <script src="{{ asset('js/sweetalert.min.js') }}"></script>
    <script>
        $(function() {
            $(".menu").children("div").children("a").click(function(e) {
                e.preventDefault();
                let item = $(this).attr("id");
                $("#contenido").children("div").addClass("d-none");
                $(`.${item}`).removeClass("d-none");
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
                        let html = `<div class='post text-justify'><div class="contenido-post">${data.post.contenido}</p></div><hr><textarea class="form-control" name="mensaje" id="editor"></textarea><button class="btn btn-success mt-3 mb-3" id="mensaje-form">Comentar</button><h4>Comentarios</h4><div class="mensajes">`;
                        if(data.mensajes.length > 0) {
                            data.mensajes.forEach(element => {
                                html += `<div class="alert alert-dark" role="alert">${element.name} <small>${element.created_at}</small><p>${element.contenido}</p></div>`;
                            });
                        } else {
                            html += '<div class="mensaje mt-3">No hay ningún mensaje</div>';
                        }
                        html += '</div></div>';
                        Swal.fire({
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
                        });
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
