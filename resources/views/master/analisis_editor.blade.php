@extends("layouts.master.base")

@section("content")
    <div class="container">
        <div class="box-header">
            <h1>@isset($analisis) Editar @else Nuevo @endisset análisis</h1>
        </div>
        <div class="box">
            @isset($analisis)
                @if($analisis->ban)
                    <div class="row">
                        <span class="alert alert-danger w-100">
                            <p>Su noticia está suspendida por el siguiente motivo. Puedes corregir los problemas y contactar con soporte@indie4all.com para volver a publicarlo.</p>
                            <small>{{$analisis->motivo}}</small>
                        </span>
                    </div>
                @endif
                <form action="{{ route('master.analisis.update', $analisis->id) }}" method='post' enctype="multipart/form-data">
                    @method("PATCH")
            @else
                <form action="{{ route('master.analisis.store') }}" method='post' enctype="multipart/form-data">
            @endif
                @csrf
                @empty($analisis)
                    <div class="form-group">
                        <label for="juego">Juego <i class="fas fa-info-circle pop-info text-danger"
                            data-content="Juego que vas a analizar<br><span class='text-danger'>Requerido</span>"
                            data-html="true" rel="popover" data-placement="bottom" data-trigger="hover"></i></label>
                        <select id="juego" class="form-control select2" data-ui-jp="select2" data-ui-options="{theme: 'bootstrap'}" name="juego">
                            @foreach ($juegos as $juego)
                                @if($juego->posts->where('master_id', Auth::user()->master->id)->count() == 0)
                                    <option value="{{ $juego->id }}" @if($juego->id == $id) selected @endif>{{ $juego->nombre }}</option>
                                @endif
                            @endforeach
                        </select>
                        @error('juego')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                @endempty
                <div class="row">
                    <div class="col-12 col-md-6">
                        <label for="titulo">Título <i class="fas fa-info-circle pop-info text-danger"
                            data-content="Título del análisis<br><span class='text-danger'>Requerido</span>"
                            data-html="true" rel="popover" data-placement="bottom" data-trigger="hover"></i></label>
                        <input type="text" class="form-control" name="titulo" value="@isset($analisis){{ $analisis->titulo }}@endisset" />
                        @error('titulo')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-12 col-md-6">
                        <label for="calificacion">Calificación <i class="fas fa-info-circle pop-info text-danger"
                            data-content="Calificación del juego.<br>Min:1 - Max: 10<br><span class='text-danger'>Requerido</span>"
                            data-html="true" rel="popover" data-placement="bottom" data-trigger="hover"></i></label>
                        <input type="number" class="form-control" name="calificacion" value="@isset($analisis){{ $analisis->calificacion }}@endisset" />
                        @error('calificacion')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group mt-3">
                    <label for="contenido">Contenido <i class="fas fa-info-circle pop-info text-danger"
                        data-content="Contenido del análisis<br><span class='text-danger'>Requerido</span>"
                        data-html="true" rel="popover" data-placement="bottom" data-trigger="hover"></i></label>
                    <textarea class="form-control" name="contenido" id="editor">
                        @isset($analisis)
                            {{ $analisis->contenido }}
                        @endisset
                    </textarea>
                    @error('contenido')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <button type="submit" class="btn btn-success">@isset($analisis) Editar @else Crear @endisset</button>
            </form>
        </div>
    </div>
@endsection

@section("scripts")
    <script src="{{ asset('js/script.js') }}"></script>
    <script src="https://cdn.ckeditor.com/4.15.0/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace("contenido", {
            filebrowserUploadUrl: "{{ route('master.analisis.upload', ['_token' => csrf_token()]) }}",
            filebrowserUploadMethod: "form"
        });
    </script>
@endsection
