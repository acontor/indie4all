@extends("layouts.master.base")

@section('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section("content")
    <div class="container">
        <div class="box-header">
            <h1>Master @isset($perfil->nombre){{ $perfil->nombre }}@endisset</h1>
        </div>
        <div class="box">
            <form method="post" action="{{ route('master.perfil.update', $perfil->id) }}" enctype="multipart/form-data">
                @method('PATCH')
                @csrf
                <div class="row">
                    <div class="col-12 col-md-6">
                        <label for="nombre">Nombre perfil: <i class="fas fa-info-circle pop-info"
                            data-content="Nombre que aparecerá en el perfil"
                            rel="popover" data-placement="bottom" data-trigger="hover"></i></label>
                        <input type="text" class="form-control name" name="nombre" value="@isset($perfil->nombre){{ $perfil->nombre }}@endisset" />
                        @error('nombre')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-12 col-md-6 mt-3 mt-md-0">
                        <label for="email">Email: <i class="fas fa-info-circle pop-info"
                            data-content="Email de contacto que aparecerá en el perfil"
                            rel="popover" data-placement="bottom" data-trigger="hover"></i></label>
                        <input type="email" class="form-control email" name="email" value="{{ $perfil->email }}" />
                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
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
                        @if($perfil->imagen_portada)
                            <img class="img-fluid p-2" src="{{url('/images/masters/' . $perfil->nombre . '/' . $perfil->imagen_portada)}}" height="512" width="1024" id="imagen-portada" alt="Portada del master" />
                        @else
                            <img class="img-fluid p-2" src="{{url('/images/masters/default-portada.png')}}" height="512" width="1024" id="imagen-portada" alt="Portada del master" />
                        @endif
                        @error('imagen_portada')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-12 col-md-6 mt-3 mt-md-0">
                        <label id="btn-logo" class="btn btn-outline-dark pop-info"
                        data-content="La imagen de portada debe ser en formato PNG y 256x256"
                        rel="popover" data-placement="bottom" data-trigger="hover">
                            <i class="fas fa-upload"></i> Logo:
                            <input type="file" class="btn btn-primary" name="imagen_logo" onchange="readURL('logo', this);">
                        </label>
                        <br>
                        @if($perfil->imagen_logo)
                            <img class="img-fluid" src="{{url('/images/masters/' . $perfil->nombre . '/' . $perfil->imagen_logo)}}" height="100" width="100" id="imagen-logo" alt="Logo del master" />
                        @else
                            <img class="img-fluid" src="{{url('/images/masters/default-logo.png')}}" height="100" width="100" id="imagen-logo" alt="Logo del master" />
                        @endif
                        @error('imagen_logo')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <hr class="mt-4 mb-4">
                <div class="form-group">
                    <label for="juegos">Juegos recomendados</label>
                    <br>
                    <select class="form-control select2" name="juegos[]" id="juegos" multiple>
                        @foreach ($analisis as $post)
                            <option value="{{ $post->juego->id }}" @if ($post->destacado) selected @endif>{{ $post->juego->nombre }}<option>
                        @endforeach
                    </select>
                </div>
                <hr class="mt-4 mb-4">
                <button type="submit" class="btn btn-success pop-info"
                    data-content="Enviar formulario" rel="popover"
                    data-placement="bottom" data-trigger="hover">Editar</button>
            </form>
        </div>
    </div>
@endsection

@section("scripts")
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script src="{{ asset('js/script.js') }}"></script>
    <script src="{{ asset('js/sweetalert/sweetalert.min.js') }}"></script>
    @if (Session::has('success'))
        <script defer>
            notificacionEstado('success', "{{ Session::get('success') }}");

        </script>
    @endif
@endsection
