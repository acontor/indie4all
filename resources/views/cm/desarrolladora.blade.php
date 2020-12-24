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
                        <div class="form-group">
                            <label for="nombre">Nombre:</label>
                            <input type="text" class="form-control name" name="nombre" value="{{ $desarrolladora->nombre }}" />
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" class="form-control email" name="email" value="{{ $desarrolladora->email }}" />
                        </div>
                        <div class="form-group">
                            <label for="direccion">Dirección:</label>
                            <input type="text" class="form-control direccion" name="direccion" value="{{ $desarrolladora->direccion }}" />
                        </div>
                        <div class="form-group">
                            <label for="telefono">Teléfono:</label>
                            <input type="text" class="form-control telefono" name="telefono" value="{{ $desarrolladora->telefono }}" />
                        </div>
                        <div class="form-group">
                            <label for="url">Url:</label>
                            <input type="text" class="form-control url" name="url" value="{{ $desarrolladora->url }}" />
                        </div>
                        <div class="form-group">
                            <label id="btn-logo" class="btn btn-outline-dark mr-3">
                                <i class="fas fa-upload"></i> Portada:
                                    <input type="file" id="imagen_logo" name="imagen_logo" @if(!isset($desarrolladora)) required="required" @endif onchange="readURL(this);">
                            </label>
                            <img class="img-fluid" id="blah" src="{{ asset('/images/desarrolladoras/'.$desarrolladora->imagen_logo) }}" style="height: 200px;">
                        </div>
                        <div class="form-group">
                            <label>Contenido</label>
                            <textarea class="form-control" name="contenido" id="editor">
                             {{$desarrolladora->contenido}}
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
    <script>
        $(function() {
            CKEDITOR.replace("contenido", {
                filebrowserUploadUrl: "{{ route('cm.desarrolladora.upload', ['_token' => csrf_token()]) }}",
                filebrowserUploadMethod: "form"
            });

            $(".name").keyup(function() {
                $(".desarrolladora_nombre").text($(this).val());
            });

            $(".email").keyup(function() {
                $(".desarrolladora_email").text($(this).val());
            });

            $(".direccion").keyup(function() {
                $(".desarrolladora_direccion").text($(this).val());
            });

            $(".url").keyup(function() {
                $(".desarrolladora_url").text($(this).val());
            });

            $(".telefono").keyup(function() {
                $(".desarrolladora_telefono").text($(this).val());
            });

            $(".menu").children("div").children("a").click(function(e) {
                e.preventDefault();
                let item = $(this).attr("id");
                $("#contenido").children("div").addClass("d-none");
                $(`.${item}`).removeClass("d-none");
            });
        });
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#blah').attr('src', e.target.result);
                    $('#blah').css('display','block'); 
                    $('#btn-logo').removeClass("btn-outline-dark");
                    $('#btn-logo').addClass('btn-primary')
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection
