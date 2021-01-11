@extends("layouts.usuario.base")

@section("content")
    <main class="p-4">
        <div class="container mt-4">
            <div class="box-header mt-2">
                <h1>Desarrolladoras ({{ App\Models\Desarrolladora::where('ban', 0)->count() }})</h1>
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
                                    <option value="">Ordenar por..</option>
                                    <option value="nombre">Alfabeticamente</option>
                                    <option value="posts_count">Actividad</option>
                                    <option value="seguidores_count">Seguidores</option>
                                    <option value="juegos_count">Juegos</option>
                                    <option value="sorteos_count">Sorteos</option>
                                    <option value="encuestas_count">Encuestas</option>
                                </select>
                            </li>
                            <li class="nav-item m-2">
                                <select id="ordenarDe" class="form-control">
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
                <div id="desarrolladoras_data" class="box mt-4">
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

