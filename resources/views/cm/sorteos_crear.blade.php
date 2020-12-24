@extends("layouts.cm.base")

@section("content")
    <div class="container">
        <div class="row">
            <div class="col-sm">
                <div class="box-header">
                    @if(isset($sorteo))
                        <h1>Editar sorteo</h1>
                    @else
                        <h1>Nuevo sorteo</h1>
                    @endif
                </div>
                <div class="box">
                    @isset($sorteo)
                        <form method="post" action="{{ route('cm.sorteo.update', $sorteo->id) }}">
                        @method('PATCH')
                    @else
                        <form method="post" action="{{ route('cm.sorteo.store') }}">
                    @endisset
                        @csrf
                        <div class="form-group">
                            <label for="titulo">Título:</label>
                            <input type="text" class="form-control" name="titulo" @isset($sorteo) value="{{$sorteo->titulo}} @endisset" />
                        </div>
                        <div class="form-group">
                            <label for="descripcion">Descripción:</label>
                            <textarea class="form-control" name="descripcion">@isset($sorteo) {{$sorteo->descripcion}} @endisset</textarea>
                        </div>
                        <div class="form-group">
                            <label for="fecha_fin">Fecha de finalización:</label>
                            <input type="date" name="fecha_fin" @isset($sorteo) value="{{$sorteo->fecha_fin}}" @endisset>
                        </div>
                        <button type="submit" class="btn btn-success mb-3">Crear</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
