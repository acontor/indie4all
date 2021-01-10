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
        @if (isset($juego))
        <div class="row box text-center menu mb-4">
            <div class="col-4"><a id="editar" href="">Juego</a></div>
            <div class="col-4"><a id="claves" href="">Claves</a></div>
            <div class="col-4"><a id="noticias" href="">Noticias</a></div>
        </div>
        <div id="main">
            <div class="editar">
                <div class="box mt-4">
                    <h1 class="mb-4">Editar Juego</h1>
        @else
            <div class="nuevo">
                <div class="box mt-4">
                    <h1 class="mb-4">Nuevo Juego</h1>
        @endif
        @if (isset($juego))
                    <form action="{{ route('cm.juego.update', $juego->id) }}" method="post" enctype="multipart/form-data">
                    @method("PATCH")
        @else
                    <form action="{{ route('cm.juego.store') }}" method="post" enctype="multipart/form-data">
        @endif
                    @csrf
                        <div class="form-group">
                            <label for="nombre">Título:</label>
                            <input type="text" class="form-control" name="nombre" @if (isset($juego)) value="{{ $juego->nombre }}" @endif/>
                        </div>
                        <div class="form-group">
                            <label for="sinopsis">sinopsis:</label>
                            <textarea class="form-control" name="sinopsis"> @if (isset($juego)){{ $juego->sinopsis }}@endif</textarea>
                        </div>
                        <div class="form-group">
                            <label for="fecha_lanzamiento">Fecha de lanzamiento:</label>
                            <input type="date" name="fecha_lanzamiento" @if (isset($juego)) value="{{ $juego->fecha_lanzamiento }}" @endif>
                            <label for="precio">Precio:</label>
                            <input type="text" name="precio" @if (isset($juego)) value="{{ $juego->precio }}" @endif>
                        </div>
                        <div class="row">
                            <div class="form-group  col-sm-5">
                                <label for="genero_id">Género</label>
                                <select id="genero_id" class="form-control select2" data-ui-jp="select2" data-ui-options="{theme: 'bootstrap'}" name="genero_id">
                                    <option value="">Género</option>
                                    @foreach ($generos as $genero)
                                        <option value="{{ $genero->id }}"
                                            @if (isset($juego))
                                                @if ($juego->genero->id == $genero->id) selected @endif
                                            @endif>
                                            {{ $genero->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label id="btn-portada" class="btn btn-outline-dark mr-3">
                                    <i class="fas fa-upload"></i> Portada:
                                        <input type="file" id="imagen_portada" name="imagen_portada" @if(!isset($juego)) required="required" @endif onchange="readURL(this);">
                                </label>
                                @if(isset($juego))
                                <img  src="{{ asset('/images/juegos/portadas/'.$juego->imagen_portada) }}" height="100" width="100" id="blah" />
                            @else
                                <img src=""  height="100" width="100" id="blah" style="display: none"/>
                            @endif
                            </div>
                            <div class="form-group">
                                <label id="btn-caratula" class="btn btn-outline-dark">
                                    <i class="fas fa-upload"></i> Carátula:
                                    <input type="file" class="btn btn-primary" id="imagen_caratula" name="imagen_caratula" @if(!isset($juego)) required="required" @endif onchange="readURL2(this);">
                                </label>
                            @if(isset($juego))
                                <img  src="{{ asset('/images/juegos/caratulas/'.$juego->imagen_caratula) }}" height="100" width="100" id="bloh" />
                            @else
                                <img src=""  height="100" width="100" id="bloh" style="display: none"/>
                            @endif
                            </div>
                        </div>
                        @if(isset($juego))
                            <div class="form-group">
                                <label>Contenido</label>
                                <textarea class="form-control" name="contenido" id="editor">
                                        {{ $juego->contenido }}
                                </textarea>
                            </div>
                        @endif
                        <button type="submit" class="btn btn-success">@if(isset($juego)) Editar @else Crear @endif</button>
                    </form>
                </div>
            </div>
            @if(isset($juego))
                <div class="claves d-none">
                    <div class="box mt-4">
                        <h1 class="mb-4 d-inline-block">Claves para {{ $juego->nombre }} ({{ $juego->claves->count() }})</h1>
                        <form class="float-right mt-2" action="{{ route('cm.claves.destroy', $juego->id) }}" method="post">
                            @csrf
                            @method("DELETE")
                            <button class="btn btn-danger btn-sm ml-1" type="submit">
                                Delete all <i class="far fa-trash-alt"></i>
                            </button>
                        </form>
                        <form action="{{ route('cm.claves.import') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group mb-4" style="max-width: 500px; margin: 0 auto;">
                                <div class="custom-file text-left">
                                    <input type="hidden" name="juego" value="{{ $juego->id }}">
                                    <input type="file" name="csv" class="custom-file-input" id="customFile">
                                    <label class="custom-file-label" for="customFile">Choose file</label>
                                </div>
                            </div>
                            <button class="btn btn-primary">Import data</button>
                        </form>
                        <div class="row mt-5">
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
                <div class="noticias d-none">
                    <div class="box mt-4">
                        <h1 class="mb-4 d-inline-block">Noticias</h1>
                        <a href="{{ route('cm.noticia.create', ['tipo' => 'juego', 'id' => $juego->id]) }}" class="btn btn-success btn-sm round float-right mt-2"><i class="far fa-plus-square"></i></a>
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
                                                <form action="{{ route('cm.noticia.edit', $post->id) }}" method="post">
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
            @endif
        </div>
    </div>
@endsection

@section("scripts")
    <script src="https://cdn.ckeditor.com/4.15.0/standard/ckeditor.js"></script>
    <script>
        $(function() {
            $(".menu").children("div").children("a").click(function(e) {
                console.log($(this).attr("id"))
                e.preventDefault();
                let item = $(this).attr("id");
                $("#main").children("div").addClass("d-none");
                $(`.${item}`).removeClass("d-none");
            });

            CKEDITOR.replace("contenido", {
                filebrowserUploadUrl: "{{ route('cm.juego.upload', ['_token' => csrf_token()]) }}",
                filebrowserUploadMethod: "form"
            });
        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#blah').attr('src', e.target.result);
                    $('#blah').css('display','block');
                    $('#btn-portada').removeClass("btn-outline-dark");
                    $('#btn-portada').addClass('btn-primary')
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        function readURL2(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#bloh').attr('src', e.target.result);
                    $('#bloh').css('display','block');
                    $('#btn-caratula').removeClass("btn-outline-dark");
                    $('#btn-caratula').addClass('btn-primary')
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

    </script>
@endsection
