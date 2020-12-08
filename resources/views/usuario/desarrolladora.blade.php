@extends("layouts.usuario.base")

@section("content")
<div class="container p-5">
    <div class="row">
        <div class="col-12 p-0">
            <header>
                @if (!$desarrolladora->imagen_logo)
                    <img class="img-fluid h-auto" src="{{url('/images/default.png')}}">
                @else
                    <img class="img-fluid h-auto" src="{{url('/images/desarrolladoras/' . $desarrolladora->imagen_logo)}}">
                @endif
                <div>
                    <h1 class="font-weight-light">{{ $desarrolladora->nombre }}</h1>
                    <ul class="lead">
                        <li><a href="http://{{ $desarrolladora->url }}" target="blank">{{ $desarrolladora->url }}</a></li>
                        <li>
                            <div class="btn-group mt-3">
                                @if ($usuario == null)
                                    <form action="{{ route('usuario.desarrolladora.follow', $desarrolladora->id) }}" method="post">
                                        @csrf
                                        <button type="submit" class="btn text-primary"><i class="far fa-check-circle"></i></button>
                                    </form>
                                @else
                                    <form action="{{ route('usuario.desarrolladora.unfollow', $desarrolladora->id) }}"
                                        method="post">
                                        @csrf
                                        <button type="submit" class="btn text-danger"><i class="far fa-times-circle"></i></button>
                                    </form>
                                    @if ($usuario->pivot->notificacion == 0)
                                        <form action="{{ route('usuario.desarrolladora.notificacion', [$desarrolladora->id, 1]) }}"
                                            method="post">
                                            @csrf
                                            <button type="submit" class="btn text-primary"><i class="far fa-bell"></i></button>
                                        </form>
                                    @else
                                        <form action="{{ route('usuario.desarrolladora.notificacion', [$desarrolladora->id, 0]) }}"
                                            method="post">
                                            @csrf
                                            <button type="submit" class="btn text-danger"><i class="far fa-bell-slash"></i></button>
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
            <div class="row text-center menu">
                <div class="col-4 col-md-2 offset-md-1"><a id="general" href="">General</a></div>
                <div class="col-4 col-md-2"><a id="noticias" href="">Noticias</a></div>
                <div class="col-4 col-md-2"><a id="sorteos" href="">Sorteos</a></div>
                <div class="col-4 col-md-2"><a id="encuestas" href="">Encuestas</a></div>
                <div class="col-4 col-md-2"><a id="contacto" href="">Contacto</a></div>
            </div>
            <hr>
            <div id="contenido">
                <div class="general">
                    {!! $desarrolladora->contenido !!}
                </div>
                <div class="noticias d-none">
                    <h3>Posts</h3>
                    @if ($desarrolladora->posts->count() != 0)
                        @foreach ($desarrolladora->posts as $post)
                            <div>
                                <h4>{{ $post->titulo }}</h4>
                                <p>{!! $post->contenido !!}</p>
                            </div>
                            <small>Comentarios: {{ $post->mensajes->count() }}</small>
                            <br>
                            <input type="hidden" name="id" value="{{ $post->id }}" />
                            <a type="submit" class="more">Leer más</a>
                        @endforeach
                    @else
                        La desarrolladora aún no ha publicado ningún post.
                    @endif
                </div>
                <div class="sorteos d-none">
                    <h3>Sorteos</h3>
                    <div class="row">
                        @foreach ($desarrolladora->sorteos as $sorteo)
                            <div class="col-12 col-md-6">
                                <h4>{{ $sorteo->titulo }}</h4>
                                <p>{{ $sorteo->descripcion }}</p>
                                <input type="hidden" name="id" value="{{ $sorteo->id }}">
                                <button type="submit" class="participar-sorteo btn btn-success">Participar</button>
                                <p class="mt-3">{{ $sorteo->fecha_fin }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="encuestas d-none">
                    <h3>Encuestas</h3>
                    <div class="row">
                        @foreach ($desarrolladora->encuestas as $encuesta)
                            <div class="col-12 col-md-6">
                                <h4>{{ $encuesta->pregunta }}</h4>
                                @foreach ($encuesta->opciones as $opcion)
                                    <label for="respuesta">{{ $opcion->descripcion }}</label>
                                    <input type="radio" name="respuesta" id="respuesta" value="{{ $opcion->id }}">
                                @endforeach
                                <input type="hidden" name="id" value="{{ $encuesta->id }}">
                                <button type="submit" class="participar-encuesta btn btn-success">Participar</button>
                                <p>{{ $encuesta->fecha_fin }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="contacto d-none">
                    <h3>Contacto</h3>
                    <ul class="lead">
                        <li><a href="http://{{ $desarrolladora->url }}"
                                target="blank">{{ $desarrolladora->url }}</a>
                        </li>
                        <li><a href="mailto:{{ $desarrolladora->email }}"
                                target="blank">{{ $desarrolladora->email }}</a></li>
                        <li>{{ $desarrolladora->direccion }}</li>
                        <li>{{ $desarrolladora->telefono }}</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-3 offset-md-1 box mt-4">
            <h4>Juegos</h4>
            <hr>
            <ul>
                @foreach ($desarrolladora->juegos as $juego)
                    <li><a href="{{ route('usuario.juego.show', $juego->id) }}">{{ $juego->nombre }}</a></li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection
@section("scripts")
    <script src="{{ asset('js/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('js/sweetalert.min.js') }}"></script>
    <script src="https://www.google.com/recaptcha/api.js"></script>
    <script>
        $(function() {
            $(".menu").children("div").children("a").click(function(e) {
                e.preventDefault();
                let item = $(this).attr("id");
                $("#contenido").children("div").addClass("d-none");
                $(`.${item}`).removeClass("d-none");
            });
            $(".more").click(function () {
                let url = '{{ route("usuario.desarrolladora.post", ":id") }}';
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
            $(".participar-sorteo").click(function (e) {
                e.preventDefault();
                let id = $(this).prev().val();
                Swal.fire({
                    title: 'Confirmar Participación',
                    html: '<div id="recaptcha" class="mb-3"></div>',
                    didOpen: function() {
                        grecaptcha.render('recaptcha', {
                                'sitekey': '6Lc2ufwZAAAAAFtjN9fasxuJc0OEf670ruHSTEfP'
                        });
                    },
                    preConfirm: function () {
                        if (grecaptcha.getResponse().length === 0) {
                            Swal.showValidationMessage(`Por favor, verifica que no eres un robot`)
                        } else {
                            $.ajax({
                                url: '{{ route("usuario.desarrolladora.sorteo") }}',
                                type: 'post',
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                data: {
                                    id: id,
                                }
                            });
                        }
                    }
                })
            });
            $(".participar-encuesta").click(function (e) {
                e.preventDefault();
                let encuesta = $(this).prev().val();
                let opcion = $(this).prev().prev().val();
                Swal.fire({
                    title: 'Confirmar Participación',
                    html: '<div id="recaptcha" class="mb-3"></div>',
                    didOpen: function() {
                        grecaptcha.render('recaptcha', {
                                'sitekey': '6Lc2ufwZAAAAAFtjN9fasxuJc0OEf670ruHSTEfP'
                        });
                    },
                    preConfirm: function () {
                        if (grecaptcha.getResponse().length === 0) {
                            Swal.showValidationMessage(`Por favor, verifica que no eres un robot`)
                        } else {
                            $.ajax({
                                url: '{{ route("usuario.desarrolladora.encuesta") }}',
                                type: 'post',
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                data: {
                                    encuesta: encuesta,
                                    opcion: opcion,
                                }
                            });
                        }
                    }
                })
            });
        });

    </script>
@endsection
