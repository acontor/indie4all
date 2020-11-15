@extends('layouts.cm.base')
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
                <div class="box-header">
                    @if (isset($campania))
                        <h1 class='display-5'>Editar Campaña</h1>
                    @else
                        <h1 class='display-5'>Nuevo Campaña</h1>
                    @endif

                </div>
                <form data-ui-jp="parsley" @if (isset($campania))
                action="{{ route('cm.campanias.update', $campania->id, $juego->id) }}" @else
                    action="{{ route('cm.campanias.store', $juego->id) }}"
                    @endif method="post">
                    @if (isset($campania)) @method('PATCH')
                    @else @method('POST') @endif
                    @csrf
                    <div class="box">
                        <div class='form-group'>
                            <label for='meta'>Meta:</label>

                            <input class="col-sm-1" type='text' class='form-control' name='meta' @if (isset($campania)) value="{{ $campania->meta }}" @endif/>€
                        </div>

                        <div class="form-group">
                            <label for='fecha_fin'>Fecha de finalización:</label>
                            <input type="date" name="fecha_fin" @if (isset($campania))
                            value="{{ $campania->fecha_fin }}" @endif>
                        </div>

                        <button type='submit' class='btn btn-success mb-3'>Crear</button>
                    </div>
            </div>
            </form>
        </div>
    </div>
    </div>
@endsection
