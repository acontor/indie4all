@extends("layouts.admin.base")

@section("styles")
    <link href="{{ asset('css/animate/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/datatable/datatable.css') }}" rel="stylesheet">
@endsection

@section("content")
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="box-header">
                    <h1>Reportes (<span id="count">{{ $desarrolladoras->count() + $posts->count() + $mensajes->count() + $juegos->count() + $campanias->count() + $masters->count() }}</span>)</h1>
                </div>
                <div class="row box text-center menu mb-4">
                    @if ($desarrolladoras->count() > 0)
                        <div class="col-4 col-md-3 mb-2"><a id="desarrolladoras" href="">Desarrolladoras</a></div>
                    @endif
                    @if ($juegos->count() > 0)
                        <div class="col-4 col-md-3 mb-2"><a id="juegos" href="">Juegos</a></div>
                    @endif
                    @if ($campanias->count() > 0)
                        <div class="col-4 col-md-3 mb-2"><a id="campanias" href="">Campañas</a></div>
                    @endif
                    @if ($masters->count() > 0)
                        <div class="col-4 col-md-3 mb-2"><a id="masters" href="">Masters</a></div>
                    @endif
                    @if ($posts->count() > 0)
                        <div class="col-4 col-md-3"><a id="posts" href="">Posts</a></div>
                    @endif
                    @if ($mensajes->count() > 0)
                        <div class="col-4 col-md-3"><a id="mensajes" href="">Mensajes</a></div>
                    @endif
                </div>
                <div id="main">
                    @if ($desarrolladoras->count() > 0)
                        <div class="box desarrolladoras">
                            <h2>Desarrolladoras</h2>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <td>Nombre</td>
                                        <td>Número de reportes</td>
                                        <td>Acciones</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($desarrolladoras as $desarrolladora)
                                        <tr>
                                            <td class="align-middle">{{ $desarrolladora->desarrolladora->nombre }}</td>
                                            <td>{{ $reportes->where('desarrolladora_id', $desarrolladora->desarrolladora_id)->count() }}</td>
                                            <td class="align-middle">
                                                <div class="btn-group">
                                                    <input type="hidden" name="id" value="{{ $desarrolladora->desarrolladora_id }}">
                                                    <input type="hidden" name="tipo" value="desarrolladora">
                                                    <button class="btn btn-primary btn-sm round ml-1 ver">
                                                        <i class="far fa-eye"></i>
                                                    </button>
                                                    <button class="btn btn-success btn-sm round ml-1 aceptar">
                                                        <i class="far fa-check-square"></i>
                                                    </button>
                                                    <button class="btn btn-danger btn-sm round ml-1 rechazar">
                                                        <i class="far fa-trash-alt"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                    @if ($posts->count() > 0)
                        <div class="box posts d-none">
                            <h2>Posts</h2>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <td>Título</td>
                                        <td>Número de reportes</td>
                                        <td>Acciones</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($posts as $post)
                                        <tr>
                                            <td class="align-middle">{{ $post->post->titulo }}</td>
                                            <td>{{ $reportes->where('post_id', $post->post_id)->count() }}</td>
                                            <td class="align-middle">
                                                <div class="btn-group">
                                                    <input type="hidden" name="id" value="{{ $desarrolladora->desarrolladora_id }}">
                                                    <input type="hidden" name="tipo" value="desarrolladora">
                                                    <button class="btn btn-primary btn-sm round ml-1 ver">
                                                        <i class="far fa-eye"></i>
                                                    </button>
                                                    <button class="btn btn-success btn-sm round ml-1 aceptar">
                                                        <i class="far fa-check-square"></i>
                                                    </button>
                                                    <button class="btn btn-danger btn-sm round ml-1 rechazar">
                                                        <i class="far fa-trash-alt"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                    @if ($mensajes->count() > 0)
                        <div class="box mensajes d-none">
                            <h2>Mensajes</h2>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <td>Título</td>
                                        <td>Número de reportes</td>
                                        <td>Acciones</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($mensajes as $mensaje)
                                        <tr>
                                            <td class="align-middle">{!! $mensaje->mensaje->contenido !!}</td>
                                            <td>{{ $reportes->where('mensaje_id', $mensaje->mensaje_id)->count() }}</td>
                                            <td class="align-middle">
                                                <div class="btn-group">
                                                    <input type="hidden" name="id" value="{{ $mensaje->mensaje_id }}">
                                                    <input type="hidden" name="tipo" value="mensaje">
                                                    <button class="btn btn-primary btn-sm round ml-1 ver">
                                                        <i class="far fa-eye"></i>
                                                    </button>
                                                    <button class="btn btn-success btn-sm round ml-1 aceptar">
                                                        <i class="far fa-check-square"></i>
                                                    </button>
                                                    <button class="btn btn-danger btn-sm round ml-1 rechazar">
                                                        <i class="far fa-trash-alt"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                    @if ($juegos->count() > 0)
                        <div class="box juegos d-none">
                            <h2>Juegos</h2>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <td>Nombre</td>
                                        <td>Número de reportes</td>
                                        <td>Acciones</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($juegos as $juego)
                                        <tr>
                                            <td class="align-middle">{{ $juego->juego->nombre }}</td>
                                            <td>{{ $reportes->where('juego_id', $juego->juego_id)->count() }}</td>
                                            <td class="align-middle">
                                                <div class="btn-group">
                                                    <input type="hidden" name="id" value="{{ $juego->juego_id }}">
                                                    <input type="hidden" name="tipo" value="juego">
                                                    <button class="btn btn-primary btn-sm round ml-1 ver">
                                                        <i class="far fa-eye"></i>
                                                    </button>
                                                    <button class="btn btn-success btn-sm round ml-1 aceptar">
                                                        <i class="far fa-check-square"></i>
                                                    </button>
                                                    <button class="btn btn-danger btn-sm round ml-1 rechazar">
                                                        <i class="far fa-trash-alt"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                    @if ($campanias->count() > 0)
                        <div class="box campanias d-none">
                            <h2>Campañas</h2>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <td>Nombre</td>
                                        <td>Número de reportes</td>
                                        <td>Acciones</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($campanias as $campania)
                                        <tr>
                                            <td class="align-middle">{{ $campania->campania->juego->nombre }}</td>
                                            <td>{{ $reportes->where('campania_id', $campania->campania_id)->count() }}</td>
                                            <td class="align-middle">
                                                <div class="btn-group">
                                                    <input type="hidden" name="id" value="{{ $campania->campania_id }}">
                                                    <input type="hidden" name="tipo" value="campania">
                                                    <button class="btn btn-primary btn-sm round ml-1 ver">
                                                        <i class="far fa-eye"></i>
                                                    </button>
                                                    <button class="btn btn-success btn-sm round ml-1 aceptar">
                                                        <i class="far fa-check-square"></i>
                                                    </button>
                                                    <button class="btn btn-danger btn-sm round ml-1 rechazar">
                                                        <i class="far fa-trash-alt"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                    @if ($masters->count() > 0)
                        <div class="box masters d-none">
                            <h2>Masters</h2>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <td>Nombre</td>
                                        <td>Número de reportes</td>
                                        <td>Acciones</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($masters as $master)
                                        <tr>
                                            <td class="align-middle">{{ $master->master->usuario->username }}</td>
                                            <td>{{ $reportes->where('master_id', $master->master_id)->count() }}</td>
                                            <td class="align-middle">
                                                <div class="btn-group">
                                                    <input type="hidden" name="id" value="{{ $master->master_id }}">
                                                    <input type="hidden" name="tipo" value="master">
                                                    <button class="btn btn-primary btn-sm round ml-1 ver">
                                                        <i class="far fa-eye"></i>
                                                    </button>
                                                    <button class="btn btn-success btn-sm round ml-1 aceptar">
                                                        <i class="far fa-check-square"></i>
                                                    </button>
                                                    <button class="btn btn-danger btn-sm round ml-1 rechazar">
                                                        <i class="far fa-trash-alt"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section("scripts")
    <script src="{{ asset('js/datatable/datatable.js') }}"></script>
    <script src="{{ asset('js/sweetalert/sweetalert.min.js') }}"></script>
    <script type="text/javascript">
        $(function() {
            $('table').DataTable({
                "responsive": true
            });

            $(".menu").children("div").children("a").click(function(e) {
                console.log($(this).attr("id"))
                e.preventDefault();
                let item = $(this).attr("id");
                $("#main").children("div").addClass("d-none");
                $(`.${item}`).removeClass("d-none");
            });

            $(".ver").click(function(e) {
                e.preventDefault();
                $.ajax({
                    url: '{{ route("admin.reporte.show") }}',
                    data: {
                        id: $(this).prev().prev().val(),
                        tipo: 'reportes.' + $(this).prev().val() + '_id',
                    },
                    success: function(data) {
                        let html = "<div class='reportes'>";
                        data.forEach(element => {
                            html += `<p>${element.email}</p><p>${element.motivo}</p>`;
                        });
                        html += '</div>';
                        Swal.fire({
                            title: `<h4><strong>Reportes</strong></h4>`,
                            html: html,
                            showCloseButton: false,
                            showCancelButton: false,
                            showConfirmButton: false,
                        });
                    }
                });
            });

            $(".aceptar").click(function(e) {
                e.preventDefault();
                let tr = $(this).parents('tr');
                let table = $(this).parents('table');
                $.ajax({
                    url: '{{ route("admin.reporte.aceptar") }}',
                    data: {
                        id: $(this).parent().children().val(),
                        tipo: $(this).parent().children().next().val() + '_id',
                        tabla: $(this).parent().children().next().val() + 's',
                    },
                    success: function(data) {
                        $(table).DataTable().row(tr).remove().draw();
                        $("#messages-count").html($("#messages-count").text() - 1);
                        $("#count").html($("#count").text() - 1);
                    }
                });
            });

            $(".rechazar").click(function(e) {
                e.preventDefault();
                $.ajax({
                    url: '{{ route("admin.reporte.cancelar") }}',
                    data: {
                        id: $(this).parent().children().val(),
                        tipo: $(this).parent().children().next().val() + '_id',
                    },
                    success: function(data) {
                        // Eliminar el reporte
                    }
                });
            });
        });

    </script>
@endsection
