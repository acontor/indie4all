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
        @isset($campania)
            <nav id="submenu" class="navbar-expand-md navbar-light shadow bg-white mt-4 mb-4 pt-3 pb-3 text-center">
                <button class="navbar-toggler ml-1" type="button" data-toggle="collapse" data-target="#collapsingNavbar">
                    Menú <span class="navbar-toggler-icon"></span>
                </button>
                <div class="navbar-collapse collapse justify-content-between align-items-center w-100" id="collapsingNavbar">
                    <ul class="navbar-nav mx-auto submenu-items">
                        <li class="nav-item"><a class="nav-link" id="juego" href="">Campaña</a></li>
                        <li class="nav-item"><a class="nav-link" id="actualizaciones" href="">Actualizaciones</a></li>
                        <li class="nav-item"><a class="nav-link" id="participantes" href="">Participantes</a></li>
                    </ul>
                </div>
            </nav>
        @endisset
        <div id="main">
            <div class="box mt-4 juego">
                <h1 class="mb-4">@if (isset($campania)) Juego @else Nueva Campaña @endif</h1>
                @isset($campania)
                    @if($campania->ban)
                        <div class="row">
                            <span class="alert alert-danger w-100">
                                <p>Su campaña está suspendida por el siguiente motivo. Puedes corregir los problemas y contactar con soporte@indie4all.com para volver a publicarlo.</p>
                                <small>{{$campania->motivo}}</small>
                            </span>
                        </div>
                    @endif
                    <form action="{{ route('cm.campania.update', $campania->id) }}" method="post" enctype="multipart/form-data">
                        @method("PATCH")
                @else
                    <form action="{{ route('cm.campania.store') }}" method="post" enctype="multipart/form-data">
                @endisset
                        @csrf
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <label for="nombre">Título:</label>
                                <input type="text" class="form-control" name="nombre" @isset($campania)) value="{{ $campania->juego->nombre }}" @endisset/>
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
                                            @isset($campania)
                                                @if ($campania->juego->genero->id == $genero->id) selected @endif
                                            @endisset>
                                            {{ $genero->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6 mt-3">
                                <label for="fecha_lanzamiento">Fecha de lanzamiento:</label>
                                <input type="date" class="form-control" name="fecha_lanzamiento" @isset($juego) value="{{ $campania->juego->fecha_lanzamiento }}" @endisset>
                            </div>
                            <div class="col-12 col-md-6 mt-3">
                                <label for="precio">Precio:</label>
                                <input type="text" class="form-control" name="precio" @isset($campania) value="{{ $campania->juego->precio }}" @endisset>
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
                                @isset($campania)
                                    @if($campania->juego->imagen_portada)
                                        <img class="img-fluid" src="{{ asset('/images/desarrolladoras/' . $campania->juego->desarrolladora->nombre . '/' . $campania->juego->nombre . '/' . $campania->juego->imagen_portada) }}" id="imagen-portada" alt="Portada del juego" />
                                    @else
                                        <img class="img-fluid" src="{{ asset('/images/desarrolladoras/default-portada-juego.png') }}" id="imagen-portada" alt="Portada del juego" />
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
                                @isset($campania)
                                    @if($campania->juego->imagen_caratula)
                                        <img class="img-fluid" src="{{ asset('/images/desarrolladoras/' . $campania->juego->desarrolladora->nombre . '/' . $campania->juego->nombre . '/' . $campania->juego->imagen_caratula) }}" height="100" width="100" id="imagen-logo" alt="Logo del juego" />
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
                        <hr>
                        <h1 class="mb-4">Campaña</h1>
                        <div class="row">
                            <div class="col-12 col-md-4 mt-3">
                                <label for="meta">Meta €</label>
                                <input type="text" class="form-control" name="meta" value="@isset($campania){{ $campania->meta }}@endisset" />
                            </div>
                            <div class="col-12 col-md-4 mt-3">
                                <label for="meta">Aporte mínimo €</label>
                                <input type="text" class="form-control" name="aporte_minimo" value="@isset($campania){{ $campania->aporte_minimo }}@endisset" />
                            </div>
                            <div class="col-12 col-md-4 mt-3">
                                <label for="fecha_fin">Fecha de finalización:</label>
                                <input type="date" class="form-control" name="fecha_fin" value="@isset($campania){{ $campania->fecha_fin }}@endisset">
                            </div>
                        </div>
                        @isset($campania)
                            <hr class="mt-4 mb-3">
                            <div class="form-group">
                                <label>Contenido</label>
                                <textarea class="form-control" name="contenido" id="editor">
                                    {{ $campania->contenido }}
                                </textarea>
                            </div>
                            <div class="form-group">
                                <label>FAQ</label>
                                <textarea class="form-control" name="faq" id="faq">
                                    {{ $campania->faq }}
                                </textarea>
                            </div>
                        @endisset
                        <button type="submit" class="btn btn-success mb-3">@isset($campania) Editar @else Crear @endisset</button>
                    </form>
                </div>
                @isset($campania)
                    <div class="actualizaciones d-none">
                        <div class="box mt-4">
                            <h1 class="mb-4 d-inline-block">Actualizaciones</h1>
                            <a href="{{ route('cm.noticia.create', ['tipo' => 'campania', 'id' => $campania->id]) }}" class="btn btn-success btn-sm round float-right mt-2"><i class="far fa-plus-square"></i></a>
                            <div class="table-responsive">
                                <table class="table table-striped" id="tabla-actualizaciones">
                                    <thead>
                                        <tr>
                                            <td class="w-75">Título</td>
                                            <td class="w-25 text-center">Acciones</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($campania->posts as $post)
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
                    <div class="participantes d-none">
                        <div class="box mt-4">
                            <h1 class="mb-4">Participantes</h1>
                            <div class="table-responsive">
                                <table class="table table-striped" id="tabla-participantes">
                                    <thead>
                                        <tr>
                                            <td>Nombre de usuario</td>
                                            <td>Email</td>
                                            <td>Aporte</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($compras as $compra)
                                        <tr>
                                            <td>{{ $compra->participante->username }}</td>
                                            <td>{{ $compra->participante->email }}</td>
                                            <td>{{ $compra->precio }}</td>
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
    <script src="{{ asset('js/sweetalert/sweetalert.min.js') }}"></script>
    <script src="https://cdn.ckeditor.com/4.15.0/standard/ckeditor.js"></script>
    <script src="{{ asset('js/script.js') }}"></script>
    <script src="{{ asset('js/cm.js') }}"></script>
    <script>
        $(function() {
            $('#tabla-participantes').DataTable({
                "bAutoWidth": false,
                "responsive": true,
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
                },
                dom: 'Bfrtip',
                buttons: [
                    'csv', 'excel', 'pdf'
                ]
            });

            $("#tabla-actualizaciones").dataTable({
                "bAutoWidth": false,
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
                },
                "responsive": true,
                "columnDefs": [
                    { orderable: false, targets: -1 }
                ],
            });

            $(".menu").children("div").children("a").on('click', function(e) {
                e.preventDefault();
                let item = $(this).attr("id");
                $("#main").children("div").addClass("d-none");
                $(`.${item}`).removeClass("d-none");
            });

            CKEDITOR.replace("contenido", {
                filebrowserUploadUrl: "{{ route('cm.juego.upload', ['_token' => csrf_token()]) }}",
                filebrowserUploadMethod: "form"
            });

            CKEDITOR.replace("faq", {
                filebrowserUploadUrl: "{{ route('cm.juego.upload', ['_token' => csrf_token()]) }}",
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
