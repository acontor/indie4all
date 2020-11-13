@extends('layouts.cm.base')
@section('content')
    <div class="container">
        <div class='row'>
            <div class='col-sm'>
                <div class="box-header">
                    <h1 class="d-inline-block">Sorteos ({{ $sorteos->count() }})</h1>
                        <a href="{{ route('cm.sorteos.create') }}" class='btn btn-success btn-sm round float-right mt-2'><i class="far fa-plus-square"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
