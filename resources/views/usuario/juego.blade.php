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
                                    @auth
                                        @if (Auth::user()->juegos->where('id', $juego->id)->count() == 0)
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
                                            @if (Auth::user()->juegos->where('id', $juego->id)->first()->pivot->notificacion == 0)
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
                                    @endauth
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
                    <div class="col-2"><a id="analisis" href="">Análisis</a></div>
                    @auth
                    <div class="float-right">
                        <a class="text-danger"><i class="fas fa-exclamation-triangle" id='reporteJuego'></i></a>
                    </div>
                    @endauth
                </div>
                <hr>
                <div id="contenido">
                    <div class="general">
                        <h2>General</h2>
                        {!! $juego->contenido !!}
                    </div>
                    <div class="comprar d-none">
                        <h2>Comprar</h2>
                        @auth
                        <form action="{{ route('usuario.paypal.pagar') }}" method="post">
                            @csrf
                            @method('POST')
                            <p>Stock: {{$juego->claves->count()}}</p>
                            <p>El precio es de {{ $juego->precio }}</p>
                            @if($juego->claves->count() > 0)
                            <input type="hidden" name="tipo" value="0" />
                            <input type="hidden" name="precio" value="{{ $juego->precio }}">
                            <input type="hidden" name="juegoId" value="{{ $juego->id }}">
                            <button type="submit" class="btn btn-primary"> Pagar con Paypal</button>
                            @else
                            <p class="text-danger">No hay stock en estos momentos</p>
                            @endif
                        </form>
                        @else
                        <p>Tienes que estar registrado para comprar.</p>
                        @endauth
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
                let url = '{{ route("usuario.juego.post", ":id") }}';
                url = url.replace(':id', $(this).prev().val());
                $.ajax({
                    url: url,
                    data: {
                        id: $(this).prev().val(),
                    },
                    success: function(data) {
                        let html = `<div class='post text-justify'><div class="contenido-post">${data.post.contenido}</p><input id="idPost" type="hidden" value="${data.post.id}"><a class="text-danger"><i class="fas fa-exclamation-triangle" id='reportePost'></i></a></div><hr><textarea class="form-control" name="mensaje" id="editor"></textarea><button class="btn btn-success mt-3 mb-3" id="mensaje-form">Comentar</button><h4>Comentarios</h4><div class="mensajes">`;
                        if(data.mensajes.length > 0) {
                            data.mensajes.forEach(element => {
                                html += `<div class="alert alert-dark" role="alert">${element.name} <small>${element.created_at}</small><input type="hidden" value="${element.id}"><a name="${element.id}asd" class="text-danger float-right"><i class="fas fa-exclamation-triangle" name='reportarMensaje'></i></a><p>${element.contenido}</p></div>`;
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
                        $('#reportePost').click(function(){
                            let postId =  $('#idPost').val();
                            console.log(postId)
                            let url = '{{ route("usuario.reporte", [":id" , "post_id"]) }}';
                            url = url.replace(':id', postId);
                            Swal.fire({
                                title: 'Indica el motivo del reporte',
                                showCancelButton: true,
                                cancelButtonText: 'Cancelar',
                                confirmButtonText: `Reportar`,
                                input: 'text',
                                inputAttributes: {
                                    autocapitalize: 'off'
                                },
                                html: '<div id="recaptcha" class="mb-3"></div>',
                                didOpen: function() {
                                    grecaptcha.render('recaptcha', {
                                            'sitekey': '6Lc2ufwZAAAAAFtjN9fasxuJc0OEf670ruHSTEfP'
                                    });
                                },
                                preConfirm: function (result) {
                                    if (grecaptcha.getResponse().length === 0) {
                                        Swal.showValidationMessage(`Por favor, verifica que no eres un robot`)
                                    } else if (result != '') {
                                        let motivo = result;
                                        $.ajax({
                                            url: url,
                                            type : 'POST',
                                            headers:{
                                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                            },
                                            data: {
                                                motivo: motivo,
                                            }
                                            ,success: function(data){
                                                Swal.fire(data)
                                            }
                                        })
                                    }else{
                                        Swal.showValidationMessage(`Por favor, indica un motivo.`)
                                    }
                                }
                            })
                        })
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
                        $('i[name ="reportarMensaje"]').click(function(){
                            let mensajeId =  $(this).parent().prev().val();
                            console.log(mensajeId)
                            let url = '{{ route("usuario.reporte", [":id" , "mensaje_id"]) }}';
                            url = url.replace(':id', mensajeId);
                            Swal.fire({
                                title: 'Indica el motivo del reporte',
                                showCancelButton: true,
                                cancelButtonText: 'Cancelar',
                                confirmButtonText: `Reportar`,
                                input: 'text',
                                inputAttributes: {
                                    autocapitalize: 'off'
                                },
                                html: '<div id="recaptcha" class="mb-3"></div>',
                                didOpen: function() {
                                    grecaptcha.render('recaptcha', {
                                            'sitekey': '6Lc2ufwZAAAAAFtjN9fasxuJc0OEf670ruHSTEfP'
                                    });
                                },
                                preConfirm: function (result) {
                                    console.log(result)
                                    if (grecaptcha.getResponse().length === 0) {
                                        Swal.showValidationMessage(`Por favor, verifica que no eres un robot`)
                                    } else if (result != '') {
                                        let motivo = result;
                                        $.ajax({
                                            url: url,
                                            type : 'POST',
                                            headers:{
                                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                            },
                                            data: {
                                                motivo: motivo,
                                            }
                                            ,success: function(data){
                                                Swal.fire(data)
                                            }
                                        })
                                    }else{
                                        Swal.showValidationMessage(`Por favor, indica un motivo.`)
                                    }
                                }
                            })
                        })
                    }
                });
            });
            $('#reporteJuego').click(function(){
            let juegoId = {!! $juego->id !!}
            let url = '{{ route("usuario.reporte", [":id" , "juego_id"]) }}';
            url = url.replace(':id', juegoId);
            Swal.fire({
                title: 'Indica el motivo del reporte',
                showCancelButton: true,
                cancelButtonText: 'Cancelar',
                confirmButtonText: `Reportar`,
                input: 'text',
                inputAttributes: {
                    autocapitalize: 'off'
                },
                html: '<div id="recaptcha" class="mb-3"></div>',
                didOpen: function() {
                    grecaptcha.render('recaptcha', {
                            'sitekey': '6Lc2ufwZAAAAAFtjN9fasxuJc0OEf670ruHSTEfP'
                    });
                },
                preConfirm: function (result) {
                    if (grecaptcha.getResponse().length === 0) {
                        Swal.showValidationMessage(`Por favor, verifica que no eres un robot`)
                    } else if (result != '') {
                        let motivo = result;
                        $.ajax({
                            url: url,
                            type : 'POST',
                            headers:{
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            },
                            data: {
                                motivo: motivo,
                            }
                            ,success: function(data){
                                Swal.fire(data)
                            }
                        })
                    }else{
                        Swal.showValidationMessage(`Por favor, indica un motivo.`)
                    }
                }
            })
        })
    });

    </script>
@endsection
