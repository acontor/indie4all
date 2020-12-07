@extends("layouts.cm.base")
@section("content")
    <div class="container">
        <div class="row">
            <div class="col-sm">
                @if(isset($post))
                    <div class="box-header">
                        <h1>Editar post</h1>
                    </div>
                    <div class="box">
                        <form action="{{ route('cm.posts.update', $post->id) }}" method='post' enctype="multipart/form-data">
                        @method("PATCH")
                    @else
                        <div class="box-header">
                            <h1>Nuevo post</h1>
                        </div>
                        <div class="box">
                            <form action="{{ route('cm.posts.create') }}" method='post' enctype="multipart/form-data">
                    @endif
                        @csrf
                        <div class="form-group">
                            <label>Título</label>
                            <input type="text" class="form-control" name="titulo" value="@if(isset($post)) {{ $post->titulo }} @endif" />
                        </div>
                        <!-- Poner botones en juegos y desarrolladoras para que cm pueda crear post. Incluir aquí un select de los juegos y el tipo de post. -->
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
            filebrowserUploadUrl: "{{ route('cm.posts.upload', ['_token' => csrf_token()]) }}",
            filebrowserUploadMethod: "form"
        });
    </script>
@endsection