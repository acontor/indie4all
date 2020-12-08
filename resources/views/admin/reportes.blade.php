@extends("layouts.admin.base")
@section("content")
    <div class="container">
        <div class="row">
            <div class="col-sm">
                <div class="box-header">
                    <h1>Reportes ({{ $desarrolladoras->count() + $posts->count() + $mensajes->count() + $juegos->count() + $campanias->count() + $usuarios->count() }})</h1>
                </div>
                @if ($desarrolladoras->count() > 0)
                    <div class="box">
                        <h2>Desarrolladoras</h2>
                        <div class="table-responsive mb-3">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <td>Nombre</td>
                                        <td>Acciones</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($desarrolladoras as $desarrolladora)
                                        <tr>
                                            <td class="align-middle">{{ $desarrolladora->nombre }}</td>
                                            <td class="align-middle">
                                                <div class="btn-group">
                                                    <form action="">
                                                        <button class="btn btn-success btn-sm round ml-1" type="submit">
                                                            <i class="far fa-check-square"></i>
                                                        </button>
                                                    </form>
                                                    <button class="btn btn-danger btn-sm round ml-1 rechazar-desarrolladora" type="submit">
                                                        <i class="far fa-trash-alt"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
                @if ($posts->count() > 0)
                    <div class="box">
                        <h2>Posts</h2>
                        <div class="table-responsive mb-3">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <td>Nombre</td>
                                        <td>Acciones</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($posts as $post)
                                        <tr>
                                            <td class="align-middle">{{ $post->titulo }}</td>
                                            <td class="align-middle">
                                                <div class="btn-group">
                                                    <form action="">
                                                        <button class="btn btn-success btn-sm round ml-1" type="submit">
                                                            <i class="far fa-check-square"></i>
                                                        </button>
                                                    </form>
                                                    <button class="btn btn-danger btn-sm round ml-1 rechazar-desarrolladora" type="submit">
                                                        <i class="far fa-trash-alt"></i>
                                                    </button>
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
