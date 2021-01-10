@extends("layouts.admin.base")

@section("styles")
    <link href="{{ asset('css/datatable/datatable.css') }}" rel="stylesheet">
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
                                                <input type="hidden" name="id" value="{{ $juego->campania->id }}">
                                                @if($juego->campania->ban == null)
                                                    <button class="btn btn-warning btn-sm round btn-ban" type="submit">
                                                        <i class="far fa-gavel"></i>
                                                    </button>
                                                @else
                                                    <input type="hidden" name="motivo" value="{{ $juego->campania->motivo }}">
                                                    <button class="btn btn-success btn-sm round btn-unban" type="submit">
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
    <script type="text/javascript">
        $(function() {
            $(".btn-ban").click(function() {
                let elemento = $(this);
                let id = elemento.prev().val();
                let url = `/admin/campania/${id}/ban`;
                ban(elemento, url, 'Indica el motivo');
            });

            $(".btn-unban").click(function() {
                let elemento = $(this);
                let id = $(this).prev().prev().val();
                let url = `/admin/usuario/${id}/unban`;
                let motivo = $(this).prev().val();
                unban(elemento, url, motivo, '¿Quieres activar de nuevo la campaña?');
            });
        });

    </script>
@endsection
