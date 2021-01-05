@extends("layouts.usuario.base")
    <link href="{{ asset('css/animate.min.css') }}" rel="stylesheet">
@section('content')
    <main class="p-4">
        <!-- HEADER -->
        <div class="container box mt-4">
            <div class="row mb-4">
                <h1 class="mx-auto">{{ $campania->juego->nombre }}</h1>
            </div>
            <div class="row">
                <div class="col-md-8 col-12">
                    @if (!$campania->juego->imagen_portada)
                        <img class="img-fluid h-auto" src="{{url('/images/default.png')}}">
                    @else
                        <img class="img-fluid h-auto animate__animated animate__fadeIn" src="{{url('/images/juegos/portadas/' . $campania->juego->imagen_portada)}}">
                    @endif
                </div>
                <div class="col-12 col-md-4">
                    <ul class="list-group list-group-flush mt-4">
                        <li class="list-group-item">
                            <h5>{{ $campania->recaudado }} €</h5>
                            <small>de {{ $campania->meta }} €</small>
                            <div class="progress mt-2">
                                <div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <h5>GÉNERO</h5>
                            <small>{{ $campania->juego->genero->nombre }}</small>
                        </li>
                        <li class="list-group-item">
                            <h5>PARTICIPANTES</h5>
                            <small>{{ $campania->compras->count() }}</small>
                        </li>
                        <li id="diasRestantes" class="list-group-item"></li>
                    </ul>
                </div>
            </div>

            <!-- SUBMENU -->
            <nav id="submenu" class="navbar navbar-expand-md sticky-top navbar-light shadow bg-white mt-4 mb-4 pt-3 pb-3">
                <div class="navbar-nav float-right-sm">
                    <div class="d-flex">
                        @if(Auth::user() && Auth::user()->cm()->count() != 0 && Auth::user()->cm->desarrolladora_id == $campania->juego->desarrolladora_id)
                                <a class="btn btn-primary" href="{{ route('cm.campania.show', $campania->id) }}"><i class="fas fa-user-edit mt-1"></i></a>
                        @endif
                        @auth
                            <button class="btn btn-primary participar ml-2">Participar</button>
                        @endauth
                        <button class="btn btn-warning compartir ml-2"><i class="fas fa-share-alt"></i></button>
                        @if(Auth::user() && Auth::user()->cm()->count() != 0 && Auth::user()->cm->desarrolladora_id != $campania->juego->desarrolladora_id)
                            <a class="btn btn-danger ml-2"><i class="fas fa-exclamation-triangle mt-1" id='reporteCampania'></i></a>
                        @endif
                    </div>
                </div>
                <button class="navbar-toggler ml-1" type="button" data-toggle="collapse" data-target="#collapsingNavbar">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="navbar-collapse collapse justify-content-between align-items-center w-100" id="collapsingNavbar">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item"><a class="nav-link" id="contenido" href="">Campaña</a></li>
                        <li class="nav-item"><a class="nav-link" id="actualizaciones" href="">Actualizaciones</a></li>
                        @auth
                            <li class="nav-item"><a class="nav-link" id="foro" href="">Foro</a></li>
                        @endauth
                        <li class="nav-item"><a class="nav-link" id="faq" href="">FAQ</a></li>
                        <a class="nav-link" id="contacto" href="{{ route('usuario.desarrolladora.show', $campania->juego->desarrolladora_id) }}" target="_blank">Desarrolladora</a>
                    </ul>
                </div>
            </nav>

            <div id="main">
                <div class="contenido">
                    <h3>Contenido</h3>
                    {!! $campania->contenido !!}
                </div>
                <div class="actualizaciones d-none">
                    @if ($campania->posts->count() != 0)
                        <div class="items">
                            @foreach ($campania->posts as $post)
                                <div>
                                    <h4>{{ $post->titulo }} <small>{{$post->created_at}}</small></h4>
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
                    @else
                        Aún no ha publicado ninguna actualización.
                    @endif
                </div>
                @auth
                <div class="foro d-none">
                    <h3>Foro</h3>
                    <textarea class="form-control" name="mensaje" id="editor"></textarea>
                    <input type="hidden" name="id" value="{{ $campania->id }}">
                    <button class="btn btn-success mt-3 mb-3" id="mensaje-form">Comentar</button>
                    <div class="mensajes">
                        @if ($campania->mensajes->count() != 0)
                            <div class="items">
                                @foreach ($campania->mensajes as $mensaje)
                                    <div>
                                        <h5> {{$mensaje->user->name}}<small class="float-right">{{date_format($mensaje->created_at,"d-m-Y H:i")}}</small></h5><a class="text-danger float-right" id='reporteMensaje' dataset="{{$mensaje->id}}"><i class="fas fa-exclamation-triangle"></i></a>
                                        <p class="mensaje">{!! $mensaje->contenido !!}</p>
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
                            <div class="mensaje mt-3">Aún no hay mensajes.. Sé el primero en participar!</div>
                        @endif
                    </div>
                </div>
                @endauth
                <div class="faq d-none">
                    <h3>FAQ</h3>
                    {!! $campania->faq !!}
                </div>
            </div>
        </div>
    </main>
@endsection
@section('scripts')
<script src="{{ asset('js/paginga.jquery.min.js') }}"></script>
<script src="http://momentjs.com/downloads/moment.min.js"></script>
<script src="https://www.google.com/recaptcha/api.js"></script>
<script>
    $(function() {
        $(".actualizaciones").paginga();
        $(".mensajes").paginga();

        let recaudado = {{json_encode($campania->recaudado)}};
        let meta = {{json_encode($campania->meta)}};
        const fechaFin = @json($campania).fecha_fin;
        let fechaHoy = moment();
        let fechaFinal = moment(fechaFin,);
        let porcentaje = (100*recaudado)/meta;

        $('.progress-bar').css('width',porcentaje+'%');
        if(fechaFinal.diff(fechaHoy) < 0) {
            $('#diasRestantes').html('<h5>¡La campaña ha terminado!</h5>');
            $('.participar-div').remove();
        } else if (fechaFinal.diff(fechaHoy) < 8,64e+7) {
            $('#diasRestantes').html(`<h5>Quedan</h5><small class="text-danger">¡Último día!</small></h5>`);
        } else {
            $('#diasRestantes').html(`<h5>Quedan</h5><small class="text-danger">${fechaFinal.diff(fechaHoy, 'days')} días</small>`);
        }

        $(".participar").click(function() {
            $("#precio").focus();
        })

        $('#reporteCampania').click(function(){
            let campaniaId = {!! $campania->id !!}
            let url = '{{ route("usuario.reporte", [":id" , "campania_id"]) }}';
            url = url.replace(':id', campaniaId);
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
            });
        });

        $('#reporteMensaje').click(function(){
            let id = $(this).attr('dataset');
            let url = '{{ route("usuario.reporte", [":id" , "mensaje_id"]) }}';
            url = url.replace(':id', id);
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
            });
        });

        CKEDITOR.replace("mensaje", {
            customConfig: "{{ asset('js/ckeditor/config.js') }}"
        });

        $("#mensaje-form").click(function(e) {
            e.preventDefault();
            let mensaje = CKEDITOR.instances.editor.getData();
            CKEDITOR.instances.editor.setData("");
            let id = $(this).prev().val();
            $.ajax({
                url: '{{ route("usuario.foro.store") }}',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    id: id,
                    mensaje: mensaje
                }, success: function(data) {
                    if ($('.mensajes').children().text() == "Aún no hay mensajes.. Sé el primero en participar!") {
                        $('.mensaje').html(`<div class="alert alert-dark" role="alert">${data.autor} <small>${data.created_at}</small><p>${data.contenido}</p></div>`);
                    } else {
                        $('.mensajes').append(`<div class="alert alert-dark" role="alert">${data.autor} <small>${data.created_at}</small><p>${data.contenido}</p></div>`);
                    }
                }
            });
        });

        $(".more").click(function () {
            let url = '{{ route("usuario.campania.actualizacion", ":id") }}';
            url = url.replace(':id', $(this).prev().val());
            $.ajax({
                url: url,
                data: {
                    id: $(this).prev().val(),
                },
                success: function(data) {
                    let html = `<div class='post text-justify'><div class="contenido-post">${data.post.contenido}</p></div>`;
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
                }
            });
        });

        let campania = {!! json_encode($campania) !!};

        $(".compartir").click(function() {
            Swal.fire({
                html: `<h2 class="float-left"><strong>Comparte si te gusta</strong></h2><br><hr>` +
                `<a class="btn btn-primary m-2" href="https://twitter.com/intent/tweet?lang=en&text=He%20descubierto%20el%20juego%20${campania.juego.nombre}%20en%20indie4all.%20¡Mira%20su%20campaña!?&url=http://127.0.0.1:8000/campania/${campania.id}" target="_blank"><i class="fab fa-twitter fa-2x"></i></a>` +
                `<a class="btn btn-primary m-2" href="https://www.facebook.com/dialog/share?app_id=242615713953725&display=popup&href=http://127.0.0.1:8000/campania/${campania.id}" target="_blank"><i class="fab fa-facebook-f fa-2x"></i></a>` +
                `<a class="btn btn-success m-2" href="https://api.whatsapp.com/send?text=He%20descubierto%20el%20juego%20${campania.juego.nombre}%20en%20indie4all.%20¡Mira%20su%20campaña!%20http://127.0.0.1:8000/campania/${campania.id}" target="_blank"><i class="fab fa-whatsapp fa-2x"></i></a>` +
                `<hr><div class="input-group"><input type="text" id="input-link" class="form-control" value="http://127.0.0.1:8000/campania/${campania.id}"><button class="btn btn-dark ml-2 copiar">Copiar</button></div>` +
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

        $(".participar").click(function() {
            Swal.fire({
                html: `<form action="{{ route('usuario.paypal.pagar') }}" method="post">` +
                `@csrf` +
                `@method('POST')` +
                `<input type="hidden" name="tipo" value="1"/><input type="hidden" name="campaniaId" value="${campania.id}"><input type="text" name="precio" id="precio">` +
                `<button type="submit" class="btn btn-primary"> Participar</button></form>`,
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
        });
    });

</script>
@endsection
