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
                    <h1>Nueva encuesta</h1>
                </div>
                <div class="box">
                    <form method="post" action="{{ route('cm.encuestas.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="pregunta">Pregunta:</label>
                            <input type="text" class="form-control" name="pregunta" />
                        </div>
                        <div class="form-group">
                            <label for="fecha_fin">Fecha de finalización:</label>
                            <input type="date" name="fecha_fin">
                        </div>
                        <div class="opciones">
                            <h3>Opciones (max. 10)</h3>
                            <div class="form-group">
                                <label for="opcion">Opción:</label>
                                <input type="text" class="form-control opcion" name="opcion1">
                            </div>
                            <div class="form-group">
                                <label for="opcion">Opción:</label>
                                <input type="text" class="form-control opcion" name="opcion2">
                            </div>
                        </div>
                        <div class="form-group botones-opciones">
                            <button class="btn btn-primary mas-opciones">+</button>
                            <button class="btn btn-danger menos-opciones disabled">-</button>
                        </div>
                        <button type="submit" class="btn btn-success mb-3">Crear</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section("scripts")
    <script>
        $(function() {
            $(".mas-opciones").click((e) => {
                e.preventDefault();
                if(!$(".mas-opciones").hasClass("disabled")) {
                    let num_opciones = $(".opcion").length;
                    $(".opciones").append(`<div class="form-group"><label for='opcion'>Opción:</label><input type="text" class='form-control opcion' name="opcion${num_opciones + 1}"></div>`);
                    if(num_opciones == 9) {
                        $(".mas-opciones").addClass("disabled");
                    }
                    if($(".menos-opciones").hasClass("disabled")) {
                        $(".menos-opciones").removeClass("disabled")
                    }
                }
            });

            $(".menos-opciones").click((e) => {
                e.preventDefault(e);
                if(!$(".menos-opciones").hasClass("disabled")) {
                let num_opciones = $(".opcion").length;
                    $(".opciones").children().eq(num_opciones).remove();
                    if(num_opciones == 3) {
                        $(".menos-opciones").addClass("disabled");
                    }
                    if($(".mas-opciones").hasClass("disabled")) {
                        $(".mas-opciones").removeClass("disabled")
                    }
                }
            });
        });

    </script>
@endsection
