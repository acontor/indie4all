@extends("layouts.master.base")
@section("content")
    <div class="container">
        <div class="row">
            <div class="col-sm">
                @if(isset($post))
                    <div class="box-header">
                        <h1>Editar post</h1>
                    </div>
                    <div class="box">
                        <form action="{{ route('master.analisis.update', $post->id) }}" method='post' enctype="multipart/form-data">
                        @method("PATCH")
                    @else
                        <div class="box-header">
                            <h1>Nuevo post</h1>
                        </div>
                        <div class="box">
                            <form action="{{ route('master.analisis.store') }}" method='post' enctype="multipart/form-data">
                    @endif
                        @csrf
                        <div class="form-group">
                            <label>Título</label>
                            <input type="text" class="form-control" name="titulo" value="@if(isset($post)){{ $post->titulo }}@endif" />
                        </div>
                        <div class="form-group">
                            <label>Calificación</label>
                            <input type="number" class="form-control" name="calificacion" value="@if(isset($post)){{ $post->calificacion }}@endif" />
                        </div>
                        <!-- Poner botones en juegos para que master pueda crear análisis o post sobre ese juego. Incluir aquí un select de los juegos y el tipo de post. -->
                        <div class="form-group">
                            <label>Contenido</label>
                            <textarea class="form-control" name="contenido" id="editor">
                                @if(isset($post))
                                    {{ $post->contenido }}
                                @endif
                            </textarea>
                        </div>
                        <button type="submit" class="btn btn-success">@if(isset($post)) Editar @else Crear @endif</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section("scripts")
    <script src="https://cdn.ckeditor.com/4.15.0/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace("contenido", {
            filebrowserUploadUrl: "{{ route('master.analisis.upload', ['_token' => csrf_token()]) }}",
            filebrowserUploadMethod: "form"
        });
    </script>
@endsection
