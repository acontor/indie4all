@extends("layouts.cm.base")
@section("content")
    <div class="container">
        <div class="row">
            <div class="col-sm">
                <div class="box-header">
                    <h1 class="d-inline-block">Desarrolladora {{ $desarrolladora->nombre }}</h1>
                </div>
                <div class="row box">
                    <div class="col-sm-5 preview" style="border: solid 1px black">
                        <header>
                            <img class="img-fluid" src="{{ asset('/images/default.png') }}" style="height: 200px;">
                            <div>
                                <h1 class="font-weight-light desarrolladora_nombre">{{ $desarrolladora->nombre }}</h1>
                                <ul class="lead">
                                    <li><a href="http://{{ $desarrolladora->url }}" class="desarrolladora_url" target="blank">{{ $desarrolladora->url }}</a></li>
                                </ul>
                            </div>
                        </header>
                        <div class="container mt-3">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="row text-center menu">
                                        <div class="col-3"><a id="general" href="">General</a></div>
                                        <div class="col-3"><a id="sorteos" href="">Sorteos</a></div>
                                        <div class="col-3"><a id="encuestas" href="">Encuestas</a></div>
                                        <div class="col-3"><a id="contacto" href="">Contacto</a></div>
                                    </div>
                                    <hr>
                                    <div id="contenido">
                                        <div class="general">
                                            <h2>Posts</h2>
                                        </div>
                                        <div class="sorteos d-none">
                                            <h2>Sorteos</h2>
                                            <div class="row">
                                                @foreach ($desarrolladora->sorteos as $sorteo)
                                                    <div class="col-6">
                                                        <h3>{{ $sorteo->titulo }}</h3>
                                                        <p>{{ $sorteo->descripcion }}</p>
                                                        <p>{{ $sorteo->fecha_fin }}</p>
                                                        <button class="btn btn-success">Participar</button>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="encuestas d-none">
                                            <h2>Encuestas</h2>
                                        </div>
                                        <div class="contacto d-none">
                                            <h2>contacto</h2>
                                            <ul class="lead">
                                                <li><a href="http://{{ $desarrolladora->url }}" class="desarrolladora_url" target="blank">{{ $desarrolladora->url }}</a>
                                                </li>
                                                <li><a href="mailto:{{ $desarrolladora->email }}" class="desarrolladora_email" target="blank">{{ $desarrolladora->email }}</a></li>
                                                <li class="desarrolladora_direccion">{{ $desarrolladora->direccion }}</li>
                                                <li class="desarrolladora_telefono">{{ $desarrolladora->telefono }}</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 offset-1">
                                    <h4>Juegos</h4>
                                    <hr>
                                    @foreach ($desarrolladora->juegos as $juego)
                                        <a href="{{ route('usuario.juego.show', $juego->id) }}">{{ $juego->nombre }}</a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-5 offset-sm-1 mt-4">
                        <form method="post" action="{{ route('usuario.desarrolladora.store') }}">
                            @csrf
                            <div class="form-group">
                                <label for="nombre">Nombre:</label>
                                <input type="text" class="form-control name" name="nombre" value="{{ $desarrolladora->nombre }}" />
                            </div>
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="email" class="form-control email" name="email" value="{{ $desarrolladora->email }}" />
                            </div>
                            <div class="form-group">
                                <label for="direccion">Dirección:</label>
                                <input type="text" class="form-control direccion" name="direccion" value="{{ $desarrolladora->direccion }}" />
                            </div>
                            <div class="form-group">
                                <label for="telefono">Teléfono:</label>
                                <input type="text" class="form-control telefono" name="telefono" value="{{ $desarrolladora->telefono }}" />
                            </div>
                            <div class="form-group">
                                <label for="url">Url:</label>
                                <input type="text" class="form-control url" name="url" value="{{ $desarrolladora->url }}" />
                            </div>
                            <button type="submit" class="btn btn-success mb-3">Editar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section("scripts")
    <script>
        $(function() {
            $(".name").keyup(function() {
                $(".desarrolladora_nombre").text($(this).val());
            });

            $(".email").keyup(function() {
                $(".desarrolladora_email").text($(this).val());
            });

            $(".direccion").keyup(function() {
                $(".desarrolladora_direccion").text($(this).val());
            });

            $(".url").keyup(function() {
                $(".desarrolladora_url").text($(this).val());
            });

            $(".telefono").keyup(function() {
                $(".desarrolladora_telefono").text($(this).val());
            });

            $(".menu").children("div").children("a").click(function(e) {
                e.preventDefault();
                let item = $(this).attr("id");
                $("#contenido").children("div").addClass("d-none");
                $(`.${item}`).removeClass("d-none");
            });
        });

    </script>
@endsection
