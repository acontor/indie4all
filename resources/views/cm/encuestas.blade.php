@extends('layouts.cm.base')
@section('content')
    <div class="container">
        <div class='row'>
            <div class='col-sm'>
                <div class="box-header">
                    <h1 class="d-inline-block">Encuestas  ({{ $encuestas->count() }})</h1>
                    <a href="{{ route('cm.encuestas.create') }}" class='btn btn-success btn-sm round float-right mt-2'><i class="far fa-plus-square"></i></a>
                </div>
                <div class="table-responsive box mt-4">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <td class="w-20">Pregunta</td>
                                <td class="w-30">Fecha fin</td>
                                <td class="w-20 text-center">Participaciones</td>
                                <td class="w-20">Resultado</td>
                                <td class="w-10 text-center">Acciones</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($encuestas as $encuesta)
                                <tr>
                                    <td class="w-20">{{ $encuesta->pregunta }}</td>
                                    <td class="w-30">{{ $encuesta->fecha_fin }}</td>
                                    <td class="w-20 text-center">0</td>
                                    <td class="w-20">-</td>
                                    <td class="align-middle w-10 text-center">
                                        <div class="btn-group">
                                            <form action="{{ route('cm.encuestas.destroy', $encuesta->id) }}" method='post'>
                                                @csrf
                                                @method('DELETE')
                                                <button class='btn btn-danger btn-sm round ml-1' type='submit'><i class="far fa-trash-alt"></i></button>
                                            </form>
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
