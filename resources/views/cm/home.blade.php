@extends("layouts.cm.base")

@section("content")
    <div class="container">
        <div class="row">
            <div class="col-sm">
                <div class="box-header">
                    <h1>Vista general</h1>
                    Información general sobre seguidores, juegos, campañas, sortes y encuestas.
                </div>
                <div class="box mt-4">
                    <div class="row">
                        <div class="col-12">
                            <h2>Ventas</h2>                          
                            <canvas id="ventas"></canvas>
                        </div>
                    </div>
                </div>
                <div class="box mt-4">
                    <div class="row">
                        <div class="col-12">
                            <h2>Campañas</h2>                          
                            <canvas id="campanias"></canvas>
                        </div>
                    </div>
                </div>
                <div class="box mt-4">
                    <div class="row">
                        <div class="col-12">
                            <h2>Encuestas</h2>                          
                            <canvas id="encuestas"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/chart/chart.min.js') }}"></script>
    <script src="{{ asset('js/master.js') }}"></script>
    <script>
        $(function() {
            let juegos = {!! json_encode($juegos) !!};
            let datosVentas = {!! json_encode($datosVentas) !!};
            let encuestas = {!! json_encode($encuestas) !!};
            let datosEncuestas = {!! json_encode($datosEncuestas) !!};
            let campanias = {!! json_encode($campanias) !!};
            let datosCampania = {!! json_encode($datosCampania) !!};

            graficaVentas(juegos , datosVentas);
            graficaCampanias(campanias , datosCampania);
            participacionesEncuestas(encuestas , datosEncuestas);

        });
        
       
        function graficaVentas(juegos , datos) {
            let ctx = document.getElementById("ventas").getContext("2d");

            new Chart(ctx, {
                type: "bar",
                data: {
                    labels: juegos,
                    datasets: [{
                        label: "Ventas",
                        data: datos,
                        borderColor: "#E34E33",
                        borderWidth: 1
                    }]
                },
                responsive: true,
                options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            suggestedMin: 0,
                        }
                    }]
                }
            }
            });
        }
        function graficaCampanias(campanias , datos) {
            let ctx = document.getElementById("campanias").getContext("2d");

            new Chart(ctx, {
                type: "bar",
                data: {
                    labels: campanias,
                    datasets: [{
                        label: "Participaciones en Campañas",
                        data: datos,
                        borderColor: "#E34E33",
                        borderWidth: 1
                    }]
                },
                responsive: true,
                options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            suggestedMin: 0,
                        }
                    }]
                }
            }
            });
        }
        function participacionesEncuestas(encuestas, datos){
            let ctx = document.getElementById("encuestas").getContext("2d");

            new Chart(ctx, {
                type: "bar",
                data: {
                    labels: encuestas,
                    datasets: [{
                        label: "Participaciones en encuestas",
                        data: datos,
                        borderColor: "#E34E33",
                        borderWidth: 1
                    }]
                },
                responsive: true,
                options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            suggestedMin: 0,
                        }
                    }]
                }
            }
            });
        }
    </script>

@endsection
