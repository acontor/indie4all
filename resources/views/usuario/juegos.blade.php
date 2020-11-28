@extends("layouts.usuario.base")
@section("styles")
    <link href="{{ asset('css/juegos.css') }}" rel="stylesheet">
@endsection
@section("content")
    <main class="py-4">
        <div class="container">
            <div class="row">
                <div class="col-sm">
                    <div class="box-header">
                        <h1 class="d-inline-block">Juegos ({{ $juegos->count() }})</h1>
                    </div>
                </div>
            </div>
            <div class="cd-slider">
                <ul>
                    @foreach ($juegos as $juego)
                    <li>
                        <div class="image" style="background-image:url({{url('/images/juegos/portadas/'.$juego->imagen_portada)}});"></div>
                        <div class="content">
                        <h2>{{$juego->nombre}}</h2>
                        <a href="{{ route('usuario.juego.show', $juego->id) }}">Ver Juego</a>  <br>
                        <a href="#">{{$juego->genero->nombre}}</a>
                        <p> {{$juego->sinopsis}}</p>

                        </div>
                    </li>
                    @endforeach

                </ul>
            </div> <!--/.cd-slider-->
                <div class="row mt-3">
                    <div class="col-8 noticias">
                        Lorem ipsum dolor sit amet consectetur, adipisicing elit. Beatae quas animi cum exercitationem mollitia fugiat, est assumenda dolor nihil molestias, ab veritatis amet quis blanditiis debitis officia. Quis, sed numquam!
                    </div>
                    <div class="col-4">
                        <div class="row recomendados">
                            5 juegos con los géneros seguidos y más seguidores
                        </div>
                        <div class="row seguidos">Lorem ipsum dolor, sit amet consectetur adipisicing elit. A aliquid iste, ad, est vel doloribus repudiandae earum deleniti rem laudantium officiis numquam facilis recusandae, ex unde assumenda libero voluptas sint.</div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
@section('scripts')
<script src="{{ asset('js/juegos.js') }}"></script>
@endsection
