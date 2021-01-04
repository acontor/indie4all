@extends("layouts.usuario.base")

@section('content')
    <main class="p-3 pb-5">
        <div class="container bg-light p-3 shadow-lg rounded mt-4">
            <form method="post" action="{{ route('usuario.desarrolladora.store') }}">
                @csrf
                <div class="form-group">
                    <label for="nombre">Nombre:</label>
                    <input type="text" class="form-control" name="nombre" />
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" name="email" />
                </div>
                <div class="form-group">
                    <label for="direccion">Dirección postal:</label>
                    <input type="text" class="form-control" name="direccion" />
                </div>
                <div class="form-group">
                    <label for="telefono">Teléfono:</label>
                    <input type="text" class="form-control" name="telefono" />
                </div>
                <div class="form-group">
                    <label for="url">Url:</label>
                    <input type="text" class="form-control" name="url" />
                </div>
                <div class="form-group">
                    <label for="comentario">Comentario:</label>
                    <textarea name="comentario" class="form-control" id="comentario" rows="5"></textarea>
                </div>
                <button type="submit" class="btn btn-success mb-3">Enviar</button>
            </form>
        </div>
    </main>
@endsection
