@extends('../layouts.admin')

@section('content')
    <div class="container">
        <div class='row'>
            <div class='col-sm-8 offset-sm-2'>
                <h1 class='display-3'>Añadir un género</h1>
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
                    @if (session()->get('success'))
                        <div class='alert alert-success'>
                            {{ session()->get('success') }}
                        </div>
                    @endif

                    <form method='post' action="{{ route('generos.store') }}">
                        @csrf
                        <div class='form-group'>
                            <label for='nombre'>Nombre:</label>
                            <input type='text' class='form-control' name='nombre' />
                        </div>
                        <button type='submit' class='btn btn-primary'>Añadir</button>
                    </form>
                    <div class="container">
                        <div class='row'>

                            <table class="table table-striped">
                                <thead>
                                    </tr>
                                    <td class="align-middle">Nombre</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($generos as $genero)
                                        <tr>
                                            <td class="align-middle">
                                                <form method='post' action="{{ route('generos.update', $genero->id) }}">
                                                    @method('PATCH')
                                                    @csrf
                                                    <input type='text' placeholder={{ $genero->nombre }} name='nombre'>
                                                    <button type='submit' class='btn btn-primary'>Actualizar</button>
                                                </form>
                                            </td>
                                            <td class="align-middle">
                                                <form action="{{ route('generos.destroy', $genero->id) }}" method='post'>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class='btn btn-danger' type='submit'>Borrar</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $generos->links('pagination::bootstrap-4') }}

                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
