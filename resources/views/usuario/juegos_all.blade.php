@extends("layouts.usuario.base")
@section('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section("content")
    <div class="container">
        <div class="box-header mt-2">
            <h1>Juegos ({{ App\Models\Juego::doesnthave('campania')->count() }})</h1>
        </div>
        <div class="box p-3 rounded">
            <div class="mt-2 form-row">
                <div class=" form-group mt-2 col-12 col-md-6">
                    <input type="text" id="nombre" class="form-control" style="width:100%" placeholder="Nombre"/>
                </div>
                <div class="form-group mt-2 col-6 col-md-3">
                    <input type="text" id="precioMin" class="form-control" style="width:100%" placeholder="Precio mínimo"/>
                    <div id="precioErrorMin" class="text-danger"></div>
                </div>
                <div class="form-group mt-2 col-6 col-md-3">
                    <input type="text" id="precioMax" class="form-control" style="width:100%" placeholder="Precio máximo"/>
                    <div id="precioErrorMax" class="text-danger"></div>
                </div>
            </div>
            <div class="form-row mt-2 mb-1">
                <div class="form-group col-12 col-md-6 ">
                    <select id="genero" class="form-control select2">
                        <option value="">Género</option>
                        @foreach(App\Models\Genero::all(); as $genero)
                            <option class="extra" value="{{ $genero->id }}" @if($genero->id == $generoSelect) selected @endif>{{ $genero->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-12 col-md-6">
                    <select id="desarrolladora" class="form-control select2">
                        <option value="">Desarrolladora</option>
                        @foreach(App\Models\Desarrolladora::all(); as $desarrolladora)
                        <option class="extra" value="{{ $desarrolladora->id }}">{{ $desarrolladora->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="fechaDesde">Fecha de salida desde:</label>
                    <input type="date" id="fechaDesde">
                </div>
                <div class="form-group">
                    <label for="fechaHasta">Fecha de salida hasta:</label>
                    <input type="date" id="fechaHasta">
                </div>
                <div class=" form-group col-6 col-md-2">
                    <select id="ordenarPor" class="form-control col-md-2 select2">
                        <option value="nombre">Alfabeticamente</option>
                        <option value="precio">Precio</option>
                        <option value="fecha_lanzamiento">Fecha de lanzamiento</option>
                        <option value="genero_id">Género</option>
                    </select>
                </div>
                <div class=" form-group col-6 col-md-2">
                    <select id="ordenarDe" class="form-control col-md-2 select2">
                        <option value="DESC" selected>Descendiente</option>
                        <option value="ASC">Acendiente</option>
                    </select>
                </div>
                <div class="form-group col-md-12">
                    <button id='buscar' class=" col-sm-2 float-right form-control btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i>&nbspBuscar</button>
                </div>
            </div>
        </div>

        <div id="juegos_data">
        @include('usuario.pagination_data')
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function(){
        $(document).on('click', '.pagination a', function(event){
            event.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            fetch_data(page);
        });
        $('#precioMin').keyup(function(e){
            if (/\D/g.test(this.value)){
                this.value = this.value.replace(/\D/g, '');
                $(this).css("border-color", "red");
                $('#precioErrorMin').text('Solo números.');
            }else{
                $(this).css("border-color", "#ced4da");
                $('#precioErrorMin').text('');
            }
        });

        $('#precioMax').keyup(function(e){
            if (/\D/g.test(this.value)){
                this.value = this.value.replace(/\D/g, '');
                $(this).css("border-color", "red");
                $('#precioErrorMax').text('Solo números.');
            }else{
                $(this).css("border-color", "#ced4da");
                $('#precioErrorMax').text('');
            }
        });;

        $('#genero').select2({
            language: 'es',
            width: '100%',
            placeholder: 'Género...',
            allowClear: true,
            dropdownAutoWidth: true
        });

        $('#ordenarPor').select2({
            language: 'es',
            width: '100%',
            placeholder: 'Género...',
            allowClear: true,
            dropdownAutoWidth: true
        });
        $('#ordenarDe').select2({
            language: 'es',
            width: '100%',
            placeholder: 'Género...',
            allowClear: true,
            dropdownAutoWidth: true
        });

        $('#desarrolladora').select2({
            language: 'es',
            width: '100%',
            placeholder: 'Desarrolladora...',
            allowClear: true,
            dropdownAutoWidth: true
        });

        $("#buscar").on('click', function() {
            var nombre = $("#nombre").val();
            var genero = $("#genero").val();
            var desarrolladora = $("#desarrolladora").val();
            var precioMin = $("#precioMin").val();
            var precioMax = $("#precioMax").val();
            var fechaDesde = $("#fechaDesde").val();
            var fechaHasta = $('#fechaHasta').val();
            var ordenarPor = $("#ordenarPor").val();
            var ordenarDe = $('#ordenarDe').val();
            buscar(nombre,genero,desarrolladora,precioMin,precioMax,fechaDesde,fechaHasta,ordenarPor,ordenarDe)
        });

        function fetch_data(page){
            $.ajax({
                url:"/juegos/lista?page="+page,

                success:function(data){
                    $('#juegos_data').html(data);
                }
            });
        }
        function buscar(nombre,genero,desarrolladora,precioMin,precioMax,fechaDesde,fechaHasta,ordenarPor,ordenarDe){
            $.ajax({
                url:"/juegos/lista?nombre="+nombre+'&genero='+genero +'&desarrolladora='+desarrolladora+'&precioMin='+precioMin+'&precioMax='+precioMax+'&fechaDesde='+fechaDesde+'&fechaHasta='+fechaHasta+'&ordenarPor='+ordenarPor+'&ordenarDe='+ordenarDe,

                success:function(data){
                    $('#juegos_data').html(data);
                }
            });
        }
    });
        </script>
@endsection

