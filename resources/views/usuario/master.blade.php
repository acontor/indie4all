@extends("layouts.usuario.base")

@section("content")
    <div class="container p-5">
        <div class="row">
            <div class="col-12">
                <header>
                    @if (!$master->imagen)
                        <img class="img-fluid h-auto" src="{{url('/images/default.png')}}">
                    @else
                        <img class="img-fluid h-auto" src="{{url('/images/masters/' . $master->imagen)}}">
                    @endif
                    <div>
                        <h1 class="font-weight-light">{{ $master->usuario->name }}</h1>
                        <ul class="lead">
                            <li> Email: {{ $master->email }}</li>
                            <li> imagen: {{ $master->imagen }}</li>
                            <li>
                                <div class="btn-group mt-3">
                                    @if ($usuario == null)
                                        <form method="post" action="{{ route('usuario.master.follow', $master->id) }}">
                                            @csrf
                                            <button type="submit" class="btn text-primary"><i class="far fa-check-circle"></i></button>
                                        </form>
                                    @else
                                        <form method="post" action="{{ route('usuario.master.unfollow', $master->id) }}">
                                            @csrf
                                            <button type="submit" class="btn text-danger"><i class="far fa-times-circle"></i></button>
                                        </form>
                                        @if ($usuario->pivot->notificacion == 0)
                                            <form method="post" action="{{ route('usuario.master.notificacion', [$master->id, 1]) }}">
                                                @csrf
                                                <button type="submit" class="btn text-primary"><i class="far fa-bell"></i></i></button>
                                            </form>
                                        @else
                                            <form method="post" action="{{ route('usuario.master.notificacion', [$master->id, 0]) }}">
                                                @csrf
                                                <button type="submit" class=" btn text-danger"><i class="far fa-bell-slash"></i></button>
                                            </form>
                                        @endif
                                    @endif
                                </div>
                            </li>
                        </ul>
                    </div>
                </header>
                <div class="col-md-12 box mt-4">
                    <div class="row text-center menu">
                        <div class="col-3"><a id="general" href="">General</a></div>
                        <div class="col-3"><a id="analisis" href="">Análisis</a></div>
                        <div class="col-3"><a id="notas" href="">Notas</a></div>
                        <div class="float-right">
                            <a class="text-danger"><i class="fas fa-exclamation-triangle" id='reporteMaster'></i></a>
                        </div>
                    </div>
                    <hr>
                    <div id="contenido">
                        <div class="general">
                            <h3>General</h3>
                            @if ($master->posts->where('tipo', 'General')->count() != 0)
                                @foreach ($master->posts->where('tipo', 'General') as $post)
                                    <div>
                                        <h4>{{ $post->titulo }}</h4>
                                    </div>
                                    <small>Comentarios: {{ $post->mensajes->count() }}</small>
                                    <form>
                                        <input type="hidden" name="id" value="{{ $post->id }}" />
                                        <a type="submit" class="more">Comentarios</a>
                                    </form>
                                @endforeach
                                <!-- Esto será como estados que va a poder escribir el master y tendrán comentarios -->
                            @else
                                Aún no ha publicado ninguna actualización.
                            @endif
                        </div>
                        <div class="analisis d-none">
                            <h3>Análisis</h3>
                            @if ($master->posts->where('tipo', 'Análisis')->count() != 0)
                                @foreach ($master->posts->where('tipo', 'Análisis') as $post)
                                <hr>
                                    <div>
                                        <h4>{{ $post->titulo }}</h4>
                                        <p>{!! substr($post->contenido, 0, 300) !!}...</p>
                                        <small>Comentarios: {{ $post->mensajes->count() }}</small>
                                        <form>
                                            <input type="hidden" name="id" value="{{ $post->id }}" />
                                            <a type="submit" class="more">Leer más</a>
                                        </form>
                                    </div>
                                @endforeach
                            @else
                                Aún no ha publicado ningún análisis.
                            @endif
                        </div>
                        <div class="notas d-none">
                            <h3>Notas</h3>
                            @if ($master->posts->where('tipo', 'Análisis')->count() != 0)
                                @foreach ($master->posts->where('tipo', 'Análisis') as $post)
                                    <div>
                                        <h4>{{ $post->titulo }}</h4>
                                        <p>{!! $post->calificacion !!}</p>
                                    </div>
                                @endforeach
                            @else
                                Aún no ha publicado ningún análisis.
                            @endif
                        </div>
                    </div>
                </div>
            </div>
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
                $(".post").remove();
                $("#contenido").children("div").addClass("d-none");
                $(`.${item}`).removeClass("d-none");
            });

            $(".more").click(function () {
                let url = '{{ route("usuario.master.post", ":id") }}';
                url = url.replace(':id', $(this).prev().val());
                $.ajax({
                    url: url,
                    data: {
                        id: $(this).prev().val(),
                    },
                    success: function(data) {
                        let html = `<div class='post text-justify'><div class="contenido-post">${data.post.contenido}</p> <input id="idPost" type="hidden" value="${data.post.id}"><a class="text-danger"><i class="fas fa-exclamation-triangle" id='reportePost'></i></a></div><hr><textarea class="form-control" name="mensaje" id="editor"></textarea><button class="btn btn-success mt-3 mb-3" id="mensaje-form">Comentar</button><h4>Comentarios</h4><div class="mensajes">`;
                        if(data.mensajes.length > 0) {
                            data.mensajes.forEach(element => {
                                console.log(element)
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
            $('#reporteMaster').click(function(){
                let masterId = {!! $master->id !!}
                let url = '{{ route("usuario.reporte", [":id" , "master_id"]) }}';
                url = url.replace(':id', masterId);
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
