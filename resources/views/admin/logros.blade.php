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
                    <h1 class="d-inline-block">Logros ({{ $logros->count() }})</h1>
                    <a href="{{ route('admin.logros.create') }}" class="btn btn-success btn-sm round float-right mt-2"><i class="far fa-plus-square"></i></a>
                </div>
                <div class="box mt-4">
                    <canvas id="myChart"></canvas>
                </div>
                <div class="box mt-4">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <td class="w-10 text-center">Icono:</td>
                                    <td class="w-30">Nombre</td>
                                    <td class="w-40">Descripción</td>
                                    <td class="w-10 text-center">Conseguido</td>
                                    <td class="w-10 text-center">Acciones</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($logros as $logro)
                                    <tr>
                                        <td class="align-middle w-10 text-center"><i class="{{ $logro->icono }}"></i></td>
                                        <td class="align-middle w-30">{{ $logro->nombre }}</td>
                                        <td class="align-middle w-40">{{ $logro->descripcion }}</td>
                                        <td class="align-middle w-10 text-center">{{ round(Illuminate\Support\Facades\DB::table('logro_user')->where('logro_id', $logro->id)->count() * 100 / App\Models\User::count(), 2) }} %</td>
                                        <td class="align-middle w-10 text-center">
                                            <div class="btn-group">
                                                <form action="{{ route('admin.logros.edit', $logro->id) }}" method="post">
                                                    @csrf
                                                    <button class="btn btn-primary btn-sm round mr-1" type="submit">
                                                        <i class="far fa-edit"></i>
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
    </div>
@endsection

@section("scripts")
    <script src="{{ asset('js/datatable/datatable.js') }}"></script>
    <script src="{{ asset('js/datatable/script.js') }}"></script>
    <script src="{{ asset('js/sweetalert/sweetalert.min.js') }}"></script>
    <script src="{{ asset('js/script.js') }}"></script>
    <script src="{{ asset('js/admin.js') }}"></script>
    <script src="{{ asset('js/chart/chart.min.js') }}"></script>
    @if (Session::has('success'))
        <script defer>
            notificacionEstado('success', "{{ Session::get('success') }}");

        </script>
    @elseif(Session::has('error'))
        <script defer>
            notificacionEstado('error', "{{ Session::get('error') }}");

        </script>
    @endif
    <script>
        $(function() {
            var logros = {!! $logros !!};
            var datos = {!! json_encode($datos) !!};

            var nombreLogro = [];

            logros.forEach(element => {
                nombreLogro.push(element["nombre"])
            });

            graficaLogros(nombreLogro, datos);
        });

    </script>
@endsection
