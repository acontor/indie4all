<style>
    .card > img{
    height:150px;
    width:100%;
}
.item-card{
    transition:0.5s;
    cursor:pointer;
}
.item-card-title{
    font-size:15px;
    transition:1s;
    cursor:pointer;
}
.card:hover{
    transform: scale(1.05);
    box-shadow: 10px 10px 15px rgba(0,0,0,0.3);
}
</style>
@isset($juegos)
@if($juegos->count()==0)
    <div>
        No se ha encontrado ningún resultado
    </div>
@endif
<div class="row mb-4 mt-2">
    @foreach ($juegos as $juego)
        <div class="col-md-3 col-sm-6 mt-4 item">
            <div class="card item-card card-block">
                @if ($juego->imagen_caratula != null)
                    <img class="w-100 h-100" src="{{ asset('/images/desarrolladoras/' . $juego->desarrolladora->nombre . '/' . $juego->nombre . '/' . $juego->imagen_caratula) }}" alt="{{ $juego->nombre }}">
                @else
                    <img class="w-100 h-100" src="{{ asset('/images/desarrolladoras/default-logo-juego.png') }}" alt="{{ $juego->nombre }}">
                @endif
                <div class="p-3">
                    <h5><a href="{{ route('usuario.juego.show', $juego->id) }}">{{ $juego->nombre }}</a></h5>
                    <small class="float-right"> {{$juego->fecha_lanzamiento}}</small><br>
                    <a href="">{{App\Models\Genero::find($juego->genero_id)->nombre}}</a><br>
                    Popularidad:<small class="float-right"> {{$juego->compras->count()}}</small><br>
                    Precio:<small class="float-right"> {{$juego->precio}}</small>
                </div>
            </div>
        </div>
    @endforeach
</div>
    @php
        $data = $juegos;
    @endphp
@endisset

@isset($masters)
    @if($masters->count()==0)
        <div>
            No se ha encontrado ningún resultado
        </div>
    @endif
    <div class="row mb-4 mt-2">
        @foreach ($masters as $master)
        @if($master->usuario->ban)
        @else
        <div class="col-md-3 col-sm-6 mt-4 item">
            <div class="card item-card card-block">
                @if ($master->imagen_portada != null)
                    <img class="w-100 h-100" src="{{ asset('/images/masters/' . $master->nombre . '/' . $master->imagen_portada) }}" alt="{{ $master->nombre }}">
                @else
                    <img class="w-100 h-100" src="{{ asset('/images/masters/default-portada.png') }}" alt="{{ $master->nombre }}">
                @endif
                <div class="p-3">
                    <h5><a href="{{ route('usuario.master.show', $master->id) }}">{{ $master->nombre }}</a></h5>
                    Sequidores:<small class="float-right"> {{$master->seguidores_count}}</small><br>
                    Actividad:<small class="float-right"> {{$master->posts_count}}</small><br>
                </div>
            </div>
        </div>
        @endif
        @endforeach
    </div>
    @php
        $data = $masters;
    @endphp
@endisset

@isset($desarrolladoras)
    @if($desarrolladoras->count()==0)
        <div>
            No se ha encontrado ningún resultado
        </div>
    @endif
    <div class="row mb-4 mt-2">
        @foreach ($desarrolladoras as $desarrolladora)
        <div class="col-md-3 col-sm-6 mt-4 item">
            <div class="card item-card card-block">
                @if ($desarrolladora->imagen_logo != null)
                    <img class="w-100 h-100" src="{{ asset('/images/desarrolladoras/' . $desarrolladora->nombre . '/' . $desarrolladora->imagen_logo) }}" alt="{{ $desarrolladora->nombre }}">
                @else
                    <img class="w-100 h-100" src="{{ asset('/images/desarrolladoras/default-logo-desarrolladora.png') }}" alt="{{ $desarrolladora->nombre }}">
                @endif
                <div class="p-3">
                    <h5><a href="{{ route('usuario.desarrolladora.show', $desarrolladora->id) }}">{{ $desarrolladora->nombre }}</a></h5>
                    Sequidores:<small class="float-right"> {{$desarrolladora->seguidores_count}}</small><br>
                    Juegos:<small class="float-right"> {{$desarrolladora->juegos_count}}</small><br>
                    Actividad:<small class="float-right"> {{$desarrolladora->posts_count}}</small><br>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @php
        $data = $desarrolladoras;
    @endphp
@endisset
@isset($campanias)
    @if($campanias->count()==0)
        <div>
            No se ha encontrado ningún resultado
        </div>
    @endif
    <div class="row mb-4 mt-5">
        @foreach ($campanias as $campania)
        @if($campania->ban)
        @else
        <div class="col-md-3 col-sm-6 mt-4 item">
            <div class="card item-card card-block">
                @if ($campania->juego->imagen_caratula != null)
                    <img class="w-100 h-100" src="{{ asset('/images/desarrolladoras/' . $campania->juego->desarrolladora->nombre . '/' . $campania->juego->nombre . '/' . $campania->juego->imagen_caratula) }}" alt="{{ $campania->juego->nombre }}">
                @else
                    <img class="w-100 h-100" src="{{ asset('/images/desarrolladoras/default-logo-juego.png') }}" alt="{{ $campania->juego->nombre }}">
                @endif
                <div class="p-3">
                    <h5><a href="{{ route('usuario.campania.show', $campania->id) }}">{{ $campania->juego->nombre }}</a></h5>
                    Participaciones:<small class="float-right"> {{$campania->compras_count}}</small><br>
                    Recaudado:<small class="float-right"> {{$campania->recaudado}}€</small><br>
                    Meta:<small class="float-right"> {{$campania->meta}}€</small><br>
                    Aporte min:<small class="float-right"> {{$campania->aporte_minimo}}</small><br>
                    Termina:<small class="float-right"> {{$campania->fecha_fin}}</small>
                </div>
            </div>
        </div>
        @endif
        @endforeach
    </div>
    @php
        $data = $campanias;
    @endphp
@endisset

@if($data instanceof \Illuminate\Pagination\Paginator || $data instanceof \Illuminate\Pagination\LengthAwarePaginator)
<div class="row">
    <div class="col-1">
        {!! $data->links('pagination::bootstrap-4') !!}
    </div>
</div>
@endif
