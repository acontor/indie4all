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
                <form action="{{ route('admin.noticias.create') }}" method='post'>
                    @csrf
                    <input type="text" name="titulo" id="titulo" placeholder="Título">
                    <textarea name="contenido" id="contenido" cols="30" rows="10">Contenido</textarea>
                    <button type="submit" class='btn btn-primary'>Crear</button>
                </form>
            </div>
        </div>
    </div>
    </div>
@endsection
