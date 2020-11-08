@extends('layouts.admin.base')
@section('content')
    <div class="container">
        <div class='row'>
            <div class='col-sm'>
                <h1 class='display-5'>Usuarios ({{ \App\Models\User::all()->count() }})</h1>
                <canvas id="myChart" width="400" height="100"></canvas>
                <div class="form-group col-sm-2">
                    <h4>Buscar</h4>
                    <select class="form-control" id="busqueda"></select>
                </div>
                <div class="table-responsive mt-3">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <td>Nombre</td>
                                    <td>Email</td>
                                    <td>Editar</td>
                                    <td>Borrar</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($usuarios as $usuario)
                                    <tr>
                                        <form method='post' action="{{ route('admin.usuarios.update', $usuario->id) }}">
                                            @method('PATCH')
                                            @csrf
                                            <td class="align-middle">
                                                <input type='text' placeholder="Nombre" value="{{ $usuario->name }}" name='name'>
                                            </td>
                                            <td class="align-middle">
                                                <input type='text' placeholder="Email" value="{{ $usuario->email }}" name='email'>
                                            </td>
                                            <td class="align-middle">
                                                <button type='submit' class='btn btn-primary'>Editar</button>
                                            </td>
                                        </form>
                                        <td class="align-middle">
                                            <form action="{{ route('admin.usuarios.destroy', $usuario->id) }}" method='post'>
                                                @csrf
                                                @method('DELETE')
                                                <button class='btn btn-danger' type='submit'>Borrar</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    {{ $usuarios->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
@endsection
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>
<script src="{{ asset('js/select2.min.js') }}" ></script>

<script>
    $(function() {

        var masters = {!! $num_masters !!};
        var cms = {!! $num_cms !!};
        var fans = {!! $num_fans !!} - masters - cms;

        graficaUsuarios(masters, fans, cms)
    });

    function graficaUsuarios(masters, fans, cms) {
        var ctx = document.getElementById("myChart").getContext("2d");
        var data = {
            datasets: [{
                backgroundColor: ['#ff6384', '#A086BE', '#333333'],
                data: [masters, fans, cms]
            }],

            // These labels appear in the legend and in the tooltips when hovering different arcs
            labels: ['Masters', 'Fans', 'Cms']
        };
        var myBarChart = new Chart(ctx, {
            type: 'doughnut',
            data: data,
            options: {
            }
        });
    }
    $('#busqueda').select2({
        placeholder: 'Select movie',
        ajax: {
            url: '/autocomplete-user-search',
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.name,
                            id: item.id
                        }
                    })
                };
            },
            cache: true
        }
    });

</script>
