@extends('layouts.admin.base')
@section('content')
    <div class="container">
        <div class='row'>
            <div class='col-sm'>
                <div class="box-header">
                    <h1 class="d-inline-block">Noticias ({{ $noticias->count() }})</h1>
                    <a href="{{ route('admin.noticias.create') }}" class='btn btn-success button-crear btn-sm round float-right mt-2'><i class="far fa-plus-square"></i></a>
                </div>
                <div class="table-responsive box">
                    <table class='table table-striped'>
                        <thead>
                            <tr>
                                <td class="w-75">Título</td>
                                <td class="w-25 text-center">Acciones</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($noticias as $noticia)
                                <tr>
                                    <td class="align-middle">{{ $noticia->titulo }}</td>
                                    <td class="align-middle text-center">
                                        <div class="btn-group">
                                            <form action="{{ route('admin.noticias.edit', $noticia->id) }}" method='post'>
                                                @csrf
                                                <button class='btn btn-primary btn-sm round mr-1' type='submit'><i
                                                        class="far fa-edit"></i></button>
                                            </form>
                                            <form action="{{ route('admin.noticias.destroy', $noticia->id) }}"
                                                method='post'>
                                                @csrf
                                                @method('DELETE')
                                                <button class='btn btn-danger btn-sm round ml-1' type='submit'><i
                                                        class="far fa-trash-alt"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $noticias->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        $(function() {

            var session_success = {
                !!json_encode(session() - > get('success')) !!
            }

            if (session_success != undefined) {
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
