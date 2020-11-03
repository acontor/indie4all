@extends('layouts.admin.base')
@section('content')
<div class="container">
    <div class='row'>
        <div class='col-sm'>

            <h1 class='display-3'>Logros <a class='btn btn-success mb-3 button-crear'>+</a></h1>

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
            @if (session()->get('success'))
            <div class='alert alert-success'>
                {{ session()->get('success') }}
            </div>
            @endif

            <div class="d-none form-crear">
                <form method='post' action="{{ route('logros.store') }}" enctype="multipart/form-data">
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
                        <label for='icono'>Icono:</label>
                        <input type='file' class='form-control' name='icono' />
                    </div>
                    <button type='submit' class='btn btn-success mb-3'>Añadir</button>
                </form>
            </div>

            <table class='table table-striped table-responsive-lg'>
                <thead>
                    <tr>
                        <td>Icono:</td>
                        <td>Nombre</td>
                        <td>Descripción</td>
                        <td>Icono</td>
                        <td>Editar</td>
                        <td>Borrar</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($logros as $logro)

                    <tr>
                        <form action="{{ route('logros.update', $logro->id) }}" method='post' enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <td><img src="/images/logros/{{$logro->icono}}" width="50” height=" 50” /> </td>
                            <td class="align-middle"><input type="text" placeholder="Nombre" value="{{ $logro->nombre }}" name="nombre"></td>
                            <td class="align-middle"><textarea id="descripcion" class="align-middle" placeholder="Descripción" name="descripcion" rows="1" cols="40">{{ $logro->descripcion }}</textarea></td>
                            <td><input type='file' class='form-control' name='icono' /></td>
                            <td class="align-middle"><button type="submit" class='btn btn-primary'>Editar</button>
                            </td>
                        </form>

                        <td>

                            <form action="{{ route('logros.destroy', $logro->id) }}" method='post'>
                                @csrf
                                @method('DELETE')
                                <button class='btn btn-danger' type='submit'>Borrar</button>
                            </form>

                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $logros->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(function() {
        $(".button-crear").click(function() {
            $(".form-crear").toggleClass("d-none");
            $(this).toggleClass("btn-danger");
            if ($(this).hasClass("btn-danger")) {
                $(this).text("-");
            } else {
                $(this).text("+");
            }
        })
    })
</script>
@endsection
