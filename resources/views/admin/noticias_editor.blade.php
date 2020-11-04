@extends('layouts.admin.base')
@section('content')
    <div class="container">
        <div class='row'>
            <div class='col-sm'>
                <h1 class='display-5'>Nueva noticia</h1>
                @if (session()->get('success'))
                    <div class='alert alert-success'>
                        {{ session()->get('success') }}
                    </div>
                @endif
                @if(isset($post))
                <form action="{{ route('admin.noticias.update', $post->id) }}" method='post' enctype="multipart/form-data">
                @method('PATCH')
                @else
                <form action="{{ route('admin.noticias.create') }}" method='post' enctype="multipart/form-data">
                @endif
                    @csrf
                    <div class="form-group">
                        <label> Título </label>
                        <input type="text" class="contenido form-control" name="titulo" value="@if(isset($post)) {{ $post->titulo }} @endif">
                    </div>
                    <div class="form-group">
                        <label>Contenido</label>
                        <textarea class="form-control" name="contenido" id="editor">
                            @if(isset($post))
                                {{ $post->contenido }}
                            @endif
                        </textarea>
                    </div>
                    <button type="submit" class='btn btn-primary'>Crear</button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.ckeditor.com/4.15.0/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('contenido', {
            filebrowserUploadUrl: "{{ route('admin.noticias.upload', ['_token' => csrf_token()]) }}",
            filebrowserUploadMethod: 'form'
        });
    </script>
@endsection
