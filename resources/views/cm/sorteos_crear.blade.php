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
                    <h1>Nuevo sorteo</h1>
                </div>
                <div class="box">
                    <form method="post" action="{{ route('cm.sorteos.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="titulo">Título:</label>
                            <input type="text" class="form-control" name="titulo" />
                        </div>
                        <div class="form-group">
                            <label for="descripcion">Descripción:</label>
                            <textarea class="form-control" name="descripcion"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="fecha_fin">Fecha de finalización:</label>
                            <input type="date" name="fecha_fin">
                        </div>
                        <button type="submit" class="btn btn-success mb-3">Crear</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
