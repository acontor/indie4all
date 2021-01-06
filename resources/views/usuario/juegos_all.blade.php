@extends("layouts.usuario.base")
@section('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section("content")
    <div class="container">

        <div class="form-row mt-5">
            <div class="col-3">
                <input type="text" id="nombre" class="form-control input-sm w-auto inline m-r extra" style="width:100%" placeholder="Nombre"/>
            </div>
            <div class="col-4">
                <select id="genero" class="form-control extra select2">
                    <option value="">Género</option>
                    @foreach(App\Models\Genero::all(); as $genero) 
                    <option class="extra" value="{{ $genero->id }}">{{ $genero->nombre }}</option>
                    @endforeach
                </select> 
            </div>
            <div class="col ml-4">
                <button id='buscar' class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i>&nbspBuscar</button>   
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

        $("#buscar").click(function() {
            var nombre = $("#nombre").val();
            var genero = $("#genero").val();    
            buscar(nombre,genero)
        });

        function fetch_data(page){
            $.ajax({
                url:"/juegos/lista?page="+page,

                success:function(data){
                    $('#juegos_data').html(data);
                }
            });
        }   
        function buscar(nombre,genero){
            $.ajax({
                url:"/juegos/lista?nombre="+nombre+'&genero='+genero,
                
                success:function(data){
                    console.log(data)
                    $('#juegos_data').html(data);
                }
            });
        }     
    });
        </script>
@endsection

