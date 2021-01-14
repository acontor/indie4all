@extends("layouts.admin.base")

@section("content")
    <div class="container">
        <div class="row">
            <div class="col-sm">
                <div class="box-header">
                    <h1>@isset($post)Editar @else Nueva @endisset noticia</h1>
                </div>
                <div class="box">
                    @isset($post)
                        <form action="{{ route('admin.noticias.update', $post->id) }}" method='post' enctype="multipart/form-data">
                            @method("PATCH")
                    @else
                        <form action="{{ route('admin.noticias.create') }}" method='post' enctype="multipart/form-data">
                    @endisset
                        @csrf
                        <div class="form-group">
                            <label>Título</label>
                            <input type="text" class="contenido form-control" name="titulo" value="@if(isset($post)) {{ $post->titulo }} @endif" />
                        </div>
                        <div class="form-group">
                            <label>Contenido</label>
                            <textarea class="form-control" name="contenido" id="editor">
                                @isset($post)
                                    {{ $post->contenido }}
                                @endisset
                            </textarea>
                        </div>
                        <button type="submit" class="btn btn-success">@isset($post) Editar @else Crear @endisset</button>
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
            filebrowserUploadUrl: "{{ route('admin.noticias.upload', ['_token' => csrf_token()]) }}",
            filebrowserUploadMethod: "form"
        });
    </script>
@endsection
