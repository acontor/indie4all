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
                    <h1 class="d-inline-block">Usuarios ({{ $usuarios->count() }})</h1>
                    <a href="{{ route('admin.usuarios.create') }}" class="btn btn-success btn-sm round float-right mt-2">
                        <i class="far fa-plus-square"></i>
                    </a>
                </div>
                <div class="box mt-4">
                    <canvas id="myChart" width="400" height="100"></canvas>
                </div>
                <div class="box mt-4">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <td class="w-10">Nombre</td>
                                <td class="w-20">Email</td>
                                <td class="w-20">Última conexión</td>
                                <td class="w-20">Tipo</td>
                                <td class="w-10 text-center">Baneado</td>
                                <td class="w-10 text-center">Reportes</td>
                                <td class="w-10 text-center">Acciones</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($usuarios as $usuario)
                                <tr>
                                    <td class="align-middle w-20">{{ $usuario->name }}</td>
                                    <td class="align-middle w-20">{{ $usuario->email }}</td>
                                    <td class="align-middle w-20">{{ $usuario->last_activity }}</td>
                                    <td class="align-middle w-20">
                                        @if ($usuario->administrador)
                                            Administrador
                                        @elseif ($usuario->master)
                                            Master
                                        @elseif($usuario->cm)
                                            CM
                                        @elseif($usuario->administrador)
                                            Administrador
                                        @else
                                            Fan
                                        @endif
                                    </td>
                                    <td class="align-middle w-10 text-center">
                                        {{ $usuario->ban == 1 ? 'Si' : 'No' }}
                                    </td>
                                    <td class="align-middle w-10 text-center">{{ $usuario->reportes }}</td>
                                    <td class="align-middle w-10 text-center">
                                        <div class="btn-group">
                                            <form method="get" action="{{ route('admin.usuarios.edit', $usuario->id) }}">
                                                @csrf
                                                <button class="btn btn-primary btn-sm round mr-1" type="submit">
                                                    <i class="far fa-edit"></i>
                                                </button>
                                            </form>
                                            <div class="ban">
                                                <input type="hidden" name="id" value="{{ $usuario->id }}">
                                                @if(!$usuario->administrador && $usuario->ban == null)
                                                    <button class="btn btn-warning btn-sm round btn-ban" type="submit">
                                                        <i class="far fa-gavel"></i>
                                                    </button>
                                                @elseif($usuario->ban)
                                                    <input type="hidden" name="motivo" value="{{ $usuario->motivo }}">
                                                    <button class="btn btn-success btn-sm round btn-unban" type="submit">
                                                        <i class="far fa-gavel"></i>
                                                    </button>
                                                @endif
                                            </div>
                                            @if(!$usuario->administrador)
                                                <form action="{{ route('admin.usuarios.destroy', $usuario->id) }}" method="post">
                                                    @csrf
                                                    @method("DELETE")
                                                    <button class="btn btn-danger btn-sm round ml-1" type="submit">
                                                        <i class="far fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            @endif
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
    <script src="{{ asset('js/datatable/datatable.js') }}"></script>
    <script src="{{ asset('js/datatable/script.js') }}"></script>
    <script src="{{ asset('js/sweetalert/sweetalert.min.js') }}"></script>
    <script src="{{ asset('js/chart/chart.min.js') }}"></script>
    <script src="{{ asset('js/script.js') }}"></script>
    <script src="{{ asset('js/admin.js') }}"></script>
    <script type="text/javascript">
        $(function() {
            let masters = "{!! $numMasters !!}";
            let cms = "{!! $numCms !!}";
            let usuarios = "{!! $usuarios->count() !!}";

            graficaUsuarios(masters, cms, usuarios);

            $(".btn-ban").click(function() {
                let elemento = $(this);
                let id = elemento.prev().val();
                let url = `/admin/usuario/${id}/ban`;
                ban(elemento, url, "Indica el motivo");
            });

            $(".btn-unban").click(function() {
                let elemento = $(this);
                let id = $(this).prev().prev().val();
                let url = `/admin/usuario/${id}/unban`;
                let motivo = $(this).prev().val();
                unban(elemento, url, motivo, "¿Quieres quitarle el ban al usuario?");
            });
        });

    </script>
@endsection
