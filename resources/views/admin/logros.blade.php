<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('/js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
</head>

<body>

    <main class="py-4">
        <div class="container">
            <div class='row'>
                <div class='col-sm-8 offset-sm-2'>

                    <h1 class='display-3'>Logros</h1>

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

                        <a href="#" class='btn btn-primary mb-3 nuevo-logro-button'>Nuevo logro</a>

                        <div class="d-none nuevo-logro-div">
                            <form method='post' action="{{ route('logros.store') }}">
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
                                    <input type='text' class='form-control' name='icono' />
                                </div>
                                <button type='submit' class='btn btn-success mb-3'>Añadir</button>
                            </form>
                        </div>

                        <table class='table table-striped'>
                            <thead>
                                <tr>
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
                                        <form action="{{ route('logros.update', $logro->id) }}" method='post'>
                                            @csrf
                                            @method('PATCH')
                                            <td class="align-middle"><input type="text" placeholder="Nombre"
                                                    value="{{ $logro->nombre }}" name="nombre"></td>
                                            <td class="align-middle"><textarea id="descripcion" class="align-middle"
                                                    placeholder="Descripción" name="descripcion" rows="1"
                                                    cols="40">{{ $logro->descripcion }}</textarea></td>
                                            <td class="align-middle"><input type='text' placeholder="Icono"
                                                    value="{{ $logro->icono }}" name="icono">
                                            </td>
                                            <td class="align-middle"><button type="submit"
                                                    class='btn btn-primary'>Editar</button></td>
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
                        {{ $logros->links("pagination::bootstrap-4") }}
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>

</html>
