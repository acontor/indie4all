@extends("layouts.usuario.base")

@section('content')
    <main class="p-3 pb-5">
        <div class="container bg-light p-3 shadow-lg rounded mt-4">
            <div class="row mt-3 mb-5">
                <div class="col-12 col-md-10">
                    <h1>Solicitud para crear @if(collect(request()->segments())->last() == "Desarrolladora") desarrolladora @else master @endif</h1>
                </div>
                <div class="col-12 col-md-2 text-md-right">
                    <div><i class="fas fa-info-circle text-danger"></i> Requerido</div>
                    <div><i class="fas fa-info-circle"></i> Opcional</div>
                </div>
            </div>
            <form method="post" id="form-solicitud-desarrolladora" action="{{ route('usuario.solicitud.store') }}">
                @csrf
                <div class="row">
                    <div class="col-12 col-md-6 mb-3">
                        <label for="nombre">Nombre: <i class="fas fa-info-circle pop-info text-danger"
                                data-content="Nombre que tendrá la @if(collect(request()->segments())->last() == "Desarrolladora") desarrolladora @else master @endif<br><span class='text-danger'>Requerido</span>"
                                data-html="true" rel="popover" data-placement="bottom" data-trigger="hover"></i></label>
                        <input type="text" class="form-control" name="nombre" value="{{ old('nombre') }}" autofocus />
                        @error('nombre')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-12 col-md-6 mb-3">
                        <label for="email">Email de contacto: <i class="fas fa-info-circle pop-info text-danger"
                                data-content="Email de soporte de la @if(collect(request()->segments())->last() == "Desarrolladora") desarrolladora @else master @endif<br><span class='text-danger'>Requerido</span>"
                                data-html="true" rel="popover" data-placement="bottom" data-trigger="hover"></i></label>
                        <input type="email" class="form-control" name="email" value="{{ old('email') }}" />
                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                @if(collect(request()->segments())->last() == "Desarrolladora")
                    <div class="row">
                        <div class="col-12 col-md-6 mb-3">
                            <label for="telefono">Teléfono: <i class="fas fa-info-circle pop-info"
                                    data-content="Teléfono de contacto de la desarrolladora" rel="popover"
                                    data-placement="bottom" data-trigger="hover"></i></label>
                            <input type="text" class="form-control" name="telefono" value="{{ old('telefono') }}" />
                            @error('telefono')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-12 col-md-6 mb-3">
                            <label for="url">Url: <i class="fas fa-info-circle pop-info"
                                    data-content="Página web de la desarrolladora" rel="popover" data-placement="bottom"
                                    data-trigger="hover"></i></label>
                            <input type="text" class="form-control" name="url" value="{{ old('url') }}" />
                            @error('url')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="direccion">Dirección postal: <i class="fas fa-info-circle pop-info"
                                data-content="Dirección postal de la desarrolladora" rel="popover" data-placement="bottom"
                                data-trigger="hover"></i></label>
                        <input type="text" class="form-control" name="direccion" value="{{ old('direccion') }}" />
                        @error('direccion')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                @endif
                <div class="form-group">
                    <label for="comentario">@if(collect(request()->segments())->last() == "Desarrolladora") Comentario: @else Análisis: @endif <i class="fas fa-info-circle pop-info text-danger"
                            data-content="@if(collect(request()->segments())->last() == "Desarrolladora") Agrega un comentario y cuéntanos algo más @else Realiza un breve análisis para ver tus aptitudes @endif<br><span class='text-danger'>Requerido</span>" rel="popover"
                            data-html="true" data-placement="bottom" data-trigger="hover"></i></label>
                    <textarea name="comentario" class="form-control" id="comentario"
                        rows="5">{{ old('comentario') }}</textarea>
                </div>
                <small class="text-danger recaptcha-error"></small>
                <div class="g-recaptcha" data-sitekey="{{env('SITE_KEY_CAPTCHA')}}"></div>
                <input type="hidden" name="tipo" value="{{ collect(request()->segments())->last() }}">
                <button type="submit" class="btn btn-success mt-3 mb-3">Enviar</button>
            </form>
        </div>
    </main>
@endsection

@section('scripts')
    <script src="{{ asset('js/script.js') }}"></script>
@endsection
