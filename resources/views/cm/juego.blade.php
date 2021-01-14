@extends("layouts.cm.base")

@section('styles')
    <link href="{{ asset('css/datatable/datatable.css') }}" rel="stylesheet">
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
        @isset($juego)
            <nav id="submenu" class="navbar-expand-md navbar-light shadow bg-white mt-4 mb-4 pt-3 pb-3 text-center">
                <button class="navbar-toggler ml-1" type="button" data-toggle="collapse" data-target="#collapsingNavbar">
                    Menú <span class="navbar-toggler-icon"></span>
                </button>
                <div class="navbar-collapse collapse justify-content-between align-items-center w-100" id="collapsingNavbar">
                    <ul class="navbar-nav mx-auto submenu-items">
                        <li class="nav-item"><a class="nav-link" id="juego" href="">Juego</a></li>
                        <li class="nav-item"><a class="nav-link" id="claves" href="">Claves</a></li>
                        <li class="nav-item"><a class="nav-link" id="noticias" href="">Noticias</a></li>
                    </ul>
                </div>
            </nav>
        @endisset
        <div id="main">
            <div class="box mt-4 juego">
                <h1 class="mb-4">@isset($juego) Editar @else Nuevo @endisset Juego</h1>
                @isset($juego)
                    @if($juego->ban)
                        <div class="row">
                            <span class="alert alert-danger w-100">
                                <p>Su juego está suspendido por el siguiente motivo. Puedes corregir los problemas y contactar con soporte@indie4all.com para volver a publicarlo.</p>
                                <small>{{$juego->motivo}}</small>
                            </span>
                        </div>
                    @endif
                    <form class="mt-3" action="{{ route('cm.juego.update', $juego->id) }}" method="post" enctype="multipart/form-data">
                        @method("PATCH")
                @else
                    <form action="{{ route('cm.juego.store') }}" method="post" enctype="multipart/form-data">
                @endisset
                        @csrf
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <label for="nombre">Título:</label>
                                <input type="text" class="form-control" name="nombre" @isset($juego)) value="{{ $juego->nombre }}" @endisset/>
                                @error('nombre')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="genero_id">Género</label>
                                <select id="genero_id" class="form-control select2" data-ui-jp="select2" data-ui-options="{theme: 'bootstrap'}" name="genero_id">
                                    <option value="">Género</option>
                                    @foreach ($generos as $genero)
                                        <option value="{{ $genero->id }}"
                                            @isset($juego)
                                                @if ($juego->genero->id == $genero->id) selected @endif
                                            @endisset>
                                            {{ $genero->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6 mt-3">
                                <label for="fecha_lanzamiento">Fecha de lanzamiento:</label>
                                <input type="date" class="form-control" name="fecha_lanzamiento" @if (isset($juego)) value="{{ $juego->fecha_lanzamiento }}" @endif>
                            </div>
                            <div class="col-12 col-md-6 mt-3">
                                <label for="precio">Precio:</label>
                                <input type="text" class="form-control" name="precio" @if (isset($juego)) value="{{ $juego->precio }}" @endif>
                            </div>
                        </div>
                        <hr class="mt-4">
                        <div class="row">
                            <div class="col-12 col-md-6 mt-3">
                                <label id="btn-portada" class="btn btn-outline-dark mr-3 pop-info"
                                data-content="La imagen de portada debe ser en formato PNG y 1024x512"
                                rel="popover" data-placement="bottom" data-trigger="hover">
                                    <i class="fas fa-upload"></i> Portada:
                                    <input type="file" name="imagen_portada" onchange="readURL('portada', this);">
                                </label>
                                <br>
                                @isset($juego)
                                    @if($juego->imagen_portada)
                                        <img class="img-fluid p-2" src="{{ asset('/images/desarrolladoras/' . $juego->desarrolladora->nombre . '/' . $juego->nombre . '/' . $juego->imagen_portada) }}" height="512" width="1024" id="imagen-portada" alt="Portada del juego" />
                                    @else
                                        <img class="img-fluid p-2" src="{{ asset('/images/desarrolladoras/default-portada-juego.png') }}" height="512" width="1024" id="imagen-portada" alt="Portada del juego" />
                                    @endif
                                @else
                                    <img class="img-fluid p-2" src="{{ asset('/images/desarrolladoras/default-portada-juego.png') }}" height="512" width="1024" id="imagen-portada" alt="Portada del juego" />
                                @endisset
                                @error('imagen_portada')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6 mt-3">
                                <label id="btn-logo" class="btn btn-outline-dark pop-info"
                                data-content="La imagen de logo debe ser en formato PNG y 200x256"
                                rel="popover" data-placement="bottom" data-trigger="hover">
                                    <i class="fas fa-upload"></i> Logo:
                                    <input type="file" class="btn btn-primary" name="imagen_caratula" onchange="readURL('caratula', this);">
                                </label>
                                <br>
                                @isset($juego)
                                    @if($juego->imagen_caratula)
                                        <img class="img-fluid" src="{{ asset('/images/desarrolladoras/' . $juego->desarrolladora->nombre . '/' . $juego->nombre . '/' . $juego->imagen_caratula) }}" height="100" width="100" id="imagen-logo" alt="Logo del juego" />
                                    @else
                                        <img class="img-fluid" src="{{ asset('/images/desarrolladoras/default-logo-juego.png') }}" width="100" id="imagen-caratula" alt="Logo del juego" />
                                    @endif
                                @else
                                    <img class="img-fluid" src="{{ asset('/images/desarrolladoras/default-logo-juego.png') }}" width="100" id="imagen-caratula" alt="Logo del juego" />
                                @endisset
                                @error('imagen_caratula')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <hr class="mt-4">
                        @isset($juego)
                            <div class="form-group">
                                <label>Contenido</label>
                                <textarea class="form-control" name="contenido" id="editor">
                                        {{ $juego->contenido }}
                                </textarea>
                            </div>
                        @endisset
                        <button type="submit" class="btn btn-success">@if(isset($juego)) Editar @else Crear @endif</button>
                    </form>
                </div>
                @isset($juego)
                    <div class="claves d-none">
                        <div class="box mt-4">
                            <h1 class="mb-4 d-inline-block">Claves para {{ $juego->nombre }} ({{ $juego->claves->count() }})</h1>
                            <div class="form-group mb-3">
                                <form action="{{ route('cm.claves.import') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="custom-file text-left">
                                        <input type="hidden" name="juego" value="{{ $juego->id }}">
                                        <input type="file" name="csv" class="custom-file-input" id="customFile">
                                        <label class="custom-file-label" for="customFile">Escoge un fichero xlsx</label>
                                    </div>
                                    <button class="btn btn-primary mb-2">Importar claves</button>
                                </form>
                                <form action="{{ route('cm.claves.destroy', $juego->id) }}" method="post">
                                    @csrf
                                    @method("DELETE")
                                    <button class="btn btn-danger mb-3" type="submit">
                                        Eliminar todas <i class="far fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                            <div class="row mt-5">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <td class="w-75">Clave</td>
                                                <td class="w-25 text-center">Acciones</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($juego->claves as $clave)
                                            <tr>
                                                <td class="align-middle">{{ $clave->key }}</td>
                                                <td class="align-middle text-center">
                                                    <div class="btn-group">
                                                        <form action="{{ route('cm.clave.destroy', $clave->id) }}" method="post">
                                                            @csrf
                                                            @method("DELETE")
                                                            <button class="btn btn-danger btn-sm round ml-1" type="submit">
                                                                <i class="far fa-trash-alt"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="noticias d-none">
                        <div class="box mt-4">
                            <h1 class="mb-4 d-inline-block">Noticias</h1>
                            <a href="{{ route('cm.noticia.create', ['tipo' => 'juego', 'id' => $juego->id]) }}" class="btn btn-success btn-sm round float-right mt-2"><i class="far fa-plus-square"></i></a>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <td class="w-75">Título</td>
                                            <td class="w-25 text-center">Acciones</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($juego->posts as $post)
                                            <tr>
                                                <td class="align-middle">{{ $post->titulo }}</td>
                                                <td class="align-middle text-center">
                                                    <div class="btn-group">
                                                        <form action="{{ route('cm.noticia.edit', $post->id) }}" method="get">
                                                            @csrf
                                                            <button class="btn btn-primary btn-sm round mr-1" type="submit">
                                                                <i class="far fa-edit"></i>
                                                            </button>
                                                        </form>
                                                        <form action="{{ route('cm.noticia.destroy', $post->id) }}" method="post">
                                                            @csrf
                                                            @method("DELETE")
                                                            <button class="btn btn-danger btn-sm round ml-1" type="submit">
                                                                <i class="far fa-trash-alt"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endisset
            </div>
        </div>
    </div>
@endsection

@section("scripts")
    <script src="{{ asset('js/datatable/datatable.js') }}"></script>
    <script src="{{ asset('js/datatable/script.js') }}"></script>
    <script src="https://cdn.ckeditor.com/4.15.0/standard/ckeditor.js"></script>
    <script src="{{ asset('js/script.js') }}"></script>
    <script src="{{ asset('js/cm.js') }}"></script>
    <script>
        $(function() {
            if($('h1').text().split(' ')[1] != "Nuevo") {
                CKEDITOR.replace("contenido", {
                    filebrowserUploadUrl: "{{ route('cm.juego.upload', ['_token' => csrf_token()]) }}",
                    filebrowserUploadMethod: "form"
                });
            }
        });

    </script>
@endsection
