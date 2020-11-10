@extends('layouts.admin.base')
@section('styles')
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet">
@endsection
@section('content')
    <div class="container">
        <div class='row'>
            <div class='col-sm'>
                <div class="box-header">
                    <h1>Usuarios ({{ \App\Models\User::all()->count() }})</h1>
                </div>
                <div class="box mt-4">
                    <canvas id="myChart" width="400" height="100"></canvas>
                </div>
                <div class="box mt-4">
                    <div class="form-group col-sm-2">
                        <h4>Buscar</h4>
                        <select class="form-control" id="busqueda"></select>
                    </div>
                    <div class="table-responsive mt-3">
                        <table class="table table-striped" id="tabla">
                            <thead>
                                <tr>
                                    <td class="w-20">Nombre</td>
                                    <td class="w-20">Email</td>
                                    <td class="w-20">Última conexión</td>
                                    <td class="w-30">Tipo</td>
                                    <td class="w-10 text-center">Acciones</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($usuarios as $usuario)
                                    <tr>
                                        <form method='post' action="{{ route('admin.usuarios.update', $usuario->id) }}">
                                            @method('PATCH')
                                            @csrf
                                            <td class="w-20">
                                                {{ $usuario->name }}
                                            </td>
                                            <td class="w-20">
                                                {{ $usuario->email }}
                                            </td>
                                            <td class="w-20">
                                                {{ $usuario->last_activity }}
                                            </td>
                                            <td class="w-30">
                                                @if ($usuario->master)
                                                    Master
                                                @elseif($usuario->cm)
                                                    CM
                                                @elseif($usuario->administrador)
                                                    Administrador
                                                @else
                                                    Fan
                                                @endif
                                            </td>
                                            <td class="align-middle w-10 text-center">
                                                <div class="btn-group">
                                                    <button class='btn btn-primary mr-1' type='submit'><i
                                                        class="far fa-edit"></i></button>
                                                    <form action="{{ route('admin.usuarios.destroy', $usuario->id) }}"
                                                        method='post'>
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class='btn btn-danger ml-1' type='submit'><i class="far fa-trash-alt"></i></button>
                                                    </form>
                                                </div>
                                            </td>
                                        </form>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/select2.min.js') }}" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" defer></script>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.22/af-2.3.5/b-1.6.5/b-colvis-1.6.5/b-flash-1.6.5/b-html5-1.6.5/b-print-1.6.5/cr-1.5.2/fc-3.3.1/fh-3.1.7/kt-2.5.3/r-2.2.6/rg-1.1.2/rr-1.2.7/sc-2.0.3/sb-1.0.0/sp-1.2.1/sl-1.3.1/datatables.min.css"/>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.22/af-2.3.5/b-1.6.5/b-colvis-1.6.5/b-flash-1.6.5/b-html5-1.6.5/b-print-1.6.5/cr-1.5.2/fc-3.3.1/fh-3.1.7/kt-2.5.3/r-2.2.6/rg-1.1.2/rr-1.2.7/sc-2.0.3/sb-1.0.0/sp-1.2.1/sl-1.3.1/datatables.min.js"></script>



    <script type="text/javascript">
        $(function() {

            $('#tabla').dataTable();

            var masters = {!!$num_masters!!};
            var cms = {!!$num_cms!!};
            var fans = {!!$num_fans!!} - masters - cms;

            graficaUsuarios(masters, fans, cms);

            $('#busqueda').select2({
                placeholder: 'Seleccionar usuario',
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
                options: {}
            });
        }

    </script>
@endsection
