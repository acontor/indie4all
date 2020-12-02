@extends("layouts.admin.base")
@section("styles")
    <link href="{{ asset('css/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/datatable.css') }}" rel="stylesheet">
@endsection
@section("content")
    <div class="container">
        <div class="row">
            <div class="col-sm">
                <div class="box-header">
                    <h1 class="d-inline-block">Géneros ({{ $generos->count() }})</h1>
                    <a href="{{ route('admin.generos.create') }}" class="btn btn-success btn-sm round float-right mt-2"><i
                            class="far fa-plus-square"></i></a>
                </div>
                <div class="box mt-4">
                    <canvas id="myChart"></canvas>
                </div>
                <div class="box mt-4">
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
                                            <form method="post" action="{{ route('admin.generos.edit', $genero->id) }}">
                                                @csrf
                                                <button class="btn btn-primary btn-sm round mr-1" type="submit">
                                                    <i class="far fa-edit"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.generos.destroy', $genero->id) }}" method="post">
                                                @csrf
                                                @method("DELETE")
                                                <button class="btn btn-danger btn-sm round ml-1" type="submit">
                                                    <i class="far fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section("scripts")
    <script src="{{ asset('js/datatable.js') }}"></script>
    <script src="{{ asset('js/sweetalert.min.js') }}"></script>
    <script src="{{ asset('js/chart.min.js') }}"></script>
    <script>
        $(function() {
            $('table').DataTable({
                "responsive": true
            });

            var generos = {!! json_encode($generos) !!};
            var datos = {!! json_encode($datos) !!};

            var nombreGenero = [];

            generos.forEach(element => {
                nombreGenero.push(element["nombre"])
            });

            graficaGeneros(nombreGenero, datos);

            let sessionSuccess = {!! json_encode(session()->get("success")) !!}

            if (sessionSuccess != undefined) {
                notificacion(sessionSuccess)
            }

            $('.btn-danger').click(function(e) {
                e.preventDefault();
                let form = $(this).parents('form');
                Swal.fire({
                    position: "center",
                    title: "Cuidado",
                    text: "¡Tendrás que volver a crear el género para recuperarlo!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Aceptar",
                    cancelButtonText: "Cancelar",
                    showClass: {
                        popup: "animate__animated animate__fadeInDown"
                    },
                    hideClass: {
                        popup: "animate__animated animate__fadeOutUp"
                    },
                    closeOnConfirm: false,
                }).then((resultado) => {
                    if (resultado.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });

        function graficaGeneros(generos, datos) {
            var ctx = document.getElementById("myChart").getContext("2d");

            var datos = {
                labels: generos,
                datasets: [{
                        label: "Juegos",
                        backgroundColor: "#ff6384",
                        data: datos[0]
                    },
                    {
                        label: "Seguidores",
                        backgroundColor: "#A086BE",
                        data: datos[1]
                    },
                ],
            };

            var myBarChart = new Chart(ctx, {
                type: "bar",
                data: datos,
                options: {
                    barValueSpacing: 20,
                    scales: {
                        yAxes: [{
                            ticks: {
                                min: 0,
                            }
                        }]
                    }
                },
                responsive: true,
            });
        }

        function notificacion(sessionSuccess) {
            Swal.fire({
                position: "top-end",
                title: sessionSuccess,
                timer: 3000,
                showConfirmButton: false,
                showClass: {
                    popup: "animate__animated animate__fadeInDown"
                },
                hideClass: {
                    popup: "animate__animated animate__fadeOutUp"
                },
                allowOutsideClick: false,
                backdrop: false,
                width: "auto",
            });
        }

    </script>
@endsection
