@extends("layouts.admin.base")
@section("styles")
    <link href="{{ asset('css/datatable.css') }}" rel="stylesheet">
@endsection
@section("content")
    <div class="container">
        <div class="row">
            <div class="col-sm">
                <div class="box-header">
                    <h1>Campañas ({{ $juegos->count() }})</h1>
                </div>
                <div class="box">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <td>Nombre</td>
                                <td>Fecha de fin</td>
                                <td>Meta</td>
                                <td>Recaudado</td>
                                <td class="text-center">Acciones</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($juegos as $juego)
                                <tr>
                                    <td class="align-middle">{{ $juego->nombre }}</td>
                                    <td class="align-middle">{{ $juego->campania->fecha_fin }}</td>
                                    <td class="align-middle">{{ $juego->campania->meta }} €</td>
                                    <td class="align-middle">{{ $juego->campania->recaudado }} €</td>
                                    <td class="align-middle text-center">
                                        <div class="btn-group">
                                            <a href="{{ route('admin.campania.show', $juego->campania->id) }}" class="btn btn-primary btn-sm round mr-1"><i class="far fa-eye"></i></a><input type="hidden" name="id" value="{{ $juego->id }}">
                                            <input type="hidden" name="id" value="{{ $juego->campania->id }}">
                                            <div class="ban">
                                                @if($juego->campania->ban == null)
                                                <button class="btn btn-warning btn-sm round" type="submit">
                                                    <i class="far fa-gavel"></i>
                                                </button>
                                                @else
                                                <input type="hidden" name="motivo" value="{{ $juego->campania->motivo }}">
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
    <script src="{{ asset('js/datatable.js') }}"></script>
    <script src="{{ asset('js/sweetalert.min.js') }}"></script>
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
            let url = '{{ route("admin.campania.ban", [":id" , "campania"]) }}';
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
            let url = '{{ route("admin.campania.unban", [":id" , "campania"]) }}';
            url = url.replace(':id', $(this).parent().prev().val());
            let motivo = $(this).prev().val();
            Swal.fire({
                title: '¿Quieres quitarle el ban a ésta campaña?',
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
