@extends('layouts.cm.base')
@section('content')
    <div class="container">
        <div class='row'>
            <div class='col-sm'>
                <div class="box-header">
                    <h1 class="d-inline-block">Encuestas {{ $encuestas->count() }}</h1>
                </div>
            </div>
        </div>
    </div>
@endsection