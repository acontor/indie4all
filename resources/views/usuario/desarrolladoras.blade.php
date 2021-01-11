@extends("layouts.usuario.base")

@section('content')
    <main class="p-3 pb-5">
        <div class="container box mt-4">
            <div class="row mb-4">
                <h3 class="col-12 text-center text-uppercase font-weight-bold">Destacados</h3>
                <div class="col-12 offset-md-2 col-md-8">
                    <div class="owl-carousel owl-theme mt-3">
                        @foreach ($desarrolladoras->take('10') as $desarrolladora)
                            <div class="item m-2 shadow">
                                <a href="{{ route('usuario.desarrolladora.show', $desarrolladora->id) }}">
                                    @if ($desarrolladora->imagen_logo != null)
                                        <img src="{{ asset('/images/desarrolladoras/' . $desarrolladora->nombre . '/' . $desarrolladora->imagen_logo) }}" alt="{{ $desarrolladora->nombre }}">
                                    @else
                                        <img src="{{ asset('/images/desarrolladoras/default-logo-desarrolladora.png') }}" alt="{{ $desarrolladora->nombre }}">
                                    @endif
                                    <div class="carousel-caption mb-2 d-none">
                                        <h6><strong>{{ $desarrolladora->nombre }}</strong></h6>
                                        <small>Seguidores: {{ $desarrolladora->seguidores->count() }}</small>
                                        <small>Actividad: {{ $desarrolladora->posts_count }}</small>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <hr class="mt-5 mb-5">
            <div class="row">
                <div class="col-12 col-md-9">
                    <div class="list-group shadow">
                        <ul class="list-group list-group-horizontal text-center text-uppercase font-weight-bold" style="font-size: .5rem;">
                            <li class="list-group-item bg-dark text-white">Últimas noticias</li>
                        </ul>
                        <div class="list-group-item flex-column align-items-start noticias">
                            <div class="items row mt-4">
                                @if($posts->count() > 0)
                                    @foreach ($posts->sortByDesc('created_at') as $post)
                                        <div class="col-12 col-md-6">
                                            <div class="pildoras mb-3">
                                                <span class="badge badge-pill badge-primary text-white">Noticia</span>
                                            </div>
                                            <h4>{{ $post->titulo }}</h4>
                                            <p>{!! substr($post->contenido, 0, 100) !!}</p>
                                            <form>
                                                <input type="hidden" name="id" value="{{ $post->id }}" />
                                                <a type="submit" class="btn btn-dark btn-sm more">Leer más</a>
                                            </form>
                                            <div class="footer-noticias mt-3">
                                                <small class="text-uppercase font-weight-bold"><a class="text-dark text-decoration-none" href="{{ route('usuario.desarrolladora.show', $post->desarrolladora->id) }}">{{ $post->desarrolladora->nombre }}</a></small>
                                                <small>{{ $post->created_at }}</small>
                                                <span class="float-right"><i class="far fa-comment-alt"></i> {{ $post->comentarios->count() }}</span>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <p>No se han encontrado noticias</p>
                                @endif
                            </div>
                            <div class="pager">
                                <div class="firstPage">&laquo;</div>
                                <div class="previousPage">&lsaquo;</div>
                                <div class="pageNumbers"></div>
                                <div class="nextPage">&rsaquo;</div>
                                <div class="lastPage">&raquo;</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-3 mt-3 mt-md-0">
                    <div class="list-group shadow">
                        <ul class="list-group list-group-horizontal text-center text-uppercase font-weight-bold" style="font-size: .5rem;">
                            <li class="list-group-item w-100 bg-dark text-white">Nuevo</li>
                            <a href="/desarrolladoras/lista" class="list-group-item list-group-item-action bg-danger text-white">Todos</a>
                        </ul>
                        @foreach ($desarrolladoras->sortByDesc('created_at')->take(5) as $desarrolladora)
                            <a href="{{route('usuario.desarrolladora.show', $desarrolladora->id)}}" class="list-group-item list-group-item-action flex-column align-items-start">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1"><b>{{$desarrolladora->nombre}}</b></h6>
                                    <small>{{$desarrolladora->created_at}}</small>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="more-div container bg-light p-5 shadow-lg rounded mt-4"></div>
        </div>
    </main>
@endsection

@section('scripts')
    <script>
        $(function() {
            $(".more").on('click', function () {
                let checkUser = false;
                let user = {
                    ban: "{{{ (Auth::user()) ? Auth::user()->ban : 1 }}}",
                    email_verified_at: "{{{ (Auth::user()) ? Auth::user()->email_verified_at : null }}}"
                };
                if(user.ban == 0 && user.email_verified_at != null) {
                    checkUser = true;
                }
                let url = '{{ route("usuario.post.show") }}';
                let id = $(this).prev().val();
                let config = '{{ asset("js/ckeditor/config.js") }}';
                more(url, id, config, checkUser);
            });

            let owl = $('.owl-carousel');

            crearOwl(owl, false, 2, 3, 4);

            $('img').addClass('img-fluid');
            $('img').addClass('h-auto');
        });

    </script>
@endsection
