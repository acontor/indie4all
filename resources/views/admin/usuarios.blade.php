@extends('layouts.admin.base')
@section('content')
    <div class="container">
        <div class='row'>
            <div class='col-sm'>
                <h1 class='display-5'>Usuarios ({{ $usuarios->count() }})</h1>
                <div class="table-responsive">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <td>Nombre</td>
                                    <td>Email</td>
                                    <td>Editar</td>
                                    <td>Borrar</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($usuarios as $usuario)
                                    <tr>
                                        <form method='post' action="{{ route('admin.usuarios.update', $usuario->id) }}">
                                            @method('PATCH')
                                            @csrf
                                            <td class="align-middle">
                                                <input type='text' placeholder="Nombre" value="{{ $usuario->name }}" name='name'>
                                            </td>
                                            <td class="align-middle">
                                                <input type='text' placeholder="Email" value="{{ $usuario->email }}" name='email'>
                                            </td>
                                            <td class="align-middle">
                                                <button type='submit' class='btn btn-primary'>Editar</button>
                                            </td>
                                        </form>
                                        <td class="align-middle">
                                            <form action="{{ route('admin.usuarios.destroy', $usuario->id) }}" method='post'>
                                                @csrf
                                                @method('DELETE')
                                                <button class='btn btn-danger' type='submit'>Borrar</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    {{ $usuarios->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
@endsection
