@extends('layouts.admin.base')
@section('content')
    <div class="container">
        <div class='row'>
            <div class='col-sm'>
                <h1 class='display-5'>Géneros ({{ $generosAll->count() }}) <a class='btn btn-success button-crear'>+</a></h1>
                @if ($errors->any())
                    <div class='alert alert-danger'>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <br />
                @endif
                @if (session()->get('success'))
                    <div class='alert alert-success'>
                        {{ session()->get('success') }}
                    </div>
                @endif
                <div class="d-none form-crear">
                    <form method='post' action="{{ route('admin.generos.store') }}">
                        @csrf
                        <div class='form-group'>
                            <label for='nombre'>Nombre:</label>
                            <input type='text' class='form-control' name='nombre' />
                        </div>
                        <button type='submit' class='btn btn-success mb-3'>Añadir</button>
                    </form>
                </div>
                <canvas id="myChart" width="400" height="100"></canvas>
                <div class="table-responsive mt-3">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <td>Nombre</td>
                                <td>Seguidores</td>
                                <td>Juegos</td>
                                <td>Editar</td>
                                <td>Borrar</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($generos as $genero)
                                <tr>
                                    <form method='post' action="{{ route('admin.generos.update', $genero->id) }}">
                                        @method('PATCH')
                                        @csrf
                                        <td class="align-middle">
                                            <input type='text' placeholder="Email" value="{{ $genero->nombre }}" name='nombre'>
                                        </td>
                                        <td>{{ $genero->usuarios->count() }}</td>
                                        <td>{{ $genero->juegos->count() }}</td>
                                        <td class="align-middle">
                                            <button type='submit' class='btn btn-primary'>Editar</button>
                                        </td>
                                    </form>
                                    <td class="align-middle">
                                        <form action="{{ route('admin.generos.destroy', $genero->id) }}" method='post'>
                                            @csrf
                                            @method('DELETE')
                                            <button class='btn btn-danger' type='submit'>Borrar</button>
                                        </form>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>
    <script>
        $(function() {

            var  generos = {!! json_encode($generosAll->toArray())!!};
            var  data = {!! json_encode($data) !!};

            var nombreGenero = [];

            generos.forEach(element => {
                nombreGenero.push(element['nombre'])
            });

            $(".button-crear").click(function() {
                $(".form-crear").toggleClass("d-none");
                $(this).toggleClass("btn-danger");
                if ($(this).hasClass("btn-danger")) {
                    $(this).text("-");
                } else {
                    $(this).text("+");
                }
            });
            graficaGeneros(nombreGenero, data)
        });

        function graficaGeneros(generos, data) {
            var ctx = document.getElementById("myChart").getContext("2d");

            var data = {
                labels: generos,
                datasets: [{
                    label: "Juegos",
                    backgroundColor:'#ff6384',
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
