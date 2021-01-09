@extends("layouts.usuario.base")
@section('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section("content")
    <div class="container">
        <div class="box-header mt-2">
            <h1>Juegos ({{ App\Models\Juego::count() }})</h1>
        </div>
        <div class="box p-3 rounded">
            <div class="mt-2 form-row">
                <div class=" form-group mt-2 col-12 col-md-6">
                    <input type="text" id="nombre" class="form-control" style="width:100%" placeholder="Nombre"/>
                </div>
                <div class="form-group mt-2 col-6 col-md-3">
                    <input type="text" id="precioMin" class="form-control" style="width:100%" placeholder="Precio mínimo"/>
                </div>
                <div class="form-group mt-2 col-6 col-md-3">
                    <input type="text" id="precioMax" class="form-control" style="width:100%" placeholder="Precio máximo"/>
                </div>                         
            </div>
            <div class="form-row mt-2 mb-1">
                <div class="form-group col-12 col-md-6 ">
                    <select id="genero" class="form-control select2">
                        <option value="">Género</option>
                        @foreach(App\Models\Genero::all(); as $genero) 
                        <option class="extra" value="{{ $genero->id }}">{{ $genero->nombre }}</option>
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

        $('#genero').select2({
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

        $("#buscar").click(function() {
            var nombre = $("#nombre").val();
            var genero = $("#genero").val();    
            var desarrolladora = $("#desarrolladora").val();  
            var precioMin = $("#precioMin").val();
            var precioMax = $("#precioMax").val();
            buscar(nombre,genero,desarrolladora,precioMin,precioMax)
        });

        function fetch_data(page){
            $.ajax({
                url:"/juegos/lista?page="+page,

                success:function(data){
                    $('#juegos_data').html(data);
                }
            });
        }   
        function buscar(nombre,genero,desarrolladora,precioMin,precioMax){
            $.ajax({
                url:"/juegos/lista?nombre="+nombre+'&genero='+genero +'&desarrolladora='+desarrolladora+'&precioMin='+precioMin+'&precioMax='+precioMax,
                
                success:function(data){
                    $('#juegos_data').html(data);
                }
            });
        }     
    });
        </script>
@endsection

