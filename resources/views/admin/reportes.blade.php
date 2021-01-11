@extends("layouts.admin.base")

@section("styles")
    <link href="{{ asset('css/animate/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/datatable/datatable.css') }}" rel="stylesheet">
@endsection

@section("content")
    <div class="container">
        <div class="row">
            <div class="col-sm">
                <div class="box-header">
                    <h1>Reportes (<span id="count">{{ $desarrolladoras->count() + $posts->count() + $mensajes->count() + $juegos->count() + $campanias->count() + $masters->count() }}</span>)</h1>
                </div>
                <nav id="submenu" class="navbar-expand-md navbar-light shadow bg-white mt-4 mb-4 pt-3 pb-3 text-center">
                    <button class="navbar-toggler ml-1" type="button" data-toggle="collapse" data-target="#collapsingNavbar">
                        Menú reportes <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="navbar-collapse collapse justify-content-between align-items-center w-100" id="collapsingNavbar">
                        <ul class="navbar-nav mx-auto submenu-items">
                            <li class="nav-item"><a class="nav-link" id="desarrolladoras" href="">Desarrolladoras <span class="badge badge-pill badge-dark">{{ $desarrolladoras->count() > 0 }}</span></a></li>
                            <li class="nav-item"><a class="nav-link" id="juegos" href="">Juegos <span class="badge badge-pill badge-dark">{{ $juegos->count() > 0 }}</span></a></li>
                            <li class="nav-item"><a class="nav-link" id="campanias" href="">Campañas <span class="badge badge-pill badge-dark">{{ $campanias->count() > 0 }}</span></a></li>
                            <li class="nav-item"><a class="nav-link" id="masters" href="">Masters <span class="badge badge-pill badge-dark">{{ $masters->count() > 0 }}</span></a></li>
                            <li class="nav-item"><a class="nav-link" id="posts" href="">Posts <span class="badge badge-pill badge-dark">{{ $posts->count() > 0 }}</span></a></li>
                            <li class="nav-item"><a class="nav-link" id="mensajes" href="">Mensajes <span class="badge badge-pill badge-dark">{{ $mensajes->count() > 0 }}</span></a></li>
                        </ul>
                    </div>
                </nav>
                <div id="contenido" class="box">
                    <div class="desarrolladoras">
                        <h2>Desarrolladoras</h2>
                        <div class="table-responsive mt-3">
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
                    </div>
                    <div class="posts d-none">
                        <h2>Posts</h2>
                        <div class="table-responsive mt-3">
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
                    </div>
                    <div class="mensajes d-none">
                        <h2>Mensajes</h2>
                        <div class="table-responsive mt-3">
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
                    </div>
                    <div class="juegos d-none">
                        <h2>Juegos</h2>
                        <div class="table-responsive mt-3">
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
                    </div>
                    <div class="campanias d-none">
                        <h2>Campañas</h2>
                        <div class="table-responsive mt-3">
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
                    </div>
                    <div class="masters d-none">
                        <h2>Masters</h2>
                        <div class="table-responsive mt-3">
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
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section("scripts")
    <script src="{{ asset('js/datatable/datatable.js') }}"></script>
    <script src="{{ asset('js/datatable/script.js') }}"></script>
    <script src="{{ asset('js/sweetalert/sweetalert.min.js') }}"></script>
    <script src="{{ asset('js/script.js') }}"></script>
    <script type="text/javascript">
        $(function() {
            $(".ver").on('click', function(e) {
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

            $(".aceptar").on('click', function(e) {
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
                    success: function(mensaje) {
                        $(table).DataTable().row(tr).remove().draw();
                        $("#messages-count").html($("#messages-count").text() - 1);
                        $("#count").html($("#count").text() - 1);
                        notificacionEstado('success', mensaje);
                    },
                    error: function () {
                        notificacionEstado('error', 'No se ha podido realizar la acción');
                    }
                });
            });

            $(".rechazar").on('click', function(e) {
                e.preventDefault();
                let tr = $(this).parents('tr');
                let table = $(this).parents('table');
                $.ajax({
                    url: '{{ route("admin.reporte.cancelar") }}',
                    data: {
                        id: $(this).parent().children().val(),
                        tipo: $(this).parent().children().next().val() + '_id',
                    },
                    success: function(mensaje) {
                        $(table).DataTable().row(tr).remove().draw();
                        $("#messages-count").html($("#messages-count").text() - 1);
                        $("#count").html($("#count").text() - 1);
                        notificacionEstado('success', mensaje);
                    },
                    error: function () {
                        notificacionEstado('error', 'No se ha podido realizar la acción');
                    }
                });
            });
        });

    </script>
@endsection
