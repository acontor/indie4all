@extends("layouts.usuario.base")

@section("content")
<div class="container p-5">
    <div class="row">
        <div class="col-12">
            <header>
                <img class="img-fluid h-auto" src="{{ asset('/images/default.png') }}">
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
                </div>
                <hr>
                <div id="contenido">
                    <div class="general">
                        <h3>General</h3>
                        @if ($master->posts->where('tipo', 'General')->count() != 0)
                            @foreach ($master->posts->where('tipo', 'General') as $post)
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
                            Aún no ha publicado ningún post.
                        @endif
                    </div>
                    <div class="analisis d-none">
                        <h3>Análisis</h3>
                        @if ($master->posts->where('tipo', 'Análisis')->count() != 0)
                            @foreach ($master->posts->where('tipo', 'Análisis') as $post)
                                <div>
                                    <h4>{{ $post->titulo }}</h4>
                                    <p>{!! $post->contenido !!}</p>
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
@endsection
@section("scripts")
<script src="https://cdn.ckeditor.com/4.15.0/standard/ckeditor.js"></script>
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
            $("#contenido").children("div").addClass("d-none");
            $.ajax({
                url: "{{ route('usuario.master.post') }}",
                data: {
                    id: $(this).prev().val(),
                },
                success: function(data) {
                    let html = `<div class='post'><h4>${data.post.titulo}</h4><div class="contenido-post">${data.post.contenido}</p></div><hr><h4>Comentarios</h4><textarea class="form-control" name="mensaje" id="editor"></textarea>`;
                    if(data.mensajes.length > 0) {
                        data.mensajes.forEach(element => {
                            html += `<div class="mensaje">${element.contenido}</div></div>`;
                        });
                    } else {
                        html += '<div class="mensaje">No hay ningún mensaje</div></div>';
                    }
                    $("#contenido").append(html);
                    CKEDITOR.replace("mensaje", {
                        filebrowserUploadUrl: "{{ route('master.posts.upload', ['_token' => csrf_token()]) }}",
                        filebrowserUploadMethod: "form"
                    });
                }
            });
        });
    });

</script>
@endsection
