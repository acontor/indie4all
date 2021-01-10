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
<div class="row mb-4 mt-5">
    @foreach ($juegos->take('10') as $juego)
        <div class="col-md-3 col-sm-6 mt-4 item">
            <div class="card item-card card-block">
                    <img src="{{ asset('/images/default.png') }}" alt="Foto de juego">
                    <div class="p-3">
                        <h5><a href="{{ route('usuario.juego.show', $juego->id) }}">{{ $juego->nombre }}</a></h5>
                        <a href="">{{$juego->genero->nombre}}</a><br>
                        <p class="float-right">{{$juego->precio}}€</p>
                    </div>
            </div>
        </div>
    @endforeach
</div>
<div class="row">
    <div class="col-2">
        {!! $juegos->links('pagination::bootstrap-4') !!}
    </div>
</div>
