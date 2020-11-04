@extends('layouts.admin.base')
@section('content')
    <div class="container">
        <div class='row'>
            <div class='col-sm'>
                <h1 class='display-5'>Noticias ({{ $noticias->count() }})</h1>
                <a href="{{ route('admin.noticias.create') }}" class='btn btn-success button-crear mb-3'>+</a>
                @if (session()->get('success'))
                    <div class='alert alert-success'>
                        {{ session()->get('success') }}
                    </div>
                @endif
                <div class="table-responsive">
                    <table class='table table-striped'>
                        <thead>
                            <tr>
                                <td>Título</td>
                                <td>Editar</td>
                                <td>Borrar</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($noticias as $noticia)
                                <tr>
                                    <form action="{{ route('admin.noticias.edit', $noticia->id) }}" method='post'>
                                        @csrf
                                        <td class="align-middle">{{ $noticia->titulo }}</td>
                                        <td class="align-middle">
                                            <button type="submit" class='btn btn-primary'>Editar</button>
                                        </td>
                                    </form>
                                    <td>
                                        <form action="{{ route('admin.noticias.destroy', $noticia->id) }}" method='post'>
                                            @csrf
                                            @method('DELETE')
                                            <button class='btn btn-danger' type='submit'>Borrar</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $noticias->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
@endsection
