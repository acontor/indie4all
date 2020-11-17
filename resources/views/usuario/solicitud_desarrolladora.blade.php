@extends("layouts.usuario.base")

@section("content")
    <main class="py-4">
        <div class="container">
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
                    <label for="direccion">Dirección:</label>
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
                <button type="submit" class="btn btn-success mb-3">Enviar</button>
            </form>
        </div>
    </main>
@endsection
