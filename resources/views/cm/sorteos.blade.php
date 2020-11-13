@extends('layouts.cm.base')
@section('style')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.22/af-2.3.5/b-1.6.5/b-colvis-1.6.5/b-flash-1.6.5/b-html5-1.6.5/b-print-1.6.5/cr-1.5.2/fc-3.3.1/fh-3.1.7/kt-2.5.3/r-2.2.6/rg-1.1.2/rr-1.2.7/sc-2.0.3/sb-1.0.0/sp-1.2.1/sl-1.3.1/datatables.min.css"/>
@endsection
@section('content')
    <div class="container">
        <div class='row'>
            <div class='col-sm'>
                <div class="box-header">
                    <h1 class="d-inline-block">Sorteos ({{ $sorteos->count() }})</h1>
                    <a href="{{ route('cm.sorteos.create') }}" class='btn btn-success btn-sm round float-right mt-2'><i
                            class="far fa-plus-square"></i></a>
                </div>
                <div class="table-responsive box mt-4">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <td class="w-20">Título</td>
                                <td class="w-30">Descripción</td>
                                <td class="w-20 text-center">Participaciones</td>
                                <td class="w-20">Ganador</td>
                                <td class="w-10 text-center">Acciones</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sorteos as $sorteo)
                                <tr>
                                    <td class="w-20">{{ $sorteo->titulo }}</td>
                                    <td class="w-30">{{ $sorteo->descripcion }}</td>
                                    <td class="w-20 text-center">{{ $sorteo->usuarios->count() }}</td>
                                    <td class="w-20">Ganador</td>
                                    <td class="align-middle w-10 text-center">
                                        <div class="btn-group">
                                            <button class='btn btn-primary btn-sm round mr-1' type='submit'>
                                                <i class="far fa-edit"></i>
                                            </button>
                                            <button class='btn btn-danger btn-sm round ml-1' type='submit'>
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
        </div>
    </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.22/af-2.3.5/b-1.6.5/b-colvis-1.6.5/b-flash-1.6.5/b-html5-1.6.5/b-print-1.6.5/cr-1.5.2/fc-3.3.1/fh-3.1.7/kt-2.5.3/r-2.2.6/rg-1.1.2/rr-1.2.7/sc-2.0.3/sb-1.0.0/sp-1.2.1/sl-1.3.1/datatables.min.js"></script>
    <script type="text/javascript">
        $(function() {
            $('table').dataTable();
        });
    </script>
@endsection
