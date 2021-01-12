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
                    <h1 class="d-inline-block">Desarrolladoras ({{ $desarrolladoras->count() }})</h1>
                    @if ($numSolicitudes > 0)
                        <a href="{{ route('admin.solicitudes.index') }}" class="btn btn-success btn-sm float-right mt-2">Solicitudes ({{ $numSolicitudes }})</a>
                    @endif
                </div>
                <div class="box">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <td>Nombre</td>
                                    <td>Email</td>
                                    <td>Dirección</td>
                                    <td>Teléfono</td>
                                    <td>Url</td>
                                    <td class="text-center">Strikes</td>
                                    <td class="text-center">Acciones</td>
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
                                        <td class="align-middle text-center">{{ $desarrolladora->reportes }}</td>
                                        <td class="align-middle text-center">
                                            <div class="btn-group">
                                                <input type="hidden" name="id" value="{{ $desarrolladora->id }}">
                                                <div class="ban">
                                                    <input type="hidden" name="id" value="{{ $desarrolladora->id }}">
                                                    @if($desarrolladora->ban == null)
                                                        <button class="btn btn-warning btn-sm round btn-ban" type="submit">
                                                            <i class="far fa-gavel"></i>
                                                        </button>
                                                    @else
                                                        <input type="hidden" name="motivo" value="{{ $desarrolladora->motivo }}">
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
                let url = `/admin/desarrolladora/${id}/ban`;
                ban(elemento, url, "Indica el motivo");
            });

            $(".btn-unban").on('click', function() {
                let elemento = $(this);
                let id = $(this).prev().prev().val();
                let url = `/admin/desarrolladora/${id}/unban`;
                let motivo = $(this).prev().val();
                unban(elemento, url, motivo, "¿Quieres quitarle el ban a la desarrolladora?");
            });
        });

    </script>
@endsection
