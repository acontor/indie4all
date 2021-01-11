@extends("layouts.cm.base")

@section("content")
    <div class="container">
        <div class="box-header">
            <h1>@isset($noticia) Editar @else Nueva @endisset noticia</h1>
        </div>
        <div class="box">
            @isset($noticia)
                @if($noticia->ban)
                    <div class="row">
                        <span class="alert alert-danger w-100">
                            <p>Su noticia está suspendida por el siguiente motivo. Puedes corregir los problemas y contactar con soporte@indie4all.com para volver a publicarlo.</p>
                            <small>{{$noticia->motivo}}</small>
                        </span>
                    </div>
                @endif
                <form action="{{ route('cm.noticia.update', $noticia->id) }}" method='post' enctype="multipart/form-data">
                    @method("PATCH")
            @else
                <form action="{{ route('cm.noticia.store', ['tipo' => $tipo, 'id' => $id]) }}" method='post' enctype="multipart/form-data">
            @endisset
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
