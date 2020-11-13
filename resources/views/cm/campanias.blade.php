@extends('layouts.cm.base')
@section('content')
    <div class="container">
        <div class='row'>
            <div class='col-sm'>
                <div class="box-header">
                    <h1>campañas {{ $juegos->count() }}</h1>
                    @foreach ($juegos as $juego)
                        {{ $juego->campania }}
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
