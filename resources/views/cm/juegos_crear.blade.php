@extends("layouts.cm.base")
@section("content")
    <div class="container">
        <div class="row">
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
                <div class="box-header">
                    @if (isset($juego))
                        <h1>Editar Juego</h1>
                    @else
                        <h1>Nuevo Juego</h1>
                    @endif
                </div>
                @if (isset($juego))
                    <form action="{{ route('cm.juegos.update', $juego->id) }}" method="post">
                    @method("PATCH")
                @else
                    <form action="{{ route('cm.juegos.store') }}" method="post">
                @endif
                    @csrf
                    <div class="box">
                        <div class="form-group">
                            <label for="nombre">Título:</label>
                            <input type="text" class="form-control" name="nombre" @if (isset($juego)) value="{{ $juego->nombre }}" @endif/>
                        </div>
                        <div class="form-group">
                            <label for="sinopsis">sinopsis:</label>
                            <textarea class="form-control" name="sinopsis"> @if (isset($juego)){{ $juego->sinopsis }}@endif</textarea>
                        </div>
                    </div>
                    <div class="box">
                        <div class="form-group">
                            <label for="fecha_lanzamiento">Fecha de lanzamiento:</label>
                            <input type="date" name="fecha_lanzamiento" @if (isset($juego)) value="{{ $juego->fecha_lanzamiento }}" @endif>
                            <label for="precio">Precio:</label>
                            <input type="text" name="precio" @if (isset($juego)) value="{{ $juego->precio }}" @endif>
                        </div>
                    </div>
                    <div class="box mt-3">
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
                                <span class="btn btn-file">
                                    <i class="fas fa-upload"></i>Portada:
                                    <input type="file" class="inputfile" name="imagen_portada" id="imagen_portada"
                                        @if (isset($juego)) value="{{ $juego->imagen_portada }}" @endif/>
                                </span>
                            </div>
                            <div class="form-group">
                                <span class="btn btn-file">
                                    <i class="fas fa-upload"></i> Carátula:
                                    <input type="file" class="inputfile" name="imagen_caratula" id="imagen_caratula"
                                        @if (isset($juego))
                                    value="{{ $juego->imagen_caratula }}" @endif />
                                </span>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success mb-3">Crear</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/i18n/es.js"></script>
    <script>
        $("#genero").select2({
            language: "es",
            width: "100%",
            placeholder: "generos...",
            allowClear: true,
            dropdownAutoWidth: true
        });

    </script>
@endsection
