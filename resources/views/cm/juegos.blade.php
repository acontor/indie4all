@extends('layouts.cm.base')
@section('styles')
<link href="{{ asset('css/cm.css') }}" rel="stylesheet">
@endsection
@section('content')

    <div class="container">
        <div class='row'>
            <div class='col-sm'>
                <div class="box-header">
                    <h1 class='d-inline-block'>Juegos {{ $juegos->count() }}</h1>
                    <a href="{{ route('cm.juegos.create') }}" class='btn btn-success btn-sm round float-right mt-2'><i
                            class="far fa-plus-square"></i></a>
                </div>
            </div>
        </div>
        <div class="row">
            <section>
                <div class="container">

                    <div class="row mt-5">
                        @foreach ($juegos as $juego)
                            <div class="col">
                                <div class="card">

                                    <img src="{{ asset('/images/default.png') }}" />

                                    <div class="card-body">
                                        <h5 class="card-title">
                                            <a href="{{ route('usuario.juego.show', $juego->id) }}">{{ $juego->nombre }}</a>

                                        </h5>
                                        <p class="date-lanzamiento">
                                            {{ $juego->fecha_lanzamiento }} <span
                                                class="genero">{{ $juego->genero->nombre }}</span>
                                        </p>
                                        <p class="card-text">
                                            {{ $juego->sinopsis }}
                                        </p>
                                        <div class="row">
                                            <a class="btn btn-primary btn-sm round ml-1" title="Editar Juego"
                                                href="{{ route('cm.juegos.edit', $juego->id) }}">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <form action="{{ route('cm.juegos.destroy', $juego->id) }}" method='post'>
                                                @csrf
                                                @method('DELETE')
                                                <button class='btn btn-danger btn-sm round ml-1 btn-delete'
                                                    type='submit'><i class="far fa-trash-alt"></i></button>
                                            </form>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        </div>
        {{ $juegos->links('pagination::bootstrap-4') }}
    </div>

@endsection
@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        $(function() {

            $('.btn-delete').on('click', function(e) {
                e.preventDefault();
                var form = $(this).parents('form');
                Swal.fire({
                    title: "seguro?",
                    text: "No recuperarás el juego!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Sí, estoy seguro!",
                    closeOnConfirm: false
                }, function(isConfirm) {
                    if (isConfirm) form.submit();
                });
            });


        });

    </script>
@endsection
