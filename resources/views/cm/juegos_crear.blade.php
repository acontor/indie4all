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
                <div class="box">
                    @if (isset($juego))
                        <h1 class="mb-4">Editar Juego</h1>
                    @else
                        <h1 class="mb-4">Nuevo Juego</h1>
                    @endif
               
                @if (isset($juego))
                    <form action="{{ route('cm.juegos.update', $juego->id) }}" method="post">
                    @method("PATCH")
                @else
                    <form action="{{ route('cm.juegos.store') }}" method="post">
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
                                <label id="btn-portada" class="btn btn-outline-dark mr-3">
                                    <i class="fas fa-upload"></i> Portada:
                                        <input type="file" id="imagen_portada" name="imagen_portada" @if(!isset($juego)) required="required" @endif onchange="readURL(this);">
                                </label>                                                   
                            <img src=""  height="100" width="100" id="blah" style="display: none"/>
                            </div>
                            <div class="form-group">
                                <label id="btn-caratula" class="btn btn-outline-dark">
                                    <i class="fas fa-upload"></i> Carátula:
                                    <input type="file" class="btn btn-primary" id="imagen_caratula" name="imagen_caratula" @if(!isset($juego)) required="required" @endif onchange="readURL2(this);">
                                </label>
                                <img src="" height="100" width="100" id="bloh" style="display: none"/>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success mb-3">Crear</button>
                    </form>
                </div>
            </div>
        </div>
        
    </div>
    @section("scripts")    
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
@endsection
