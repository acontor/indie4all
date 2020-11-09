@extends('layouts.admin.base')
@section('content')
    <div class="container">
        <div class='row'>
            <div class='col-sm'>
                <h1 class='display-5'>Noticias ({{ $noticias->count() }})</h1>
                <a href="{{ route('admin.noticias.create') }}" class='btn btn-success button-crear mb-3'>+</a>
                @if (session()->get('success'))
                    <div class='alert alert-success'>
                        {{ session()->get('success') }}
                    </div>
                @endif
                <div class="table-responsive">
                    <table class='table table-striped'>
                        <thead>
                            <tr>
                                <td>Título</td>
                                <td>Acciones</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($noticias as $noticia)
                                <tr>
                                    <td class="align-middle">{{ $noticia->titulo }}</td>
                                    <td class="align-middle">
                                        <form action="{{ route('admin.noticias.destroy', $noticia->id) }}" method='post'>
                                            @csrf
                                            @method('DELETE')
                                            <button class='btn btn-danger' type='submit'>Borrar</button>
                                        </form>
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
