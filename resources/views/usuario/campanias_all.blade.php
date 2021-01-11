@extends("layouts.usuario.base")
@section('styles')
@endsection

@section("content")
    <main class="p-4">
        <div class="container mt-4">
            <div class="box-header mt-2">
                <h1>Campañas ({{ App\Models\Campania::where('ban', 0)->count() }})</h1>
            </div>
            <div class="box mt-4">
                <nav class="navbar navbar-expand-md navbar-light shadow bg-white mt-4 mb-4 pt-3 pb-3">
                    <button class="navbar-toggler mx-auto" type="button" data-toggle="collapse" data-target="#collapsingNavbar">
                        Filtros <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="navbar-collapse collapse justify-content-between align-items-center w-100" id="collapsingNavbar">
                        <ul class="navbar-nav mx-auto submenu-items">
                            <li class="nav-item m-2"><input type="text" id="nombre" class="form-control" style="width:100%" placeholder="Nombre"/></li>
                            <li class="nav-item m-2">
                                <input type="text" id="aporteMinMin" class="form-control" style="width:100%" placeholder="Aporte desde"/>
                            </li>
                            <li class="nav-item m-2">
                                <input type="text" id="aporteMinMax" class="form-control" style="width:100%" placeholder="Aporte hasta"/>
                            </li>
                            <li class="nav-item m-2">
                                <select id="ordenarPor" class="form-control">
                                    <option value="" selected>Ordenar por..</option>
                                    <option value="recaudado">Recaudado</option>
                                    <option value="meta">Meta</option>
                                    <option value="seguidores_count">Participaciones</option>
                                    <option value="aporte_minimo">Aporte mínimo</option>
                                    <option value="fecha_fin">Fecha de finalización</option>
                                </select>
                            </li>
                            <li class="nav-item m-2">
                                <select id="ordenarDe" class="form-control select2">
                                    <option value="DESC" selected>Descendiente</option>
                                    <option value="ASC">Acendiente</option>
                                </select>
                            </li>
                            <li class="nav-item m-2">
                                <button id='buscar' class="float-right form-control btn btn-sm btn-primary"><i class="fa fa-search" aria-hidden="true"></i></button>
                            </li>
                        </ul>
                    </div>
                </nav>
                <div id="campania_data">
                    @include('usuario.pagination_data')
                </div>
            </div>
        </div>
    </main>

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

