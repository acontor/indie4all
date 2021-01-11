@extends("layouts.usuario.base")
@section('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section("content")
    <div class="container">
        <div class="box-header mt-2">
            <h1>Campañas ({{ App\Models\Campania::count() }})</h1>
        </div>
        <div class="box p-3 mb-2">
            <div class="mt-2 form-row">
                <div class=" form-group col-12 col-md-4">
                    <input type="text" id="nombre" class="form-control" style="width:100%" placeholder="Nombre"/>
                </div>
                <div class=" form-group col-6 col-md-2">
                    <select id="ordenarPor" class="form-control col-md-2 select2">
                        <option value="">Ordenar por..</option>
                        <option value="recaudado">Recaudado</option>
                        <option value="meta">Meta</option>
                        <option value="seguidores_count">Participaciones</option>
                        <option value="aporte_minimo">Aporte mínimo</option>
                        <option value="fecha_fin">Fecha de finalización</option>

                    </select>
                </div>
                <div class=" form-group col-6 col-md-2">
                    <select id="ordenarDe" class="form-control col-md-2 select2">
                        <option value="DESC" selected>Descendiente</option>
                        <option value="ASC">Acendiente</option>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group mt-2 col-6 col-md-2">
                    <input type="text" id="aporteMinMin" class="form-control" style="width:100%" placeholder="Aporte desde"/>
                </div>
                <div class="form-group mt-2 col-6 col-md-2">
                    <input type="text" id="aporteMinMax" class="form-control" style="width:100%" placeholder="Aporte hasta"/>
                </div>
                <div id='aporteError' class="text-danger"></div>
                <div class="form-group col-md-12">
                    <button id='buscar' class=" col-sm-2 float-right form-control btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i>&nbspBuscar</button>
                </div>
            </div>
        </div>

        <div id="campania_data">
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
        $('#aporteMinMin').keyup(function(e){
            if (/\D/g.test(this.value)){
                this.value = this.value.replace(/\D/g, '');
                $(this).css("border-color", "red");
                $('#aporteError').text('Solo números.');
            }else{
                $(this).css("border-color", "#ced4da");
                $('#aporteError').text('');
            }
        });

        $('#aporteMinMax').keyup(function(e){
            if (/\D/g.test(this.value)){
                this.value = this.value.replace(/\D/g, '');
                $(this).css("border-color", "red");
                $('#aporteError').text('Solo números.');
            }else{
                $(this).css("border-color", "#ced4da");
                $('#aporteError').text('');
            }
        });;

        $('#ordenarPor').select2({
            language: 'es',
            width: '100%',
            placeholder: 'Ordenar por...',
            allowClear: true,
            dropdownAutoWidth: true
        });

        $('#ordenarDe').select2({
            language: 'es',
            width: '100%',
            placeholder: 'Ordenar de forma...',
            allowClear: true,
            dropdownAutoWidth: true
        });

        $("#buscar").on('click', function() {
            var nombre = $("#nombre").val();
            var ordenarPor = $("#ordenarPor").val();
            var ordenarDe = $("#ordenarDe").val();
            var aporteMinMin = $('#aporteMinMin').val()
            var aporteMinMax = $('#aporteMinMax').val()
            buscar(nombre,ordenarPor,ordenarDe,aporteMinMin,aporteMinMax)
        });

        function fetch_data(page){
            $.ajax({
                url:"/campanias/lista?page="+page,

                success:function(data){
                    $('#campania_data').html(data);
                }
            });
        }
        function buscar(nombre,ordenarPor,ordenarDe,aporteMinMin,aporteMinMax){
            $.ajax({
                url:"/campanias/lista?nombre="+nombre+'&ordenarPor='+ordenarPor +'&ordenarDe='+ordenarDe+'&aporteMinMin='+aporteMinMin+'&aporteMinMax='+aporteMinMax,

                success:function(data){
                    $('#campania_data').html(data);
                }
            });
        }
    });
        </script>
@endsection

