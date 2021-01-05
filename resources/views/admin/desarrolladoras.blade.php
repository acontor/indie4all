@extends("layouts.admin.base")

@section("styles")
    <link href="{{ asset('css/datatable/datatable.css') }}" rel="stylesheet">
@endsection

@section("content")
    <div class="container">
        <div class="row">
            <div class="col-sm">
                <div class="box-header">
                    <h1 class="d-inline-block">Desarrolladoras ({{ $desarrolladoras->count() }})</h1>
                    @if ($numSolicitudes > 0)
                        <a href="{{ route('admin.solicitudes.index') }}" class="btn btn-success btn-sm float-right mt-2">Solicitudes ({{ $numSolicitudes }})</a>
                    @endif
                </div>
                <div class="box">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <td>Nombre</td>
                                <td>Email</td>
                                <td>Dirección</td>
                                <td>Teléfono</td>
                                <td>Url</td>
                                <td>Logo</td>
                                <td>Strikes</td>
                                <td>Acciones</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($desarrolladoras as $desarrolladora)
                                <tr>
                                    <td class="align-middle">{{ $desarrolladora->nombre }}</td>
                                    <td class="align-middle">{{ $desarrolladora->email }}</td>
                                    <td class="align-middle">{{ $desarrolladora->direccion }}</td>
                                    <td class="align-middle">{{ $desarrolladora->telefono }}</td>
                                    <td class="align-middle">{{ $desarrolladora->url }}</td>
                                    <td class="align-middle">{{ $desarrolladora->imagen_logo }}</td>
                                    <td class="align-middle">{{ $desarrolladora->reportes }}</td>
                                    <td class="align-middle text-center">
                                        <div class="btn-group">
                                            <input type="hidden" name="id" value="{{ $desarrolladora->id }}">
                                            <div class="ban">
                                                @if($desarrolladora->ban == null)
                                                <button class="btn btn-warning btn-sm round" type="submit">
                                                    <i class="far fa-gavel"></i>
                                                </button>
                                                @else
                                                <input type="hidden" name="motivo" value="{{ $desarrolladora->motivo }}">
                                                <button class="btn btn-success btn-sm round" type="submit">
                                                    <i class="far fa-gavel"></i>
                                                </button>
                                                @endif
                                            </div>
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
    <script type="text/javascript">
        $(function() {
            $('table').DataTable({
                "responsive": true
            });

            $(".btn-warning").click(ban);

            $(".btn-success").click(unban);
        });

        function ban() {
            let elemento = $(this);
            let url = '{{ route("admin.desarrolladora.ban", [":id" , "desarrolladora"]) }}';
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
            let url = '{{ route("admin.desarrolladora.unban", [":id" , "desarrolladora"]) }}';
            url = url.replace(':id', $(this).parent().prev().val());
            let motivo = $(this).prev().val();
            Swal.fire({
                title: '¿Quieres quitarle el ban a ésta desarrolladora?',
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
