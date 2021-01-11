@extends("layouts.usuario.base")
@section('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section("content")
    <div class="container">
        <div class="box-header mt-2">
            <h1>Desarrolladoras ({{ App\Models\Desarrolladora::count() }})</h1>
        </div>
        <div class="box p-3 mb-2 rounded">
            <div class="form-row">
                <div class=" form-group mt-2 col-12 col-md-4">
                    <input type="text" id="nombre" class="form-control" style="width:100%" placeholder="Nombre"/>
                </div>
                <div class=" form-group mt-2 col-6 col-md-2">
                    <select id="ordenarPor" class="form-control col-md-2 select2">
                        <option value="">Ordenar por..</option>
                        <option value="nombre">Alfabeticamente</option>
                        <option value="posts_count">Actividad</option>
                        <option value="seguidores_count">Seguidores</option>
                        <option value="juegos_count">Juegos</option>
                        <option value="sorteos_count">Sorteos</option>
                        <option value="encuestas_count">Encuestas</option>
                    </select>
                </div>
                <div class=" form-group mt-2 col-6 col-md-2">
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

        <div id="desarrolladoras_data">
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
            buscar(nombre,ordenarPor,ordenarDe)
        });

        function fetch_data(page){
            $.ajax({
                url:"/desarrolladoras/lista?page="+page,

                success:function(data){
                    $('#desarrolladoras_data').html(data);
                }
            });
        }
        function buscar(nombre,ordenarPor,ordenarDe){
            $.ajax({
                url:"/desarrolladoras/lista?nombre="+nombre+'&ordenarPor='+ordenarPor +'&ordenarDe='+ordenarDe,

                success:function(data){
                    $('#desarrolladoras_data').html(data);
                }
            });
        }
    });
        </script>
@endsection

