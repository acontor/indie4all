@extends("layouts.usuario.base")

@section("content")
    <main class="p-3 pb-5">
        <div class="container box mt-4">
            <div class="row">
                <div class="col-12 col-md-7">
                    <h2>Últimas noticias</h2>
                    <div class="noticias">
                        <div class="items">
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
                                @endforeach
                            @else
                                Aún no hay publicada ninguna noticia.
                            @endif
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

                <div class="col-12 col-md-4 offset-md-1 mt-5 mt-md-0">
                    <h4>Desarrolladoras</h4>
                    <hr>
                    @foreach ($desarrolladoras as $desarrolladora)
                        <li>{{ $desarrolladora->nombre }}</li>
                    @endforeach
                    <h4 class="mt-5">Juegos + puntuación</h4>
                    <hr>
                    @foreach ($juegos as $juego)
                        <li>{{ $juego->nombre }} - Punt.
                            {{ $juego->seguidores->sum("pivot.calificacion") / $juego->seguidores->count() }}
                        </li>
                    @endforeach
                    <h4 class="mt-5">Masters</h4>
                    <hr>
                    @foreach ($masters as $master)
                        <li>{{ $master->usuario->name }}</li>
                    @endforeach
                </div>
            </div>
        </div>
    </main>
@endsection

@section("scripts")
    <script src="{{ asset('js/paginga/paginga.jquery.min.js') }}"></script>
    <script src="{{ asset('js/usuario.js') }}"></script>
    <script>
        $(function() {
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
