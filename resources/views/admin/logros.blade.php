@extends('../layouts.admin')

@section('content')
    <div class="container">
        <div class='row'>
            <div class='col-sm-8 offset-sm-2'>
                <h1 class='display-3'>Añadir un logro</h1>
                <div>
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
                    <form method='post' action="{{ route('logros.store') }}">
                        @csrf
                        <div class='form-group'>
                            <label for='nombre'>Nombre:</label>
                            <input type='text' class='form-control' name='nombre' />
                        </div>
                        <div class='form-group'>
                            <label for='descripcion'>Descripcion:</label>
                            <input type='text' class='form-control' name='descripcion' />
                        </div>
                        <div class='form-group'>
                            <label for='icono'>Icono:</label>
                            <input type='number' class='form-control' name='icono' />
                        </div>
                        <button type='submit' class='btn btn-primary'>Añadir</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
