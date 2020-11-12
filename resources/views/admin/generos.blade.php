@extends('layouts.admin.base')
@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
@endsection
@section('content')
    <div class="container">
        <div class='row'>
            <div class='col-sm'>
                <div class="box-header">
                    <h1 class='d-inline-block'>Géneros ({{ $generosAll->count() }})</h1>
                    <a href="{{ route('admin.generos.create') }}" class='btn btn-success btn-sm round float-right mt-2'><i class="far fa-plus-square"></i></a>
                </div>
                <div class="d-none form-crear box">
                    <form method='post' action="{{ route('admin.generos.store') }}">
                        @csrf
                        <div class='form-group'>
                            <label for='nombre'>Nombre:</label>
                            <input type='text' class='form-control' name='nombre' />
                        </div>
                        <button type='submit' class='btn btn-success mb-3'>Añadir</button>
                    </form>
                </div>



                <div class="box mt-4">
                    <canvas id="myChart" width="400" height="100"></canvas>
                </div>
                <div class="table-responsive box mt-4">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <td class="w-50">Nombre</td>
                                <td class="w-20 text-center">Seguidores</td>
                                <td class="w-20 text-center">Juegos</td>
                                <td class="w-10 text-center">Acciones</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($generos as $genero)
                                <tr>
                                    <td class="align-middle w-50">{{ $genero->nombre }}</td>
                                    <td class="w-20 text-center">{{ $genero->usuarios->count() }}</td>
                                    <td class="w-20 text-center">{{ $genero->juegos->count() }}</td>
                                    <td class="align-middle w-10 text-center">
                                        <div class="btn-group">
                                            <form method='post' action="{{ route('admin.generos.edit', $genero->id) }}">
                                                @csrf
                                                <button class='btn btn-primary btn-sm round mr-1' type='submit'>
                                                    <i class="far fa-edit"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.generos.destroy', $genero->id) }}" method='post'>
                                                @csrf
                                                @method('DELETE')
                                                <button class='btn btn-danger btn-sm round ml-1' type='submit'><i class="far fa-trash-alt"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $generos->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>
    <script>
        $(function() {

            var generos = {!! json_encode($generosAll->toArray()) !!};
            var data = {!! json_encode($data) !!};

            console.log(data)
            var session_success = {!! json_encode(session()->get('success')) !!}

            var nombreGenero = [];

            generos.forEach(element => {
                nombreGenero.push(element['nombre'])
            });

            graficaGeneros(nombreGenero, data);

            if(session_success != undefined) {
                Swal.fire({
                    position: 'top-end',
                    title: session_success,
                    timer: 3000,
                    showConfirmButton: false,
                    showClass: {
                        popup: 'animate__animated animate__fadeInDown'
                    },
                    hideClass: {
                        popup: 'animate__animated animate__fadeOutUp'
                    },
                    allowOutsideClick: false,
                    backdrop: false,
                    width: 'auto',
                });
            }
        });

        function graficaGeneros(generos, data) {
            var ctx = document.getElementById("myChart").getContext("2d");

            var data = {
                labels: generos,
                datasets: [{
                    label: "Juegos",
                    backgroundColor: '#ff6384',
                    data: data[0]
                }, {
                    label: "Seguidores",
                    backgroundColor: "#A086BE",
                    data: data[1]
                }, ]
            };

            var myBarChart = new Chart(ctx, {
                type: 'bar',
                data: data,
                options: {
                    barValueSpacing: 20,
                    scales: {
                        yAxes: [{
                            ticks: {
                                min: 0,
                            }
                        }]
                    }
                }
            });
        }

    </script>
@endsection
