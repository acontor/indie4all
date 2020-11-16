@extends("layouts.cm.base")
@section("content")
    <div class="container">
        <div class="row">
            <div class="col-sm">
                @if ($errors->any())
                    <div class="alert alert-danger">
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
                        <h1>Editar Campaña</h1>
                    @else
                        <h1>Nuevo Campaña</h1>
                    @endif
                </div>
                <div class="box">
                    @if (isset($campania))
                    <form action="{{ route('cm.campanias.update', $campania->id, $juego->id) }}" method="post">
                        @method("PATCH")
                    @else
                    <form action="{{ route('cm.campanias.store', $juego->id) }}" method="post">
                    @endif
                        @csrf
                        <div class="form-group">
                            <label for="meta">Meta:</label>
                            <input class="col-sm-1" type="text" class="form-control" name="meta" @if (isset($campania)) value="{{ $campania->meta }}" @endif/>€
                        </div>
                        <div class="form-group">
                            <label for="fecha_fin">Fecha de finalización:</label>
                            <input type="date" name="fecha_fin" @if (isset($campania))
                            value="{{ $campania->fecha_fin }}" @endif>
                        </div>
                        <button type="submit" class="btn btn-success mb-3">Crear</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
