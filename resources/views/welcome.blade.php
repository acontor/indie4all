@extends("layouts.usuario.base")

@section("content")
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"><h3>Noticias</h3></div>
                    <div class="card-body">
                        @if ($noticias->count() != 0)
                            @foreach ($noticias as $noticia)
                                <div>
                                    <h4>{{ $noticia->titulo }}</h4>
                                    <p>{!! substr($noticia->contenido, 0, 300) !!}...</p>
                                    {{ $noticia->created_at }}
                                    @if ($noticia->comentarios)
                                        <small>Comentarios: {{ $noticia->mensajes->count() }}</small>
                                    @endif
                                    <form>
                                        <input type="hidden" name="id" value="{{ $noticia->id }}" />
                                        <a type="submit" class="more">Leer más</a>
                                    </form>
                                </div>
                                <hr>
                            @endforeach
                        @else
                            Aún no hay publicada ninguna noticia.
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">Juegos</div>
                    <div class="card-body">
                        <ul>
                            @foreach ($juegos as $juego)
                                <li>{{ $juego->nombre }} - Punt.
                                    {{ $juego->usuarios->sum("pivot.calificacion") / $juego->usuarios->count() }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="card mt-3">
                    <div class="card-header">Desarrolladoras</div>
                    <div class="card-body">
                        <ul>
                            @foreach ($desarrolladoras as $desarrolladora)
                                <li>{{ $desarrolladora->nombre }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="card mt-3">
                    <div class="card-header">Masters</div>
                    <div class="card-body">
                        <ul>
                            @foreach ($masters as $master)
                                <li>{{ $master->usuario->name }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section("scripts")
    <script src="{{ asset('js/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('js/sweetalert.min.js') }}"></script>
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
