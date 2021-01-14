@extends("layouts.master.base")

@section('content')
    <div class="container">
        <div class="box-header">
            <h1>Vista general</h1>
        </div>
        <div class="box mt-4">
            <div class="row">
                <div class="col-12">
                    <h2>Nuevos seguidores últimos 5 días</h2>
                    <canvas id="active-users"></canvas>
                </div>
            </div>
        </div>
        <div class="box mt-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Seguidores</h5>
                    <small class="card-subtitle mb-2">Datos sobre seguidores.</small>
                </div>
                <div class="row text-center">
                    <div class="col-sm-6 col-md-4 mb-3">
                        <h6 class="card-title">Total</h6>
                        <p class="card-text text-center">{{ $master->seguidores->count() }}</p>
                    </div>
                    <div class="col-sm-6 col-md-4 mb-3">
                        @php
                            $count = 0;
                        @endphp
                        @foreach ($master->seguidores as $seguidor)
                            @php
                                if((abs(strtotime($seguidor->pivot->created_at->format('Y-m-d')) - strtotime(date('Y-m-d'))) / 86400) <= 31) {
                                    $count ++;
                                }
                            @endphp
                        @endforeach
                        <h6 class="card-title">Último mes natural</h6>
                        <p class="card-text text-center">{{ $count }}</p>
                    </div>
                    <div class="col-sm-6 col-md-4 mb-3">
                        @php
                            $count = 0;
                        @endphp
                        @foreach ($master->seguidores as $seguidor)
                            @php
                                if((abs(strtotime($seguidor->pivot->created_at->format('Y-m-d')) - strtotime(date('Y-m-d'))) / 86400) <= 365) {
                                    $count ++;
                                }
                            @endphp
                        @endforeach
                        <h6 class="card-title">Último año natural</h6>
                        <p class="card-text text-center">{{ $count }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="box mt-4">
            <div class="card">
                <div class="card-body">
                    <a href="{{ route('master.analisis.index') }}">
                        <h5 class="card-title">Análisis <i class="fas fa-link"></i></h5>
                    </a>
                    <small class="card-subtitle mb-2">Datos sobre análisis.</small>
                </div>
                <div class="row text-center">
                    <div class="col-sm-6 col-md-3 mb-3">
                        <h6 class="card-title">Análisis totales</h6>
                        <p class="card-text text-center">{{ $master->posts->where('juego_id', '!=', null)->count() }}</p>
                    </div>
                    <div class="col-sm-6 col-md-3 mb-3">
                        @php
                            $count = 0;
                        @endphp
                        @foreach ($master->posts->where('juego_id', '!=', null) as $post)
                            @php
                                $count += $post->comentarios->count();
                            @endphp
                        @endforeach
                        <h6 class="card-title">Comentarios totales</h6>
                        <p class="card-text text-center">{{ $count }}</p>
                    </div>
                    <div class="col-sm-6 col-md-3 mb-3">
                        <h6 class="card-title">Comentarios media</h6>
                        @if($master->posts->where('juego_id', '!=', null)->count() > 0)
                            <p class="card-text text-center">{{ $count / $master->posts->where('juego_id', '!=', null)->count() }}</p>
                        @else
                            <p class="card-text text-center">-</p>
                        @endif
                    </div>
                    <div class="col-sm-6 col-md-3 mb-3">
                        @php
                            $count = 0;
                        @endphp
                        @foreach ($master->posts->where('juego_id', '!=', null) as $post)
                            @php
                                $count += $post->calificacion;
                            @endphp
                        @endforeach
                        <h6 class="card-title">Calificaciones media</h6>
                        @if($master->posts->where('juego_id', '!=', null)->count() > 0)
                            <p class="card-text text-center">{{ $count / $master->posts->where('juego_id', '!=', null)->count() }}</p>
                        @else
                            <p class="card-text text-center">-</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/chart/chart.min.js') }}"></script>
    <script src="{{ asset('js/master.js') }}"></script>
    <script>
        $(function() {
            let seguidores = {!! json_encode($master->seguidores) !!};
            graficaUsuarios(seguidores);
        });

    </script>

@endsection
