@extends("layouts.usuario.base")

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/calendar/simple-calendar.css') }}">
@endsection

@section("content")
    <main class="p-3 pb-5">
        <div class="container box mt-4">
            <div class="row">
                <div class="col-12 col-md-7">
                    <h2>Últimas noticias</h2>
                </div>

                <div class="col-12 col-md-4 offset-md-1 mt-5 mt-md-0">
                    <h4>Próximos juegos</h4>
                    <hr>
                    <div id="container" class="calendar-container"></div>
                    <h4>Campañas activas</h4>
                    <hr>
                    {{$campanias}}
                    <h4 class="mt-5">Enlaces de interés</h4>
                    <hr>
                    <ul>
                        <li><a href="{{ route('usuario.cuenta.index', 'compras') }}">Colección de juegos</a></li>
                        <li><a href="{{ route('usuario.cuenta.index', 'masters') }}">Masters seguidos</a></li>
                        <li><a href="{{ route('usuario.cuenta.index', 'desarrolladoras') }}">Desarrolladoras seguidas</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </main>
@endsection

@section("scripts")
    <script src="{{ asset('js/calendar/jquery.simple-calendar.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            let juegos = {!! json_encode($juegos) !!};
            let events = [];

            juegos.forEach(element => {
                events.push({
                    'startDate': element.fecha_lanzamiento,
                    'endDate': element.fecha_lanzamiento,
                    'summary': element.nombre
                })
            });

            $("#container").simpleCalendar({
                months: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                days: ['Domingo', 'Luneas', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
                displayYear:true,
                fixedStartDay: true,
                disableEmptyDetails: true,
                events: events,
            });
        });
    </script>
@endsection
