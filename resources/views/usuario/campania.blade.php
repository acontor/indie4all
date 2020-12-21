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
                    <li class="list-group-item">Participantes: {{ $campania->compras->count() }}</li>
                    <li id="diasRestantes" class="list-group-item text-danger"></li>
                </p>
                <div class="row justify-content-center participar-div">
                    @auth
                    <form action="{{ route('usuario.paypal.pagar') }}" method="post">
                        @csrf
                        @method('POST')
                        <input type="hidden" name="tipo" value="1" />
                        <input type="hidden" name="campaniaId" value="{{ $campania->id }}">
                        <input type="text" name="precio">
                        <button type="submit" class="btn btn-primary"> Participar</button>
                    </form>
                    @else
                    <p>Tienes que estar registrado para participar.</p>
                    @endauth
                </div>
            </div>
        </div>
        <div class="col-md-12 box mt-4">
            <div class="row text-center menu">
                <div class="col-4 col-md-2 offset-md-1"><a id="general" href="">General</a></div>
                <div class="col-4 col-md-2"><a id="actualizaciones" href="">Actualizaciones</a></div>
                @auth
                <div class="col-4 col-md-2"><a id="foro" href="">Foro</a></div>
                @endauth
                <div class="col-4 col-md-2"><a id="faq" href="">FAQ</a></div>
                <div class="col-4 col-md-2"><a id="contacto" href="">Contacto</a></div>
                @auth
                <div class="float-right">
                    <a class="text-danger"><i class="fas fa-exclamation-triangle" id='reporteCampania'></i></a>
                </div>
                @endauth
            </div>
            <div id="contenido">
                <div class="general">
                    <h3>Contenido</h3>
                    Contenido que quiera la desarrolladora.
                    Hay que crear un atributo en la tabla desarrolladoras llamado contenido.
                </div>
                <div class="actualizaciones d-none">
                    <h3>Actualizaciones</h3>
                        @if ($campania->posts->count() != 0)
                            @foreach ($campania->posts as $post)
                                <div>
                                    <h4>{{ $post->titulo }}  <small>{{$post->created_at}}@auth <a class="text-danger float-right" id='reportePost' dataset="{{$post->id}}"><i class="fas fa-exclamation-triangle"></i></a>@endauth</h4>
                                    <p>{{ $post->contenido }}</p>
                                </div>
                            @endforeach
                        @else
                            Aún no ha publicado ninguna actualización.
                        @endif
                </div>
                @auth
                <div class="foro d-none">
                    <h3>Foro</h3>
                        @if ($campania->mensajes->count() != 0)
                            @foreach ($campania->mensajes as $mensaje)
                                <div class="alert alert-dark">
                                    <h5> {{$mensaje->user->name}}<small class="float-right">{{date_format($mensaje->created_at,"d-m-Y H:i")}}</small></h5><a class="text-danger float-right" id='reporteMensaje' dataset="{{$mensaje->id}}"><i class="fas fa-exclamation-triangle"></i></a>
                                    <p class="mensaje">{{ $mensaje->contenido }}</p>
                                </div>
                            @endforeach
                        @else
                            Aún no hay mensajes.. Sé el primero en participar!
                        @endif
                </div>
                @endauth
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
<script src="https://www.google.com/recaptcha/api.js"></script>
<script>
    $(function() {
        let recaudado = {{json_encode($campania->recaudado)}};
        let meta = {{json_encode($campania->meta)}};
        const fechaFin = @json($campania).fecha_fin;
        let fechaHoy = moment();
        let fechaFinal =moment(fechaFin,);
        let porcentaje = (100*recaudado)/meta;

        $('.progress-bar').css('width',porcentaje+'%');

        if(fechaFinal.diff(fechaHoy) < 0) {
            $('#diasRestantes').append('¡La campaña ha terminado!');
            $('.participar-div').remove();
        } else {
            $('#diasRestantes').append(`¡Quedan ${fechaFinal.diff(fechaHoy, 'days')} días!`);
        }

        $(".menu").children("div").children("a").click(function(e) {
                e.preventDefault();
                let item = $(this).attr("id");
                $("#contenido").children("div").addClass("d-none");
                $(`.${item}`).removeClass("d-none");
            });

        $('#reporteCampania').click(function(){
            let campaniaId = {!! $campania->id !!}
            let url = '{{ route("usuario.reporte", [":id" , "campania_id"]) }}';
            url = url.replace(':id', campaniaId);
            Swal.fire({
                title: 'Indica el motivo del reporte',
                showCancelButton: true,
                cancelButtonText: 'Cancelar',
                confirmButtonText: `Reportar`,
                input: 'text',
                inputAttributes: {
                    autocapitalize: 'off'
                },
                html: '<div id="recaptcha" class="mb-3"></div>',
                didOpen: function() {
                    grecaptcha.render('recaptcha', {
                            'sitekey': '6Lc2ufwZAAAAAFtjN9fasxuJc0OEf670ruHSTEfP'
                    });
                },
                preConfirm: function (result) {
                    if (grecaptcha.getResponse().length === 0) {
                        Swal.showValidationMessage(`Por favor, verifica que no eres un robot`)
                    } else if (result != '') {
                        let motivo = result;
                        $.ajax({
                            url: url,
                            type : 'POST',
                            headers:{
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            },
                            data: {
                                motivo: motivo,
                            }
                            ,success: function(data){
                                Swal.fire(data)
                            }
                        })
                    }else{
                        Swal.showValidationMessage(`Por favor, indica un motivo.`)
                    }
                }
            })
        })
        $('#reporteMensaje').click(function(){
            let id = $(this).attr('dataset');
            let url = '{{ route("usuario.reporte", [":id" , "mensaje_id"]) }}';
            url = url.replace(':id', id);
            Swal.fire({
                title: 'Indica el motivo del reporte',
                showCancelButton: true,
                cancelButtonText: 'Cancelar',
                confirmButtonText: `Reportar`,
                input: 'text',
                inputAttributes: {
                    autocapitalize: 'off'
                },
                html: '<div id="recaptcha" class="mb-3"></div>',
                didOpen: function() {
                    grecaptcha.render('recaptcha', {
                            'sitekey': '6Lc2ufwZAAAAAFtjN9fasxuJc0OEf670ruHSTEfP'
                    });
                },
                preConfirm: function (result) {
                    if (grecaptcha.getResponse().length === 0) {
                        Swal.showValidationMessage(`Por favor, verifica que no eres un robot`)
                    } else if (result != '') {
                        let motivo = result;
                        $.ajax({
                            url: url,
                            type : 'POST',
                            headers:{
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            },
                            data: {
                                motivo: motivo,
                            }
                            ,success: function(data){
                                Swal.fire(data)
                            }
                        })
                    }else{
                        Swal.showValidationMessage(`Por favor, indica un motivo.`)
                    }
                }
            })
        })
        $('#reportePost').click(function(){
            let id = $(this).attr('dataset');
            let url = '{{ route("usuario.reporte", [":id" , "post_id"]) }}';
            url = url.replace(':id', id);
            Swal.fire({
                title: 'Indica el motivo del reporte',
                showCancelButton: true,
                cancelButtonText: 'Cancelar',
                confirmButtonText: `Reportar`,
                input: 'text',
                inputAttributes: {
                    autocapitalize: 'off'
                },
                html: '<div id="recaptcha" class="mb-3"></div>',
                didOpen: function() {
                    grecaptcha.render('recaptcha', {
                            'sitekey': '6Lc2ufwZAAAAAFtjN9fasxuJc0OEf670ruHSTEfP'
                    });
                },
                preConfirm: function (result) {
                    if (grecaptcha.getResponse().length === 0) {
                        Swal.showValidationMessage(`Por favor, verifica que no eres un robot`)
                    } else if (result != '') {
                        let motivo = result;
                        $.ajax({
                            url: url,
                            type : 'POST',
                            headers:{
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            },
                            data: {
                                motivo: motivo,
                            }
                            ,success: function(data){
                                Swal.fire(data)
                            }
                        })
                    }else{
                        Swal.showValidationMessage(`Por favor, indica un motivo.`)
                    }
                }
            })
        })


    });

</script>
@endsection
