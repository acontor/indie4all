@extends("layouts.admin.base")
@section("content")
    <div class="container">
        <div class="">
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
                @if(isset($usuario))
                    <div class="box-header">
                        <h1>Editar usuario</h1>
                    </div>
                    <div class="box">
                        <form method="post" action="{{ route('admin.usuarios.update', $usuario->id) }}">
                        @method("PATCH")
                @else
                    <div class="box-header">
                        <h1>Nuevo usuarios</h1>
                    </div>
                    <div class="box">
                        <form method="post" action="{{ route('admin.usuarios.store') }}">
                @endif
                            @csrf
                            <div class="form-group">
                                <label for="name">Nombre:</label>
                                <input type="text" class="form-control" name="name" @if(isset($usuario)) value="{{ $usuario->name }}" @endif />
                            </div>
                            <div class="form-group">
                                <label for="descripcion">Email:</label>
                                <input type="email" class="form-control" name="email" @if(isset($usuario)) value="{{ $usuario->email }}" @endif />
                            </div>
                            @if(!isset($usuario))
                                <div class="form-group">
                                    <label for="password">Contraseña:</label>
                                    <input type="password" class="form-control" name="password" />
                                </div>
                                <div class="form-group">
                                    <label for="password-confirm">Confirmar contraseña</label>
                                    <input type="password" class="form-control" name="password_confirmation">
                                </div>
                            @endif
                            <button type="submit" class="btn btn-success mb-3">
                                @if(isset($usuario))
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

