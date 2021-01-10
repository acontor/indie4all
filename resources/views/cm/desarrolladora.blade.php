@extends("layouts.cm.base")

@section('styles')

<style>

    input[type="file"] {
    display: none;
}
.custom-file-upload {
    border: 1px solid #ccc;
    display: inline-block;
    padding: 6px 12px;
    cursor: pointer;
}
    </style>


@endsection

@section("content")
    <div class="container">
        <div class="row">
            <div class="col-sm">
                <div class="box-header">
                    <h1 class="d-inline-block">Desarrolladora {{ $desarrolladora->nombre }}</h1>
                </div>
                <div class="box">
                    <form method="post" action="{{ route('cm.desarrolladora.update',$desarrolladora->id) }} "enctype="multipart/form-data">
                        @method('PATCH')
                        @csrf
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <label for="nombre">Nombre: <i class="fas fa-info-circle pop-info"
                                    data-content="Nombre de la desarrolladora"
                                    rel="popover" data-placement="bottom" data-trigger="hover"></i></label>
                                <input type="text" class="form-control" name="nombre" value="@isset($desarrolladora->nombre){{ $desarrolladora->nombre }}@endisset" />
                                @error('nombre')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6 mt-3 mt-md-0">
                                <label for="email">Email: <i class="fas fa-info-circle pop-info"
                                    data-content="Email de contacto de la desarrolladora"
                                    rel="popover" data-placement="bottom" data-trigger="hover"></i></label>
                                <input type="email" class="form-control" name="email" value="{{ $desarrolladora->email }}" />
                                @error('email')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6 mt-3">
                                <label for="url">Url: <i class="fas fa-info-circle pop-info"
                                    data-content="Dirección de la desarrolladora"
                                    rel="popover" data-placement="bottom" data-trigger="hover"></i></label>
                                <input type="url" class="form-control" name="url" value="@isset($desarrolladora->url){{ $desarrolladora->url }}@endisset" />
                                @error('direccion')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6 mt-3">
                                <label for="email">Teléfono: <i class="fas fa-info-circle pop-info"
                                    data-content="Teléfono de contacto de la desarrolladora"
                                    rel="popover" data-placement="bottom" data-trigger="hover"></i></label>
                                <input type="text" class="form-control" name="telefono" value="{{ $desarrolladora->telefono }}" />
                                @error('telefono')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group mt-3">
                            <label for="nombre">Dirección: <i class="fas fa-info-circle pop-info"
                                data-content="Dirección de la desarrolladora"
                                rel="popover" data-placement="bottom" data-trigger="hover"></i></label>
                            <input type="text" class="form-control" name="direccion" value="@isset($desarrolladora->direccion){{ $desarrolladora->direccion }}@endisset" />
                            @error('direccion')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <hr class="mt-4 mb-4">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <label id="btn-portada" class="btn btn-outline-dark mr-3 pop-info"
                                data-content="La imagen de portada debe ser en formato PNG y 1024x512"
                                rel="popover" data-placement="bottom" data-trigger="hover">
                                    <i class="fas fa-upload"></i> Portada:
                                    <input type="file" name="imagen_portada" onchange="readURL('portada', this);">
                                </label>
                                <br>
                                @if($desarrolladora->imagen_portada)
                                    <img class="img-fluid p-2" src="{{ asset('/images/desarrolladoras/' . $desarrolladora->nombre . '/' . $desarrolladora->imagen_portada) }}" height="512" width="1024" id="imagen-portada" alt="Portada de la desarrolladora" />
                                @else
                                    <img class="img-fluid p-2" src="{{ asset('/images/desarrolladoras/default-portada-desarrolladora.png') }}" height="512" width="1024" id="imagen-portada" alt="Portada de la desarrolladora" />
                                @endif
                                @error('imagen_portada')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6 mt-3 mt-md-0">
                                <label id="btn-logo" class="btn btn-outline-dark pop-info"
                                data-content="La imagen de logo debe ser en formato PNG y 200x256"
                                rel="popover" data-placement="bottom" data-trigger="hover">
                                    <i class="fas fa-upload"></i> Logo:
                                    <input type="file" class="btn btn-primary" name="imagen_logo" onchange="readURL('logo', this);">
                                </label>
                                <br>
                                @if($desarrolladora->imagen_logo)
                                    <img class="img-fluid" src="{{ asset('/images/desarrolladoras/' . $desarrolladora->nombre . '/' . $desarrolladora->imagen_logo) }}" height="100" width="100" id="imagen-logo" alt="Logo de la desarrolladora" />
                                @else
                                    <img class="img-fluid" src="{{ asset('/images/desarrolladoras/default-logo-desarrolladora.png') }}" width="100" id="imagen-logo" alt="Logo de la desarrolladora" />
                                @endif
                                @error('imagen_logo')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <hr class="mt-4 mb-4">
                        <div class="form-group">
                            <label>Contenido</label>
                            <textarea class="form-control" name="contenido" id="editor">
                                {{ $desarrolladora->contenido }}
                            </textarea>
                        </div>
                        <button type="submit" class="btn btn-success mb-3">Editar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section("scripts")
    <script src="https://cdn.ckeditor.com/4.15.0/standard/ckeditor.js"></script>
    <script src="{{ asset('js/sweetalert/sweetalert.min.js') }}"></script>
    <script src="{{ asset('js/script.js') }}"></script>
    <script>
        $(function() {
            CKEDITOR.replace("contenido", {
                filebrowserUploadUrl: "{{ route('cm.desarrolladora.upload', ['_token' => csrf_token()]) }}",
                filebrowserUploadMethod: "form"
            });
        });

    </script>
    @if (Session::has('success'))
        <script defer>
            notificacionEstado('success', "{{ Session::get('success') }}");

        </script>
    @elseif(Session::has('error'))
        <script defer>
            notificacionEstado('error', "{{ Session::get('error') }}");

        </script>
    @endif
@endsection
