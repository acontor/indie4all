@extends('layouts.cm.base')
@section('content')
    <style>
        .mt-5 {
            margin-top: 5rem;
        }

        .our-games {
            background-color: #f8f9fa;
            padding: 100px 0;
        }

        .container {
            max-width: 960px;
            margin: 0 auto;
        }

        .row {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
        }

        .text-center {
            text-align: center;
            font-size: 18px;
        }

        .text-center h2 {
            font-weight: 500;
            font-size: 1.6em;
        }

        .text-center h2 span {
            font-weight: 800;
        }

        .text-center p {
            max-width: 500px;
            margin: 0 auto;
            color: #6c757d;
            line-height: 1.5;
            font-size: 1em;
        }

        .col {
            width: 33.3333333%;
            overflow: hidden;
            padding: 15px;
        }

        .col .card {
            width: 100%;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease;
        }

        .col img {
            width: 100%;
            height: auto;
            border: 0;
        }

        .col .card-body {
            padding: 0 15px 15px 15px;
            background-color: #fff;
            border-bottom-left-radius: 15px;
            border-bottom-right-radius: 15px;
        }

        .card-body h5 {
            font-size: 24px;
            margin: 7px 0;
        }

        .card:hover {
            transform: translateY(-10px);
            transition: transform 0.3s ease;
        }

        .card p {
            color: #6c757d;
        }

        .card-body .date-lanzamiento span {
            color: #e74c3c;
        }

        .card-body h5 a {
            color: #222;
        }

        @media(min-width: 577px) and (max-width: 768px) {
            .col {
                width: 50%;
            }
        }

        @media(max-width: 576px) {
            .col {
                width: 100%;
            }
        }

    </style>

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
                                                <button class='btn btn-danger btn-sm round ml-1' type='submit'><i
                                                        class="far fa-trash-alt"></i></button>
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
    </div>

@endsection
