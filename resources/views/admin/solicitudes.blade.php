@extends("layouts.admin.base")

@section('styles')
    <link href="{{ asset('css/animate/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/datatable/datatable.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm">
                <div class="box-header">
                    <h1>Solicitudes (<span class="numero-solicitudes">{{ $desarrolladoras->count() + $masters->count() }}</span>)</h1>
                </div>
                @if ($desarrolladoras->count() > 0)
                    <div class="box desarrolladoras">
                        <h2 class="mb-4">Desarrolladoras (<span class="numero-desarrolladoras">{{ $desarrolladoras->count() }}</span>)</h2>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <td>Nombre</td>
                                    <td>Email</td>
                                    <td>Dirección</td>
                                    <td>Teléfono</td>
                                    <td>Url</td>
                                    <td>Solicitante</td>
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
                                        <td class="align-middle">{{ $desarrolladora->usuario->name }}</td>
                                        <td class="align-middle">
                                            <div class="btn-group">
                                                <input type="hidden" value="{{ $desarrolladora->comentario }}">
                                                <input type="hidden" value="{{ $desarrolladora->id }}">
                                                <button class="btn btn-primary btn-sm round ml-1 ver-solicitud-desarrolladora"><i class="far fa-eye"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
                @if ($masters->count() > 0)
                    <div class="box masters">
                        <h2>Masters (<span class="numero-masters">{{ $masters->count() }}</span>)</h2>
                        <div class="table-responsive mb-3">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <td>Nombre</td>
                                        <td>Email</td>
                                        <td>Solicitante</td>
                                        <td>Acciones</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($masters as $master)
                                        <tr>
                                            <td class="align-middle">{{ $master->nombre }}</td>
                                            <td class="align-middle">{{ $master->email }}</td>
                                            <td class="align-middle">{{ $master->usuario->name }}</td>
                                            <td class="align-middle">
                                                <div class="btn-group">
                                                    <input type="hidden" value="{{ $master->comentario }}">
                                                    <input type="hidden" value="{{ $master->id }}">
                                                    <button class="btn btn-primary btn-sm round ml-1 ver-solicitud-master"><i class="far fa-eye"></i></button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/datatable/datatable.js') }}"></script>
    <script src="{{ asset('js/sweetalert/sweetalert.min.js') }}"></script>
    <script src="{{ asset('js/script.js') }}"></script>
    <script src="{{ asset('js/admin.js') }}"></script>
@endsection
