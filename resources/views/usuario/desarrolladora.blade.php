@extends("layouts.usuario.base")

@section("content")




    <main class="p-3 pb-5">
        <div class="container bg-light p-3 shadow-lg rounded mt-4">
            <header>
                @if (!$desarrolladora->imagen_portada)
                    <img class="img-fluid h-auto" src="{{ url('/images/default.png') }}" style="filter: brightness(0.2)">
                @else
                    <img class="img-fluid h-auto" src="{{ url('/images/desarrolladoras/portadas/' . $desarrolladora->imagen_portada) }}">
                @endif
                <div class="carousel-caption ">
                    <h1><strong>{{ $desarrolladora->nombre }}</strong></h1>
                    <small>{{ $desarrolladora->direccion }}</small>
                    <br>
                    <small>{{ $desarrolladora->email }}</small>
                    <br>
                    <small>{{ $desarrolladora->telefono }}</small>
                </div>
            </header>



            <nav id="submenu" class="navbar navbar-expand-md sticky-top navbar-light shadow bg-white mt-4 mb-4 pt-3 pb-3">
                <div class="navbar-nav float-right-sm">
                    <div class="d-flex">
                        @auth
                            @if(Auth::user() && Auth::user()->cm()->count() != 0 && Auth::user()->cm->desarrolladora_id == $desarrolladora->id)
                                <a class="btn btn-primary ml-2" href="{{ route('cm.desarrolladora.index') }}"><i class="fas fa-user-edit"></i></a>
                            @else
                                @auth
                                    @if (Auth::user()->desarrolladoras->where('id', $desarrolladora->id)->count() == 0)
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
                                        @if (Auth::user()->desarrolladoras->where('id', $desarrolladora->id)->first()->pivot->notificacion == 0)
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
                                @endauth
                            @endif
                        @endauth
                        <button class="btn btn-warning compartir ml-2"><i class="fas fa-share-alt"></i></button>
                        @auth
                            @if(Auth::user() && Auth::user()->cm()->count() != 0 && Auth::user()->cm->desarrolladora_id != $desarrolladora->id)
                                <a class="btn btn-danger ml-2"><i class="fas fa-exclamation-triangle mt-1" id='reporteDesarrolladora'></i></a>
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
                        <li class="nav-item"><a class="nav-link" id="noticias" href="">Noticias</a></li>
                        <li class="nav-item"><a class="nav-link" id="sorteos" href="">Sorteos</a></li>
                        <li class="nav-item"><a class="nav-link" id="encuestas" href="">Encuestas</a></li>
                        <li class="nav-item"><a class="nav-link" id="contacto" href="">Contacto</a></li>
                    </ul>
                </div>
            </nav>



            <div class="row">
                <div class="col-md-8 mt-4">
                    <div id="contenido">
                        <div class="general">
                            {!! $desarrolladora->contenido !!}
                        </div>
                        <div class="noticias d-none">
                            @if ($desarrolladora->posts->count() != 0)
                                <div class="items">
                                    @foreach ($desarrolladora->posts as $post)
                                        <div>
                                            <h4>{{ $post->titulo }}</h4>
                                            <p>{!! $post->contenido !!}</p>
                                            <small>Comentarios: {{ $post->mensajes->count() }}</small>
                                            <br>
                                            <input type="hidden" name="id" value="{{ $post->id }}" />
                                            <a type="submit" class="more">Leer más</a>
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
                            @else
                                La desarrolladora aún no ha publicado ningún post.
                            @endif
                        </div>
                        <div class="sorteos d-none">
                            <h3>Sorteos</h3>
                            <div class="row">
                                @auth
                                    @foreach ($desarrolladora->sorteos as $sorteo)
                                        <div class="col-12 col-md-6">
                                            <h4>{{ $sorteo->titulo }}</h4>
                                            <p>{{ $sorteo->descripcion }}</p>
                                            @isset($sorteo->user_id)
                                                El sorteo ha finalizado.
                                                Ganador: {{$sorteo->ganador->username}}
                                            @else
                                                <input type="hidden" name="id" value="{{ $sorteo->id }}">
                                                @if(Auth::user()->cm && Auth::user()->cm->where('desarrolladora_id', $desarrolladora->id))
                                                    Eres CM de ésta desarrolladora
                                                @elseif(Auth::user()->ban)
                                                    Tu cuenta está baneada
                                                @elseif(Auth::user()->email_verified_at == null)
                                                    Tu cuenta no está verificada
                                                @elseif(Auth::user()->sorteos->where('id', $sorteo->id)->count() != 0)
                                                    Ya has participado
                                                @else
                                                    <div class="participar-sorteo-div">
                                                        <button type="submit" class="participar-sorteo btn btn-success">Participar</button>
                                                    </div>
                                                @endif
                                            @endisset
                                            <p class="mt-3">{{ $sorteo->fecha_fin }}</p>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="col-12">Tienes que registrarte para participar en los sorteos.</div>
                                @endauth
                            </div>
                        </div>
                        <div class="encuestas d-none">
                            <h3>Encuestas</h3>
                                <div class="row">
                                    @auth
                                        @foreach ($desarrolladora->encuestas as $encuesta)
                                            <div class="col-12 col-md-6">
                                                <h4>{{ $encuesta->pregunta }}</h4>
                                                @if (Auth::user()->opciones->where('encuesta_id', $encuesta->id)->count() > 0 || Auth::user()->cm && Auth::user()->cm->where('desarrolladora_id', $desarrolladora->id))
                                                    @php
                                                        $total = 0
                                                    @endphp
                                                    @foreach ($encuesta->opciones as $opcion)
                                                        @php
                                                            $total+=$opcion->participantes->count()
                                                        @endphp
                                                    @endforeach
                                                    @if($total == 0)
                                                        Aún no ha participaciones
                                                    @else
                                                        @foreach ($encuesta->opciones as $opcion)

                                                            @if($opcion->participantes->where('id',Auth::id())->count() > 0)
                                                                <span class="bg-primary">{{$opcion->descripcion}}</span>
                                                            @else
                                                                {{$opcion->descripcion}}
                                                            @endif
                                                            {{($opcion->participantes->count() / $total) * 100}} %
                                                            <br>
                                                        @endforeach
                                                    @endif
                                                @else
                                                    <div class="opciones">
                                                        @foreach ($encuesta->opciones as $opcion)
                                                            <label for="respuesta">{{ $opcion->descripcion }}</label>
                                                            <input type="radio" name="respuesta{{ $encuesta->id }}" id="respuesta" value="{{ $opcion->id }}">
                                                        @endforeach
                                                    </div>
                                                    <input type="hidden" name="id" value="{{ $encuesta->id }}">
                                                    @if(Auth::user()->ban)
                                                        Tu cuenta está baneada
                                                    @elseif(Auth::user()->email_verified_at == null)
                                                        Tu cuenta no está verificada
                                                    @else
                                                        <div class="participar-encuesta-div">
                                                            <button type="submit" class="participar-encuesta btn btn-success">Participar</button>
                                                        </div>
                                                    @endif
                                                @endif
                                                <p>{{ $encuesta->fecha_fin }}</p>
                                            </div>
                                        @endforeach
                                @else
                                    <div class="col-12">Tienes que registrarte para participar en las encuestas.</div>
                                @endauth
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
                <div class="col-md-3 offset-md-1 mt-4">
                    <h4>Juegos</h4>
                    <hr>
                    <div class="owl-carousel 1">
                        @foreach ($desarrolladora->juegos as $juego)
                            @empty($juego->campania)
                                <div class="item">
                                    <a href="{{ route('usuario.juego.show', $juego->id) }}">
                                        <img src="https://spdc.ulpgc.es/media/ulpgc/images/thumbs/edition-44827-200x256.jpg"
                                            alt="{{ $juego->nombre }}">
                                        <div class="carousel-caption" style="display: none;">
                                            <h6><strong>{{ $juego->nombre }}</strong></h6>
                                            <small>{{ $juego->desarrolladora->nombre }}</small>
                                            <hr>
                                            <small class="float-left text-left">{{ $juego->genero->nombre }}
                                                <br>
                                                {{ $juego->precio }} €
                                                <br>
                                                {{ $juego->fecha_lanzamiento }}
                                            </small>
                                        </div>
                                    </a>
                                </div>
                            @endempty
                        @endforeach
                    </div>
                    <h4 class="mt-5">Campañas</h4>
                    <hr>
                    <div class="owl-carousel 2">
                        @foreach ($desarrolladora->juegos as $juego)
                            @isset($juego->campania)
                                <div class="item">
                                    <a href="{{ route('usuario.juego.show', $juego->id) }}">
                                        <img src="https://spdc.ulpgc.es/media/ulpgc/images/thumbs/edition-44827-200x256.jpg"
                                            alt="{{ $juego->nombre }}">
                                        <div class="carousel-caption" style="display: none;">
                                            <h6><strong>{{ $juego->nombre }}</strong></h6>
                                            <small>{{ $juego->desarrolladora->nombre }}</small>
                                            <hr>
                                            <small class="float-left text-left">{{ $juego->genero->nombre }}
                                                <br>
                                                {{ $juego->precio }} €
                                                <br>
                                                {{ $juego->fecha_lanzamiento }}
                                            </small>
                                        </div>
                                    </a>
                                </div>
                            @endisset
                        @endforeach
                    </div>
                </div>
            </div>





        </div>
    </main>




@endsection
@section("scripts")
    <script src="{{ asset('js/paginga/paginga.jquery.min.js') }}"></script>
    <script src="https://www.google.com/recaptcha/api.js"></script>
    <script>
        $(function() {
            $(".noticias").paginga();

            var owl = $('.1');

            owl.owlCarousel({
                loop: true,
                margin: 10,
                items: 1.5,
            });

            owl.on('mousewheel', '.owl-stage', function(e) {
                if (e.originalEvent.wheelDelta > 0) {
                    owl.trigger('prev.owl');
                } else {
                    owl.trigger('next.owl');
                }
                e.preventDefault();
            });

            var owl2 = $('.2');

            let items = 1;

            if($('.2').children('div').length > 1) {
                let items = 1.5;
            }

            owl2.owlCarousel({
                loop: true,
                margin: 10,
                items: items
            });

            owl2.on('mousewheel', '.owl-stage', function(e) {
                if (e.originalEvent.wheelDelta > 0) {
                    owl2.trigger('prev.owl');
                } else {
                    owl2.trigger('next.owl');
                }
                e.preventDefault();
            });

            let desarrolladora = {!! json_encode($desarrolladora) !!};

            $(".compartir").click(function() {
                Swal.fire({
                    html: `<h2 class="float-left"><strong>Comparte si te gusta</strong></h2><br><hr>` +
                    `<a class="btn btn-primary m-2" href="https://twitter.com/intent/tweet?lang=en&text=He%20descubierto%20la%20desarrolladora%20${desarrolladora.nombre}%20en%20indie4all.%20¡Échale%20un%20vistazo!?&url=http://127.0.0.1:8000/desarrolladora/${desarrolladora.id}" target="_blank"><i class="fab fa-twitter fa-2x"></i></a>` +
                    `<a class="btn btn-primary m-2" href="https://www.facebook.com/dialog/share?app_id=242615713953725&display=popup&href=http://127.0.0.1:8000/desarrolladora/${desarrolladora.id}" target="_blank"><i class="fab fa-facebook-f fa-2x"></i></a>` +
                    `<a class="btn btn-success m-2" href="https://api.whatsapp.com/send?text=He%20descubierto%20la%desarrolladora%20${desarrolladora.nombre}%20en%20indie4all.%20¡Échale%20un%20vistazo!%20http://127.0.0.1:8000/desarrolladora/${desarrolladora.id}" target="_blank"><i class="fab fa-whatsapp fa-2x"></i></a>` +
                    `<hr><div class="input-group"><input type="text" id="input-link" class="form-control" value="http://127.0.0.1:8000/desarrolladora/${desarrolladora.id}"><button class="btn btn-dark ml-2 copiar">Copiar</button></div>` +
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
                let id = $(this).parent().prev().val();
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
                                },
                                success: function(data) {
                                    $(".participar-sorteo-div").html("Ya has participado.");
                                }
                            });
                        }
                    }
                })
            });
            $(".participar-encuesta").click(function (e) {
                e.preventDefault();
                let encuesta = $(this).parent().prev().val();
                let opcion = $(`input[name=respuesta${encuesta}]:checked`).val();
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
                                    opcion: opcion,
                                },
                                success: function(data) {
                                    $(".participar-encuesta-div").html("Ya has participado.");
                                }
                            });
                        }
                    }
                });
            });
            $('#reporteDesarrolladora').click(function(){
                let desarrolladoraId = {!! $desarrolladora->id !!}
                let url = '{{ route("usuario.reporte", [":id" , "desarrolladora_id"]) }}';
                url = url.replace(':id', desarrolladoraId);
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
        });

    </script>
@endsection
