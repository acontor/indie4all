@extends("layouts.admin.base")

@section("content")
    <div class="container">
        <div class="row">
            <div class="col-sm">
                <div class="box-header">
                    <h1>@isset($genero)Editar @else Nuevo @endisset género</h1>
                </div>
                <div class="box">
                    @isset($genero)
                        <form method="post" action="{{ route('admin.generos.update', $genero->id) }}">
                            @method("PATCH")
                    @else
                        <form method="post" action="{{ route('admin.generos.store') }}">
                    @endisset
                        @csrf
                            <div class="form-group">
                                <label for="nombre">Nombre:</label>
                                <input type="text" class="form-control" name="nombre" @isset($genero) value="{{ $genero->nombre }}" @endisset />
                                @error('nombre')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-success">@isset($genero) Editar @else Crear @endisset</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
