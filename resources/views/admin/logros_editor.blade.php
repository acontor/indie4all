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
                @if(isset($logro))
                    <div class="box-header">
                        <h1 class='display-5'>Editar logro</h1>
                    </div>
                    <div class="box">
                        <form method='post' action="{{ route('admin.logros.update', $logro->id) }}" enctype="multipart/form-data">
                        @method('PATCH')
                    @else
                    <div class="box-header">
                        <h1 class='display-5'>Nuevo logro</h1>
                    </div>
                    <div class="box">
                        <form method='post' action="{{ route('admin.logros.store') }}" enctype="multipart/form-data">
                    @endif
                        @csrf
                            <div class='form-group'>
                                <label for='nombre'>Nombre:</label>
                                <input type='text' class='form-control' name='nombre' @if(isset($logro)) value="{{ $logro->nombre }}" @endif />
                            </div>
                            <div class='form-group'>
                                <label for='descripcion'>Descripción:</label>
                                <input type='text' class='form-control' name='descripcion' @if(isset($logro)) value="{{ $logro->descripcion }}" @endif />
                            </div>
                            <div class='form-group'>
                                <span class="btn btn-file">
                                    <i class="fas fa-upload"></i> Icono
                                    <input type='file' class='inputfile' name='icono' id='icono' />
                                </span>
                            </div>
                            <button type='submit' class='btn btn-success mb-3'>
                            @if(isset($logro))
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

