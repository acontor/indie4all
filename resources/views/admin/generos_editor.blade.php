@extends('layouts.admin.base')
@section('content')
    <div class="container">
        <div class='row'>
            <div class='col-sm'>
                @if ($errors->any())
                    <div class='alert alert-danger'>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <br />
                @endif
                @if(isset($genero))
                    <div class="box-header">
                        <h1 class='display-5'>Editar género</h1>
                    </div>
                    <div class="box">
                        <form method='post' action="{{ route('admin.generos.update', $genero->id) }}">
                        @method('PATCH')
                    @else
                    <div class="box-header">
                        <h1 class='display-5'>Nuevo género</h1>
                    </div>
                    <div class="box">
                        <form method='post' action="{{ route('admin.generos.store') }}">
                    @endif
                        @csrf
                            <div class='form-group'>
                                <label for='nombre'>Nombre:</label>
                                <input type='text' class='form-control' name='nombre' @if(isset($genero)) value="{{ $genero->nombre }}" @endif />
                            </div>
                            <button type='submit' class='btn btn-success mb-3'>
                            @if(isset($genero))
                                Editar
                            @else
                                Añadir
                            @endif
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

