@extends("layouts.admin.base")

@section("content")
    <div class="container">
        <div class="row">
            <div class="col-sm">
                <div class="box-header">
                    <h1>@isset($post)Editar @else Nuevo @endisset usuario</h1>
                </div>
                <div class="box">
                    @isset($usuario)
                        <form method="post" action="{{ route('admin.usuarios.update', $usuario->id) }}">
                            @method("PATCH")
                    @else
                        <form method="post" action="{{ route('admin.usuarios.store') }}">
                    @endisset
                            @csrf
                            <div class="form-group">
                                <label for="name">Nombre:</label>
                                <input type="text" class="form-control" name="name" @isset($usuario) value="{{ $usuario->name }}" @endisset />
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="username">Nombre de usuario:</label>
                                <input type="text" class="form-control" name="username" @isset($usuario) value="{{ $usuario->username }}" @endisset />
                                @error('username')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="descripcion">Email:</label>
                                <input type="email" class="form-control" name="email" @isset($usuario) value="{{ $usuario->email }}" @endisset />
                                @error('email')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            @if(!isset($usuario))
                                <div class="form-group">
                                    <label for="password">Contraseña:</label>
                                    <input type="password" class="form-control" name="password" />
                                </div>
                                <div class="form-group">
                                    <label for="password-confirm">Confirmar contraseña</label>
                                    <input type="password" class="form-control" name="password_confirmation">
                                    @error('password')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            @endif
                            <button type="submit" class="btn btn-success">@isset($post) Editar @else Crear @endisset</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

