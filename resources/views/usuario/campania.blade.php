@extends("layouts.usuario.base")

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
                        <img class="img-fluid h-auto" src="{{ asset('/images/desarrolladoras/default-portada-juego.png') }}">
                    @else
                        <img class="img-fluid h-auto animate__animated animate__fadeIn" src="{{ asset('/images/desarrolladoras/' . $campania->juego->desarrolladora->nombre . '/' . $campania->juego->imagen_portada) }}">
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

            <nav id="submenu" class="navbar navbar-expand-md sticky-top navbar-light shadow bg-white mt-4 mb-4 pt-3 pb-3">
                <div class="navbar-nav float-right-sm">
                    <div class="d-flex">
                        @if(Auth::user() && Auth::user()->cm()->count() != 0 && Auth::user()->cm->desarrolladora_id == $campania->juego->desarrolladora_id)
                                <a class="btn btn-primary" href="{{ route('cm.campania.show', $campania->id) }}"><i class="fas fa-user-edit mt-1"></i></a>
                        @endif
                        @auth
                            <button class="btn btn-primary participar ml-2"><i class="fab fa-paypal"></i></button>
                        @endauth
                        <button class="btn btn-warning compartir ml-2"><i class="fas fa-share-alt"></i></button>
                        @if(Auth::user() && !Auth::user()->cm && !Auth::user()->ban && Auth::user()->email_verified_at != null)
                            <a class="btn btn-danger ml-2" id='reporteCampania'><i class="fas fa-exclamation-triangle mt-1"></i></a>
                        @endif
                    </div>
                </div>
                <button class="navbar-toggler ml-1" type="button" data-toggle="collapse" data-target="#collapsingNavbar">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="navbar-collapse collapse justify-content-between align-items-center w-100" id="collapsingNavbar">
                    <ul class="navbar-nav ml-auto submenu-items">
                        <li class="nav-item"><a class="nav-link" id="general" href="">Campaña</a></li>
                        <li class="nav-item"><a class="nav-link" id="actualizaciones" href="">Actualizaciones</a></li>
                        <li class="nav-item"><a class="nav-link" id="foro" href="">Foro</a></li>
                        <li class="nav-item"><a class="nav-link" id="faq" href="">FAQ</a></li>
                        <a class="btn btn-dark" id="contacto" href="{{ route('usuario.desarrolladora.show', $campania->juego->desarrolladora_id) }}">Desarrolladora</a>
                    </ul>
                </div>
            </nav>

            <div class="row">
                <div class="col-12 mt-4">
                    <div id="contenido">
                        <div class="general berber p-4">
                            <h3>Contenido</h3>
                            {!! $campania->contenido !!}
                        </div>
                        <div class="actualizaciones mt-3 d-none">
                            @if ($campania->posts->count() != 0)
                                <div class="items">
                                    @foreach ($campania->posts as $post)
                                        <div class="berber">
                                            <h4>{{ $post->titulo }} <small class="float-right">{{$post->created_at}}</small></h4>
                                            @php
                                                $resumen = explode('</p>', $post->contenido)
                                            @endphp
                                            <p>{!! $resumen[0] !!}</p>
                                            <form class="mb-3">
                                                <input type="hidden" name="id" value="{{ $post->id }}" />
                                                <a type="submit" class="btn btn-light btn-sm more text-dark font-weight-bold">Leer más</a>
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
                            <div class="foro px-md-4 mt-3 d-none">
                                @if(Auth::user()->compras->where('campania_id', $campania->id)->count() > 0)
                                    <textarea class="form-control" name="mensaje" id="editor"></textarea>
                                    <input type="hidden" name="id" value="{{ $campania->id }}">
                                    <button class="btn btn-success mt-3 mb-3" id="mensaje-form">Comentar</button>
                                    <div class="mensajes">
                                        @if ($campania->mensajes->count() != 0)
                                            <div class="items">
                                                @foreach ($campania->mensajes as $mensaje)
                                                    <div class="berber">
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
                                            <div class="berber">Aún no hay mensajes.. Sé el primero en participar!</div>
                                        @endif
                                    </div>
                                @else
                                    <div class="berber">Participa en la campaña para poder acceder al foro</div>
                                @endif
                            </div>
                        @endauth
                        <div class="faq berber p-4 d-none">
                            <h3>FAQ</h3>
                            {!! $campania->faq !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="more-div container bg-light p-5 shadow-lg rounded mt-4"></div>
        </div>
    </main>
@endsection

@section('scripts')
    <script src="http://momentjs.com/downloads/moment.min.js"></script>
    <script>
        $(function() {
            let campania = {!! $campania !!};
            let recaudado = campania.recaudado;
            let meta = campania.meta;
            const fechaFin = campania.fecha_fin;
            let fechaHoy = moment();
            let fechaFinal = moment(fechaFin);
            let porcentaje = (100*recaudado)/meta;

            $('.progress-bar').css('width',porcentaje+'%');

            if(fechaFinal.diff(fechaHoy) < 0) {
                $('#diasRestantes').html('<h5>¡La campaña ha terminado!</h5>');
                $('.participar-div').remove();
            } else if (fechaFinal.diff(fechaHoy) < 8.64e+7) {
                $('#diasRestantes').html(`<h5>Quedan</h5><small class="text-danger">¡Último día!</small></h5>`);
            } else {
                $('#diasRestantes').html(`<h5>Quedan</h5><small class="text-danger">${fechaFinal.diff(fechaHoy, 'days')} días</small>`);
            }

            $(".participar").on('click', function() {
                $("#precio").focus();
            });

            $('#reporteMensaje').on('click', function(){
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
            if($('#editor').length > 0) {
                CKEDITOR.replace("mensaje", {
                    customConfig: "{{ asset('js/ckeditor/config.js') }}"
                });
            }
            $("#mensaje-form").on('click', function(e) {
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
                    }, success: function (data) {
                        if ($('.mensajes').children().text() == "No hay ningún mensaje") {
                            $('.mensaje').html(`<div class="berber">${data.autor}<p>${data.contenido}</p></div>`);
                        } else {
                            $('.mensajes').append(`<div class="berber">${data.autor}<p>${data.contenido}</p></div>`);
                        }
                    }
                });
            });

            html = `<h2 class="float-left"><strong>Comparte si te gusta</strong></h2><br><hr>` +
            `<a class="btn btn-primary m-2" href="https://twitter.com/intent/tweet?lang=en&text=He%20descubierto%20el%20juego%20${campania.juego.nombre}%20en%20indie4all.%20¡Mira%20su%20campaña!?&url=http://127.0.0.1:8000/campania/${campania.id}" target="_blank"><i class="fab fa-twitter fa-2x"></i></a>` +
            `<a class="btn btn-primary m-2" href="https://www.facebook.com/dialog/share?app_id=242615713953725&display=popup&href=http://127.0.0.1:8000/campania/${campania.id}" target="_blank"><i class="fab fa-facebook-f fa-2x"></i></a>` +
            `<a class="btn btn-success m-2" href="https://api.whatsapp.com/send?text=He%20descubierto%20el%20juego%20${campania.juego.nombre}%20en%20indie4all.%20¡Mira%20su%20campaña!%20http://127.0.0.1:8000/campania/${campania.id}" target="_blank"><i class="fab fa-whatsapp fa-2x"></i></a>` +
            `<hr><div class="input-group"><input type="text" id="input-link" class="form-control" value="http://127.0.0.1:8000/campania/${campania.id}"><button class="btn btn-dark ml-2 copiar">Copiar</button></div>` +
            `<small class="mt-3 float-left">¡Gracias por compartir!</small>`;

            $(".compartir").on('click', {html: html}, compartir);

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

            $('#reporteCampania').on('click', function(){
                let id = {!! $campania->id !!};
                let url = '{{ route("usuario.reporte") }}';
                reporte(url, id, 'campania_id');
            });

            $(".participar").on('click', function() {
                Swal.fire({
                    html: `<p>El aporte mínimo para conseguir una copia es de ${campania.aporte_minimo} €` +
                    `<form action="{{ route('usuario.paypal.pagar') }}" method="post">` +
                    `@csrf` +
                    `@method('POST')` +
                    `<input type="hidden" name="tipo" value="1"/><input type="hidden" name="campaniaId" value="${campania.id}"><input type="text" class="form-control" name="precio" id="precio" placeholder="${campania.aporte_minimo}">` +
                    `<button type="submit" class="btn btn-primary mt-3"> Participar</button></form>`,
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
