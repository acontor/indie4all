@extends("layouts.usuario.base")
@section('content')
    <div class="container pt-4">
        <div class="row">
            <div class="col-sm">
                <div class="box-header">
                    <h1 class="d-inline-block">Campaña para {{ $campania->juego->nombre }}</h1>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 col-12 pl-0">
        @if (!$campania->juego->imagen_portada)
            <img class="img-fluid h-auto" src="{{url('/images/default.png')}}">
        @else
            <img class="img-fluid h-auto" src="{{url('/images/juegos/portadas/' . $campania->juego->imagen_portada)}}">
        @endif
            </div>
            <div class="box col-12 col-md-4 ">
                <h5 class="card-title">{{ $campania->juego->nombre }}</h5>
                {{ $campania->recaudado }} € de {{ $campania->meta }} €
                <div class="progress">
                    <div class="progress-bar" role="progressbar" aria-valuenow="70"
                    aria-valuemin="0" aria-valuemax="100">
                    </div>
                </div>
                <ul class="list-group list-group-flush mt-5">
                    <li class="list-group-item">Fecha de lanzamiento: {{ $campania->juego->fecha_lanzamiento }}</li>
                    <li class="list-group-item">Género: {{ $campania->juego->genero->nombre }}</li>
                    <li class="list-group-item">Participantes: </li>
                    <li id="diasRestantes" class="list-group-item text-danger"></li>
                </p>
                <div class="row justify-content-center">
                    <form action="{{ route('usuario.paypal.pagar') }}" method="post">
                        @csrf
                        @method('POST')
                        <input type="hidden" name="tipo" value="1" />
                        <input type="hidden" name="campaniaId" value="{{ $campania->id }}">                          
                        <input type="text" name="precio">                      
                        <button type="submit" class="btn btn-primary"> Participar</button>
                        </form>
                </div>
            </div>
        </div>
        <div class="col-md-12 box mt-4">
            <div class="row text-center menu">
                <div class="col-4 col-md-2 offset-md-1"><a id="general" href="">General</a></div>
                <div class="col-4 col-md-2"><a id="actualizaciones" href="">Actualizaciones</a></div>
                <div class="col-4 col-md-2"><a id="foro" href="">Foro</a></div>
                <div class="col-4 col-md-2"><a id="faq" href="">FAQ</a></div>
                <div class="col-4 col-md-2"><a id="contacto" href="">Contacto</a></div>
            </div>
            <div id="contenido">
                <div class="general">
                    <h3>Contenido</h3>
                    Contenido que quiera la desarrolladora.
                    Hay que crear un atributo en la tabla desarrolladoras llamado contenido.
                </div>
                <div class="actualizaciones d-none">
                    <h3>Actualizaciones</h3>
                    asdasdasdasdasd
                </div>
                <div class="foro d-none">
                    <h3>Foro</h3>
                    ASDasd
                </div>
                <div class="faq d-none">
                    <h3>FAQ</h3>
                </div>
                <div class="contacto d-none">
                    <h3>Contacto</h3>
                    <ul class="lead">
                        <li><a href="http://{{ $campania->juego->desarrolladora->url }}"
                            target="blank">{{ $campania->juego->desarrolladora->url }}</a>
                    </li>
                    <li><a href="mailto:{{ $campania->juego->desarrolladora->email }}"
                            target="blank">{{ $campania->juego->desarrolladora->email }}</a></li>
                    <li>{{ $campania->juego->desarrolladora->direccion }}</li>
                    <li>{{ $campania->juego->desarrolladora->telefono }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
<script src="http://momentjs.com/downloads/moment.min.js"></script>
<script>
    $(function() {
        let recaudado = {{json_encode($campania->recaudado)}};
        let meta = {{json_encode($campania->meta)}};
        const fechaFin = @json($campania).fecha_fin;
        let fechaHoy = moment();
        let fechaFinal =moment(fechaFin,);
        let porcentaje = (100*recaudado)/meta;

        $('.progress-bar').css('width',porcentaje+'%')
        $('#diasRestantes').append(`¡Quedan ${fechaFinal.diff(fechaHoy, 'days')} días!`)

        $(".menu").children("div").children("a").click(function(e) {
                e.preventDefault();
                let item = $(this).attr("id");
                $("#contenido").children("div").addClass("d-none");
                $(`.${item}`).removeClass("d-none");
            });
        });

</script>
@endsection
