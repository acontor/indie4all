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
        @if (isset($campania))
            <div class="row box text-center menu mb-4">
                <div class="col-4"><a id="juego" href="">Juego</a></div>
                <div class="col-4"><a id="campania" href="">Campaña</a></div>
                <div class="col-4"><a id="actualizaciones" href="">Actualizaciones</a></div>
                <div class="col-4"><a id="participantes" href="">Participantes</a></div>
            </div>
            <div id="main">
                <div class="juego">
                    <div class="box mt-4">
                        <h1 class="mb-4">Juego</h1>
        @else
            <div class="nuevo">
                <div class="box mt-4">
                    <h1 class="mb-4">Nueva Campaña</h1>
        @endif
        @if (isset($campania))
                        <form action="{{ route('cm.campania.update', $campania->id) }}" method="post" enctype="multipart/form-data">
                        @method("PATCH")
        @else
                        <form action="{{ route('cm.campania.store') }}" method="post" enctype="multipart/form-data">
        @endif
                        @csrf
                        <div class="form-group">
                            <label for="nombre">Título:</label>
                            <input type="text" class="form-control" name="nombre" @if (isset($campania)) value="{{ $campania->juego->nombre }}" @endif/>
                        </div>
                        <div class="form-group">
                            <label for="sinopsis">sinopsis:</label>
                            <textarea class="form-control" name="sinopsis"> @if (isset($campania)){{ $campania->juego->sinopsis }}@endif</textarea>
                        </div>
                        <div class="form-group mt-4">
                            <label for="fecha_lanzamiento">Fecha de lanzamiento:</label>
                            <input type="date" name="fecha_lanzamiento" @if (isset($campania)) value="{{ $campania->juego->fecha_lanzamiento }}" @endif>
                        </div>
                        <div class="form-group">
                            <label for="precio">Precio:</label>
                            <input type="text" name="precio" @if (isset($campania)) value="{{ $campania->juego->precio }}" @endif> €
                        </div>
                    </div>
                    <div class="box mt-3">
                        <div class="row">
                            <div class="form-group col-sm-5">
                                <label for="genero_id">Género</label>
                                <select id="genero_id" class="form-control select2" data-ui-jp="select2" data-ui-options="{theme: 'bootstrap'}" name="genero_id">
                                    <option value="">Género</option>
                                    @foreach ($generos as $genero)
                                        <option value="{{ $genero->id }}"@if (isset($campania) && $campania->juego->genero->id == $genero->id) selected @endif> {{ $genero->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <label id="btn-portada" class="btn btn-outline-dark mr-3">
                                    <i class="fas fa-upload"></i> Portada:
                                    <input type="file" id="imagen_portada" name="imagen_portada" @if(!isset($campania)) required="required" @endif onchange="readURL(this);">
                                </label>
                                @if(isset($campania))
                                    <img src="{{ asset('/images/juegos/portadas/'.$campania->juego->imagen_portada) }}" height="100" width="100" id="blah" />
                                @else
                                    <img src="" height="100" width="100" id="blah" style="display: none"/>
                                @endif
                            </div>
                            <div class="form-group ml-5">
                                <label id="btn-caratula" class="btn btn-outline-dark mr-3">
                                    <i class="fas fa-upload"></i> Carátula:
                                    <input type="file" class="btn btn-primary" id="imagen_caratula" name="imagen_caratula" @if(!isset($campania)) required="required" @endif onchange="readURL2(this);">
                                </label>
                                @if(isset($campania))
                                    <img src="{{ asset('/images/juegos/caratulas/'.$campania->juego->imagen_caratula) }}" height="100" width="100" id="bloh" />
                                @else
                                    <img src="" height="100" width="100" id="bloh" style="display: none"/>
                                @endif
                            </div>
                        </div>
                        @if(!isset($campania))
                        <div class="row">
                            <div class="form-group">
                                <label for="meta">Meta:</label>
                                <input type="text" class="form-control" name="meta" /> €
                            </div>
                            <div class="form-group">
                                <label for="fecha_fin">Fecha de finalización:</label>
                                <input type="date" name="fecha_fin">
                            </div>
                        </div>
                        @endif
                        <button type="submit" class="btn btn-success mb-3">@if (isset($campania)) Editar @else Crear @endif</button>
                    </form>
                </div>
            </div>
            @if(isset($campania))
            <div class="campania d-none">
                <div class="box mt-4">
                    <h1 class="mb-4">Campaña</h1>
                    <form action="{{ route('cm.campania.update', $campania->id, $campania->juego->id) }}" method="post">
                        @method("PATCH")
                        @csrf
                        <div class="form-group">
                            <label for="meta">Meta:</label>
                            <input class="col-sm-1" type="text" class="form-control" name="meta" value="{{ $campania->meta }}" /> €
                        </div>
                        <div class="form-group">
                            <label for="fecha_fin">Fecha de finalización:</label>
                            <input type="date" name="fecha_fin" value="{{ $campania->fecha_fin }}">
                        </div>
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
                        <button type="submit" class="btn btn-success mb-3">Editar</button>
                    </form>
                </div>
            </div>
            <div class="actualizaciones d-none">
                <div class="box mt-4">
                    <h1 class="mb-4">Actualizaciones</h1>
                    <table class="table table-striped">
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
                                            <form action="{{ route('admin.noticias.edit', $post->id) }}" method="post">
                                                @csrf
                                                <button class="btn btn-primary btn-sm round mr-1" type="submit">
                                                    <i class="far fa-edit"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.noticias.destroy', $post->id) }}" method="post">
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
            <div class="participantes d-none">
                <div class="box mt-4">
                    <h1 class="mb-4">Participantes</h1>
                    @foreach ($campania->posts as $post)
                        {{ $post->titulo }}
                        {{ $post->contenido }}
                    @endforeach
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

            CKEDITOR.replace("faq", {
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
