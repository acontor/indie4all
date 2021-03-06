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
                    <h1>Juegos ({{ $juegos->count() }})</h1>
                </div>
                <div class="box">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <td>Nombre</td>
                                    <td>Fecha de lanzamiento</td>
                                    <td>Precio</td>
                                    <td>Desarrolladora</td>
                                    <td class="text-center">Acciones</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($juegos as $juego)
                                    <tr>
                                        <td class="align-middle">{{ $juego->nombre }}</td>
                                        <td class="align-middle">{{ $juego->fecha_lanzamiento }}</td>
                                        <td class="align-middle">{{ $juego->precio }} €</td>
                                        <td class="align-middle">{{ $juego->desarrolladora->nombre }}</td>
                                        <td class="align-middle text-center">
                                            <div class="btn-group">
                                                <input type="hidden" name="id" value="{{ $juego->id }}">
                                                <div class="ban">
                                                    <input type="hidden" name="id" value="{{ $juego->id }}">
                                                    @if($juego->ban == null)
                                                        <button class="btn btn-warning btn-sm round btn-ban" type="submit">
                                                            <i class="far fa-gavel"></i>
                                                        </button>
                                                    @else
                                                        <input type="hidden" name="motivo" value="{{ $juego->motivo }}">
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
    </div>
@endsection

@section("scripts")
    <script src="{{ asset('js/datatable/datatable.js') }}"></script>
    <script src="{{ asset('js/datatable/script.js') }}"></script>
    <script src="{{ asset('js/sweetalert/sweetalert.min.js') }}"></script>
    <script src="{{ asset('js/script.js') }}"></script>
    <script src="{{ asset('js/admin.js') }}"></script>
    <script type="text/javascript">
        $(function() {
            $(".btn-ban").on('click', function() {
                let elemento = $(this);
                let id = elemento.prev().val();
                let url = `http://www.iestrassierra.net/alumnado/curso2021/DAWS/daws2021a1/indie4all/admin/juego/${id}/ban`;
                ban(elemento, url, "Indica el motivo");
            });

            $(".btn-unban").on('click', function() {
                let elemento = $(this);
                let id = $(this).prev().prev().val();
                let url = `http://www.iestrassierra.net/alumnado/curso2021/DAWS/daws2021a1/indie4all/admin/juego/${id}/unban`;
                let motivo = $(this).prev().val();
                unban(elemento, url, motivo, "¿Quieres quitarle el ban al juego?");
            });
        });

    </script>
@endsection
