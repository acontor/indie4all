@extends("layouts.cm.base")

@section("content")
    <div class="container">
        <div class="row">
            <div class="col-sm">
                @if(isset($noticia))
                    <div class="box-header">
                        <h1>Editar noticia</h1>
                    </div>
                    <div class="box">
                        <form action="{{ route('cm.noticia.update', $noticia->id) }}" method='post' enctype="multipart/form-data">
                        @method("PATCH")
                    @else
                        <div class="box-header">
                            <h1>Nueva noticia</h1>
                        </div>
                        <div class="box">
                            <form action="{{ route('cm.noticia.store', ['tipo' => $tipo, 'id' => $id]) }}" method='post' enctype="multipart/form-data">
                    @endif
                        @csrf
                        <div class="form-group">
                            <label>Título</label>
                            <input type="text" class="form-control" name="titulo" value="@if(isset($noticia)) {{ $noticia->titulo }} @endif" />
                        </div>
                        <div class="form-group">
                            <label>Contenido</label>
                            <textarea class="form-control" name="contenido" id="editor">
                                @if(isset($noticia))
                                    {{ $noticia->contenido }}
                                @endif
                            </textarea>
                        </div>
                        <button type="submit" class="btn btn-success">@if(isset($noticia)) Editar @else Crear @endif</button>
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
            filebrowserUploadUrl: "{{ route('cm.noticia.upload', ['_token' => csrf_token()]) }}",
            filebrowserUploadMethod: "form"
        });
    </script>
@endsection
