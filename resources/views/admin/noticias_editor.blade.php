@extends('layouts.admin.base')
@section('content')
    <div class="container">
        <div class='row'>
            <div class='col-sm'>
                @if(isset($post))
                    <div class="box-header">
                        <h1 class='display-5'>Editar noticia</h1>
                    </div>
                    <div class="box">
                        <form action="{{ route('admin.noticias.update', $post->id) }}" method='post' enctype="multipart/form-data">
                        @method('PATCH')
                    @else
                        <div class="box-header">
                            <h1 class='display-5'>Nueva noticia</h1>
                        </div>
                        <div class="box">
                            <form action="{{ route('admin.noticias.create') }}" method='post' enctype="multipart/form-data">
                    @endif
                        @csrf
                        <div class="form-group">
                            <label> Título </label>
                            <input type="text" class="contenido form-control" name="titulo" value="@if(isset($post)) {{ $post->titulo }} @endif" />
                        </div>
                        <div class="form-group">
                            <label>Contenido</label>
                            <textarea class="form-control" name="contenido" id="editor">
                                @if(isset($post))
                                    {{ $post->contenido }}
                                @endif
                            </textarea>
                        </div>
                        <button type="submit" class='btn btn-primary'>@if(isset($post)) Editar @else Crear @endif</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="https://cdn.ckeditor.com/4.15.0/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('contenido', {
            filebrowserUploadUrl: "{{ route('admin.noticias.upload', ['_token' => csrf_token()]) }}",
            filebrowserUploadMethod: 'form'
        });
    </script>
@endsection
