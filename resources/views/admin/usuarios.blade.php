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
                    <a href="{{ route('admin.usuarios.create') }}" class="btn btn-success btn-sm round float-right mt-2"><i class="far fa-plus-square"></i></a>
                </div>
                <div class="box mt-4">
                    <canvas id="myChart" width="400" height="100"></canvas>
                </div>
                <div class="box mt-4">
                    <table class="table table-striped" id="tabla">
                        <thead>
                            <tr>
                                <td class="w-20">Nombre</td>
                                <td class="w-20">Email</td>
                                <td class="w-20">Última conexión</td>
                                <td class="w-30">Tipo</td>
                                <td class="w-10 text-center">Acciones</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($usuarios as $usuario)
                                <tr>
                                    <td class="w-20">{{ $usuario->name }}</td>
                                    <td class="w-20">{{ $usuario->email }}</td>
                                    <td class="w-20">{{ $usuario->last_activity }}</td>
                                    <td class="w-30">
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
                                        <div class="btn-group">
                                            <form method="post" action="{{ route('admin.usuarios.edit', $usuario->id) }}">
                                                @csrf
                                                <button class="btn btn-primary btn-sm round mr-1" type="submit">
                                                    <i class="far fa-edit"></i>
                                                </button>
                                            </form>
                                            <input type="hidden" name="id" value="{{ $usuario->id }}">
                                            <div class="ban">
                                                @if(!$usuario->administrador && $usuario->ban == null)
                                                <button class="btn btn-warning btn-sm round" type="submit">
                                                    <i class="far fa-gavel"></i>
                                                </button>
                                                @elseif($usuario->ban)
                                                <input type="hidden" name="motivo" value="{{ $usuario->motivo }}">
                                                <button class="btn btn-success btn-sm round" type="submit">
                                                    <i class="far fa-gavel"></i>
                                                </button>
                                                @endif
                                            </div>
                                            <form action="{{ route('admin.usuarios.destroy', $usuario->id) }}" method="post">
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
    <script src="{{ asset('js/datatable/datatable.js') }}"></script>
    <script src="{{ asset('js/sweetalert/sweetalert.min.js') }}"></script>
    <script src="{{ asset('js/chart/chart.min.js') }}"></script>
    <script>
        $(function() {
            $('table').DataTable({
                "responsive": true
            });

            let masters = {!! $numMasters !!};
            let cms = {!! $numCms !!};
            let usuarios = {!! $usuarios->count() !!};

            graficaUsuarios(masters, cms, usuarios);

            let sessionSuccess = {!! json_encode(session()->get("success")) !!}

            if (sessionSuccess != undefined) {
                notificacion(sessionSuccess)
            }

            $(".btn-warning").click(ban);

            $(".btn-success").click(unban);
        });

        function graficaUsuarios(masters, cms, usuarios) {
            var ctx = document.getElementById("myChart").getContext("2d");
            var data = {
                datasets: [{
                    backgroundColor: ["#ff6384", "#A086BE", "#333333"],
                    data: [masters, usuarios, cms]
                }],
                labels: ["Masters", "Fans", "Cms"]
            };
            var myBarChart = new Chart(ctx, {
                type: "doughnut",
                data: data,
            });
        }

        function ban() {
            let elemento = $(this);
            let url = '{{ route("admin.usuarios.ban", [":id" , "usuario"]) }}';
            url = url.replace(':id', $(this).parent().prev().val());
            Swal.fire({
                title: 'Indica el motivo del ban',
                showCancelButton: true,
                cancelButtonText: 'Cancelar',
                confirmButtonText: `Ban`,
                input: 'text',
                inputAttributes: {
                    autocapitalize: 'off'
                },
                preConfirm: function (result) {
                    if (result != '') {
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
                                Swal.fire(data);
                                elemento.removeClass('btn-warning').addClass('btn-success');
                                elemento.click(unban);
                                elemento.parent().prepend(`<input type="hidden" name="motivo" value="${motivo}">`);
                            }
                        });
                    }else{
                        Swal.showValidationMessage(`Por favor, indica un motivo.`)
                    }
                }
            });
        }

        function unban() {
            let elemento = $(this);
            let url = '{{ route("admin.usuarios.unban", [":id" , "usuario"]) }}';
            url = url.replace(':id', $(this).parent().prev().val());
            let motivo = $(this).prev().val();
            Swal.fire({
                title: '¿Quieres quitarle el ban a éste usuario?',
                showCancelButton: true,
                cancelButtonText: 'Cancelar',
                confirmButtonText: `Aceptar`,
                html: `<p>Motivo:</p><p>${motivo}</p>`,
                preConfirm: function () {
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
                            Swal.fire(data);
                            elemento.removeClass('btn-success').addClass('btn-warning');
                            elemento.click(ban);
                            elemento.prev().remove();
                        }
                    });
                }
            });
        }

    </script>
@endsection
