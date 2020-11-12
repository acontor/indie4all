@extends('layouts.admin.base')
@section('content')
    <div class="container">
        <div class='row'>
            <div class='col-sm'>
                <div class="box-header">
                    <h1 class="d-inline-block">Logros ({{ $logros->count() }})</h1>
                    <a href="{{ route('admin.logros.create') }}" class='btn btn-success btn-sm round float-right mt-2'><i class="far fa-plus-square"></i></a>
                </div>
                <div class="table-responsive box mt-4">
                    <table class='table table-striped'>
                        <thead>
                            <tr>
                                <td class="w-10 text-center">Icono:</td>
                                <td class="w-30">Nombre</td>
                                <td class="w-50">Descripción</td>
                                <td class="w-10 text-center">Acciones</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($logros as $logro)
                                <tr>
                                    <td class="align-middle w-10 text-center"><img src="/images/logros/{{ $logro->icono }}" width="50” height=" 50” /></td>
                                    <td class="align-middle w-30">{{ $logro->nombre }}</td>
                                    <td class="align-middle w-50">{{ $logro->descripcion }}</td>
                                    <td class="align-middle w-10 text-center">
                                        <div class="btn-group">
                                            <form action="{{ route('admin.logros.edit', $logro->id) }}" method='post'>
                                                @csrf
                                                <button class='btn btn-primary btn-sm round mr-1' type='submit'>
                                                    <i class="far fa-edit"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.logros.destroy', $logro->id) }}" method='post'>
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
                {{ $logros->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        $(function() {

            var session_success = {!! json_encode(session()->get('success')) !!}

            if(session_success != undefined) {
                Swal.fire({
                    position: 'top-end',
                    title: session_success,
                    timer: 3000,
                    showConfirmButton: false,
                    showClass: {
                        popup: 'animate__animated animate__fadeInDown'
                    },
                    hideClass: {
                        popup: 'animate__animated animate__fadeOutUp'
                    },
                    allowOutsideClick: false,
                    backdrop: false,
                    width: 'auto',
                });
            }
        });

    </script>
@endsection
