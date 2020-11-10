@extends('layouts.admin.base')
@section('content')
    <div class="container">
        <div class='row'>
            <div class='col-sm'>
                <div class="box-header">
                    <h1 class="d-inline-block">Logros ({{ $logros->count() }})</h1>
                    <a class='btn btn-success button-crear float-right mt-2'><i class="far fa-plus-square"></i></a>
                </div>
                @if ($errors->any())
                    <div class='alert alert-danger'>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <br />
                @endif


                <div class="d-none form-crear box">
                    <form method='post' action="{{ route('admin.logros.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class='form-group'>
                            <label for='nombre'>Nombre:</label>
                            <input type='text' class='form-control' name='nombre' />
                        </div>
                        <div class='form-group'>
                            <label for='descripcion'>Descripción:</label>
                            <input type='text' class='form-control' name='descripcion' />
                        </div>
                        <!-- Cambiar por un input file -->
                        <div class='form-group'>
                            <span class="btn btn-file">
                                <i class="fas fa-upload"></i> Icono
                                <input type='file' class='inputfile' name='icono' id='icono' />
                            </span>
                        </div>
                        <button type='submit' class='btn btn-success mb-3'>Añadir</button>
                    </form>
                </div>

                <div class="table-responsive box mt-4">
                    <table class='table table-striped'>
                        <thead>
                            <tr>
                                <td class="w-10 text-center">Icono:</td>
                                <td class="w-30">Nombre</td>
                                <td class="w-30">Descripción</td>
                                <td class="w-20 text-center">Icono</td>
                                <td class="w-10 text-center">Acciones</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($logros as $logro)

                                <tr>
                                    <form action="{{ route('admin.logros.update', $logro->id) }}" method='post'
                                        enctype="multipart/form-data">
                                        @csrf
                                        @method('PATCH')
                                        <td class="align-middle w-10 text-center"><img src="/images/logros/{{ $logro->icono }}" width="50” height=" 50” /> </td>
                                        <td class="align-middle w-30"><input type="text" placeholder="Nombre"
                                                value="{{ $logro->nombre }}" name="nombre"></td>
                                        <td class="align-middle w-30"><textarea id="descripcion" class="align-middle"
                                                placeholder="Descripción" name="descripcion" rows="1"
                                                cols="40">{{ $logro->descripcion }}</textarea></td>
                                        <td class="align-middle w-20 text-center">
                                            <span class="btn btn-file">
                                                <i class="fas fa-upload"></i>
                                                <input type='file' class='inputfile' name='icono' id='icono' />
                                            </span>
                                        </td>
                                        <td class="align-middle w-10 text-center">
                                            <div class="btn-group">
                                                <button class='btn btn-primary mr-1' type='submit'><i
                                                    class="far fa-edit"></i></button>
                                        </form>
                                            <form action="{{ route('admin.logros.destroy', $logro->id) }}" method='post'>
                                                @csrf
                                                @method('DELETE')
                                                <button class='btn btn-danger ml-1' type='submit'><i class="far fa-trash-alt"></i></button>
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

            $(".button-crear").click(function() {
                $(".form-crear").toggleClass("d-none");
                $(this).toggleClass("btn-danger");
                if ($(this).hasClass("btn-danger")) {
                    $(this).html("<i class='far fa-minus-square'></i>");
                } else {
                    $(this).html("<i class='far fa-plus-square'></i>");
                }
            });

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
