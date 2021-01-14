@extends("layouts.usuario.base")

@section("content")
    <main class="p-4">
        <div class="container mt-4">
            <div class="box-header mt-2">
                <h1>Masters ({{ App\Models\Master::count() }})</h1>
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
                                <select id="ordenarPor" class="form-control">
                                    <option value="nombre" selected>Alfabeticamente</option>
                                    <option value="posts_count">Actividad</option>
                                    <option value="seguidores_count">Seguidores</option>
                                </select>
                            </li>
                            <li class="nav-item m-2">
                                <select id="ordenarDe" class="form-control">
                                    <option value="ASC" selected>Acendente</option>
                                    <option value="DESC">Descendente</option>
                                </select>
                            </li>
                            <li class="nav-item m-2">
                                <button id='buscar' class="float-right form-control btn btn-sm btn-primary"><i class="fa fa-search" aria-hidden="true"></i></button>
                            </li>
                        </ul>
                    </div>
                </nav>
                <div id="masters_data" class="mt-4">
                    @include('usuario.pagination_data')
                </div>
            </div>
        </div>
    </main>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function(){
        $(document).on('click', '.pagination a', function(event){
            event.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            fetch_data(page);
        });

        $("#buscar").on('click', function() {
            var nombre = $("#nombre").val();
            var ordenarPor = $("#ordenarPor").val();
            var ordenarDe = $("#ordenarDe").val();
            buscar(nombre,ordenarPor,ordenarDe)
        });

        function fetch_data(page){
            $.ajax({
                url:"http://www.iestrassierra.net/alumnado/curso2021/DAWS/daws2021a1/indie4all/masters/lista?page="+page,

                success:function(data){
                    $('#masters_data').html(data);
                }
            });
        }
        function buscar(nombre,ordenarPor,ordenarDe){
            $.ajax({
                url:"http://www.iestrassierra.net/alumnado/curso2021/DAWS/daws2021a1/indie4all/masters/lista?nombre="+nombre+'&ordenarPor='+ordenarPor +'&ordenarDe='+ordenarDe,

                success:function(data){
                    $('#masters_data').html(data);
                }
            });
        }
    });
        </script>
@endsection

