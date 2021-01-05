@extends("layouts.usuario.base")

@section("content")
    @if(Auth::user() && Auth::user()->master()->count() != 0 && Auth::user()->master->posts->where('juego_id', $juego->id)->count() == 0)
        <nav class="navbar navbar-expand-md navbar-dark shadow-sm bg-dark text-light">
            <span class="mx-auto">¿Quieres <a href="{{ route('master.analisis.create', $juego->id) }}">analizar</a> éste juego?</span>
        </nav>
    @endif

    <main class="p-3 pb-5">
        <div class="container bg-light p-3 shadow-lg rounded mt-4">
            <header>
                @if (!$juego->imagen_portada)
                    <img class="img-fluid h-auto" src="{{ url('/images/default.png') }}" style="filter: brightness(0.2)">
                @else
                    <img class="img-fluid h-auto" src="{{ url('/images/juegos/portadas/' . $juego->imagen_portada) }}">
                @endif
                <div class="carousel-caption ">
                    <h1><strong>{{ $juego->nombre }}</strong></h1>
                    <a class="nav-link mb-0" href="{{ route('usuario.desarrolladora.show', $juego->desarrolladora->id) }}"><small>{{ $juego->desarrolladora->nombre }}</small></a>
                    <a class="nav-link mb-0" href="Enlace a todos los juegos con filtro aventura"><small class="badge badge-danger">{{ $juego->genero->nombre }}</small></a>
                </div>
            </header>

            <div class="row mb-5">
                <div class="col-12 col-md-6 mt-5">
                    <h3 class="text-center">Usuarios</h3>
                    <div class="circle mx-auto">
                        -
                        @if (Auth::user() != null && Auth::user()->email_verified_at != null && !Auth::user()->ban)
                            <button class="btn btn-dark btn-circle">-</button>
                        @endif
                    </div>
                </div>
                <div class="col-12 col-md-6 mt-5">
                    <h3 class="text-center">Masters</h3>
                    <div class="circle mx-auto">
                        -
                    </div>
                </div>
            </div>

            <nav id="submenu" class="navbar navbar-expand-md sticky-top navbar-light shadow bg-white mt-4 mb-4 pt-3 pb-3">
                <div class="navbar-nav float-right-sm">
                    <div class="d-flex">
                        @auth
                            @if(Auth::user() && Auth::user()->cm()->count() != 0 && Auth::user()->cm->desarrolladora_id == $juego->desarrolladora_id)
                                <a class="btn btn-primary ml-2" href="{{ route('cm.juego.show', $juego->id) }}"><i class="fas fa-user-edit"></i></a>
                            @else
                                @if (Auth::user()->juegos->where('id', $juego->id)->count() == 0)
                                    <form method="post" action="{{ route('usuario.juego.follow', $juego->id) }}">
                                        @csrf
                                        <button type="submit" class="btn btn-light text-primary mr-2">
                                            <i class="far fa-check-circle"></i>
                                        </button>
                                    </form>
                                @else
                                    <form method="post" action="{{ route('usuario.juego.unfollow', $juego->id) }}">
                                        @csrf
                                        <button type="submit" class="btn btn-light text-danger mr-2">
                                            <i class="far fa-times-circle"></i>
                                        </button>
                                    </form>
                                    @if (Auth::user()->juegos->where('id', $juego->id)->first()->pivot->notificacion == 0)
                                        <form method="post"
                                            action="{{ route('usuario.juego.notificacion', [$juego->id, 1]) }}">
                                            @csrf
                                            <button type="submit" class="btn btn-light text-primary text-primary">
                                                <i class="far fa-bell"></i></i>
                                            </button>
                                        </form>
                                    @else
                                        <form method="post"
                                            action="{{ route('usuario.juego.notificacion', [$juego->id, 0]) }}">
                                            @csrf
                                            <button type="submit" class="btn btn-light text-danger">
                                                <i class="far fa-bell-slash"></i>
                                            </button>
                                        </form>
                                    @endif
                                @endif
                            @endif
                        @endauth
                        <button class="btn btn-warning compartir ml-2"><i class="fas fa-share-alt"></i></button>
                        @auth
                            @if(Auth::user() && Auth::user()->cm()->count() != 0 && Auth::user()->cm->desarrolladora_id != $juego->desarrolladora_id)
                                <a class="btn btn-danger ml-2"><i class="fas fa-exclamation-triangle mt-1" id='reporteJuego'></i></a>
                            @endif
                        @endauth
                    </div>
                </div>
                <button class="navbar-toggler ml-1" type="button" data-toggle="collapse" data-target="#collapsingNavbar">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="navbar-collapse collapse justify-content-between align-items-center w-100" id="collapsingNavbar">
                    <ul class="navbar-nav ml-auto submenu-items">
                        <li class="nav-item"><a class="nav-link" id="general" href="">General</a></li>
                        <li class="nav-item"><a class="nav-link" id="comprar" href="">Comprar</a></li>
                        <li class="nav-item"><a class="nav-link" id="noticias" href="">Noticias</a></li>
                        <li class="nav-item"><a class="nav-link" id="analisis-div" href="">Análisis</a></li>
                    </ul>
                </div>
            </nav>

            <div class="row">
                <div class="col-md-8 mt-4">
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
                            @if ($juego->posts->where('master_id', null)->count() != 0)
                                @foreach ($juego->posts->where('master_id', null) as $post)
                                    <div>
                                        <h4>{{ $post->titulo }}</h4>
                                        <p>{!! $post->contenido !!}</p>
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
                        <div class="analisis-div d-none">
                            <h2>Análisis</h2>
                            @if ($juego->posts->where('master_id', '!=', null)->count() != 0)
                                @foreach ($juego->posts->where('master_id', '!=', null) as $post)
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
                                Aún no se han creado análisis del juego.
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-3 offset-md-1 mt-4">
                    <h2>Recomendaciones</h2>
                    <hr>
                </div>
            </div>


        </div>
    </main>
@endsection

@section("scripts")
    <script src="https://www.google.com/recaptcha/api.js"></script>
    <script>
        $(function() {
            let juego = {!! $juego !!};

            $(".compartir").click(function() {
                Swal.fire({
                    html: `<h2 class="float-left"><strong>Comparte si te gusta</strong></h2><br><hr>` +
                    `<a class="btn btn-primary m-2" href="https://twitter.com/intent/tweet?lang=en&text=He%20descubierto%20el%20juego%20${juego.nombre}%20en%20indie4all.%20¡Échale%20un%20vistazo!?&url=http://127.0.0.1:8000/juego/${juego.id}" target="_blank"><i class="fab fa-twitter fa-2x"></i></a>` +
                    `<a class="btn btn-primary m-2" href="https://www.facebook.com/dialog/share?app_id=242615713953725&display=popup&href=http://127.0.0.1:8000/juego/${juego.id}" target="_blank"><i class="fab fa-facebook-f fa-2x"></i></a>` +
                    `<a class="btn btn-success m-2" href="https://api.whatsapp.com/send?text=He%20descubierto%20el%20juego%20${juego.nombre}%20en%20indie4all.%20¡Échale%20un%20vistazo!%20http://127.0.0.1:8000/juego/${juego.id}" target="_blank"><i class="fab fa-whatsapp fa-2x"></i></a>` +
                    `<hr><div class="input-group"><input type="text" id="input-link" class="form-control" value="http://127.0.0.1:8000/juego/${juego.id}"><button class="btn btn-dark ml-2 copiar">Copiar</button></div>` +
                    `<small class="mt-3 float-left">¡Gracias por compartir!</small>`,
                    showCloseButton: false,
                    showCancelButton: false,
                    showConfirmButton: false,
                    showClass: {
                        popup: 'animate__animated animate__slideInDown'
                    },
                    hideClass: {
                        popup: 'animate__animated animate__zoomOutDown'
                    }
                });
                $(".copiar").click(function() {
                    $("#input-link").select();
                    document.execCommand("copy");
                    $("#input-link").blur();
                });
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
                                    } else {
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
