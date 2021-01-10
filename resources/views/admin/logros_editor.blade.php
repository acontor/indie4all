@extends("layouts.admin.base")

@section("content")
    <div class="container">
        <div class="row">
            <div class="col-sm">
                <div class="box-header">
                    <h1>@isset($logro)Editar @else Nuevo @endisset logro</h1>
                </div>
                <div class="box">
                    @isset($logro)
                        <form method="post" action="{{ route('admin.logros.update', $logro->id) }}" enctype="multipart/form-data">
                            @method("PATCH")
                    @else
                        <form method="post" action="{{ route('admin.logros.store') }}" enctype="multipart/form-data">
                    @endisset
                        @csrf
                            <div class="form-group">
                                <label for="nombre">Nombre:</label>
                                <input type="text" class="form-control" name="nombre" @isset($logro) value="{{ $logro->nombre }}" @endisset />
                                @error('nombre')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="descripcion">Descripción:</label>
                                <input type="text" class="form-control" name="descripcion" @isset($logro) value="{{ $logro->descripcion }}" @endisset />
                                @error('descripcion')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="icono">Icono:</label>
                                <input type="text" class="form-control" name="icono" @isset($logro) value="{{ $logro->icono }}" @endisset />
                                @error('icono')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-success">@isset($logro) Editar @else Crear @endisset</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

