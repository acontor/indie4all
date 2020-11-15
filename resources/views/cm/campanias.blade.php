@extends('layouts.cm.base')
@section('content')
    <div class="container">
        <div class='row'>
            <div class='col-sm'>
                <div class="box-header">
                    <h1 class="d-inline-block">Campañas</h1>
                </div>
                <div class="table-responsive box mt-4">
                    <table class='table table-striped'>
                        <thead>
                            <tr>
                                <td class="w-30">Nombre</td>
                                <td class="w-30">Campaña</td>
                                <td class="w-30">Recaudado</td>
                                <td class="w-40">Meta</td>
                                <td class="w-30">Fecha de finalización</td>
                                <td class="w-10 text-center">Acciones</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($juegos as $juego)
                                <tr>
                                    <td class="align-middle w-30">{{ $juego->nombre }}</td>
                                    <td class="align-middle w-30">
                                    @if ($juego->campania) Campaña Creada @else No
                                            activa
                                        @endif
                                    </td>
                                    <td class="align-middle w-30">
                                        @if (isset($juego->campania->recaudado))
                                            {{ $juego->campania->recaudado }} €
                                        @endif
                                    </td>
                                    <td class="align-middle w-30">
                                        @if (isset($juego->campania->meta))
                                            {{ $juego->campania->meta }} €
                                        @endif
                                    </td>
                                    <td class="align-middle w-30">
                                        @if (isset($juego->campania))
                                            {{ $juego->campania->fecha_fin }}
                                        @endif
                                    </td>

                                    <td class=" align-middle w-10 text-center">
                                        <div class="btn-group">
                                            @if ($juego->campania)
                                                <form
                                                    action="{{ route('cm.campanias.edit', ['idCampania' => $juego->campania->id, 'idJuego' => $juego->id]) }}"
                                                    method='post'>
                                                    @method('GET')
                                                    @csrf
                                                    <button class='btn btn-primary btn-sm round mr-1' type='submit'>
                                                        <i class="far fa-edit"></i>
                                                    </button>
                                                </form>
                                                <form action="{{ route('cm.campanias.destroy', $juego->campania->id) }}"
                                                    method='post'>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class='btn btn-danger btn-sm round ml-1' type='submit'><i
                                                            class="far fa-trash-alt"></i></button>
                                                </form>
                                            @else
                                                <form action="{{ route('cm.campanias.create', $juego->id) }}" method='get'>
                                                    @csrf
                                                    <button class='btn btn-success btn-sm round mr-1' type='submit'>
                                                        <i class="fas fa-plus-square"></i>
                                                    </button>
                                                </form>
                                            @endif

                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $juegos->links('pagination::bootstrap-4') }}
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
