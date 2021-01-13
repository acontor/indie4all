@extends('layouts.usuario.base')

@section('styles')
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="content">
        <div class="container bg-white p-5 shadow">
            <div class="row">
                <div class="col-md-6">
                    <img class="img-fluid" src="{{ asset('images/logo.png') }}" alt="">
                </div>
                <div class="col-md-6 contents">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <h3>Bienvenido a indie4all</h3>
                                <p>Tu plataforma para disfrutar de los juegos indies.</p>
                            </div>
                            <p class="text-center header-login">¿Aún no estás <a
                                href="" class="btn-change">registrado</a>?.</p>
                            <p class="text-center header-register d-none">Si ya estás registrado, <a href="" class="btn-change">inicia sesión</a>.</p>
                            <form method="POST" action="{{ route('login') }}" class="login-form">
                                @csrf
                                @error('email')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                                <div class="form-group first">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" class="form-control" required
                                        autocomplete="email" autofocus>
                                </div>
                                <div class="form-group last mb-4">
                                    <label for="password">Contraseña</label>
                                    <input type="password" name="password" class="form-control" required
                                        autocomplete="current-password">
                                </div>
                                <div class="d-flex mb-4 align-items-center mt-4">
                                    <input type="submit" value="Iniciar" class="btn btn-primary">
                                    <span class="ml-auto"><a href="#" class="forgot-pass">
                                        @if (Route::has('password.request'))
                                            <a class="forms_buttons-forgot" href="{{ route('password.request') }}">
                                                Recuperar Contraseña
                                            </a>
                                        @endif
                                    </span>
                                </div>
                            </form>
                            <form method="POST" action="{{ route('register') }}" class="register-form d-none">
                                @csrf
                                @error('email')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                                <div class="form-group first">
                                    <label for="name">Nombre</label>
                                    <input type="text" name="name" class="form-control" required
                                        autocomplete="name">
                                </div>
                                <div class="form-group first">
                                    <label for="username">Nombre de usuario</label>
                                    <input type="text" name="username" class="form-control" required
                                        autocomplete="username">
                                </div>
                                <div class="form-group first">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" class="form-control" required
                                        autocomplete="email">
                                </div>
                                <div class="form-group first">
                                    <label for="password">Contraseña</label>
                                    <input type="password" name="password" class="form-control" required>
                                </div>
                                <div class="form-group last mb-4">
                                    <label for="password_confirmation">Repetir contraseña</label>
                                    <input type="password" name="password_confirmation" class="form-control" required>
                                </div>
                                <div class="d-flex mb-4 align-items-center mt-4">
                                    <input type="submit" value="Registrar" class="btn btn-primary">
                                </div>
                            </form>
                            <div id="recaptcha"></div>
                            <span class="error-recaptcha text-danger"></span>
                            <span class="d-block text-left my-4 text-muted">&mdash; o iniciar con &mdash;</span>
                            <div class="social-login">
                                <a href="{{ url('auth/facebook') }}" class="facebook">
                                    <span class="fab fa-facebook-f mr-3"></span>
                                </a>
                                <a href="{{ url('auth/google') }}" class="google">
                                    <span class="fab fa-google mr-3"></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(function() {
            'use strict';

            var interval = setInterval(function(){
                grecaptcha.render('recaptcha', {
                    'sitekey': '6Lc2ufwZAAAAAFtjN9fasxuJc0OEf670ruHSTEfP'
                });
                clearInterval(interval);
            }, 100);

            $('form').on('submit', function(e) {
                if (grecaptcha.getResponse().length === 0) {
                    e.preventDefault();
                    $('.error-recaptcha').text('Completa el captcha');
                }
            });

            $('.form-control').on('input', function() {
                var $field = $(this).closest('.form-group');
                if (this.value) {
                    $field.addClass('field--not-empty');
                } else {
                    $field.removeClass('field--not-empty');
                }
            });

            $('.btn-change').on('click', function(e) {
                e.preventDefault();
                $('.register-form').toggleClass('d-none');
                $('.login-form').toggleClass('d-none');
                $('.header-register').toggleClass('d-none');
                $('.header-login').toggleClass('d-none');
            });
        });

    </script>
@endsection
