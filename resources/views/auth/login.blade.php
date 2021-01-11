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
                                    <input type="email" name="email" class="form-control" id="email" required
                                        autocomplete="email" autofocus>
                                </div>
                                <div class="form-group last mb-4">
                                    <label for="password">Contraseña</label>
                                    <input type="password" name="password" class="form-control" id="password" required
                                        autocomplete="current-password">
                                </div>
                                <div class="d-flex mb-4 align-items-center">
                                    <input type="submit" value="Iniciar" class="btn btn-primary">
                                    <span class="ml-auto"><a href="#" class="forgot-pass">
                                            @if (Route::has('password.request'))
                                                <a class="forms_buttons-forgot" href="{{ route('password.request') }}">
                                                    Recordar Contraseña
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
                                    <input type="text" name="name" class="form-control" id="name" required
                                        autocomplete="name">
                                </div>
                                <div class="form-group first">
                                    <label for="username">Nombre de usuario</label>
                                    <input type="text" name="username" class="form-control" id="username" required
                                        autocomplete="username">
                                </div>
                                <div class="form-group first">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" class="form-control" id="email" required
                                        autocomplete="email">
                                </div>
                                <div class="form-group first">
                                    <label for="password">Contraseña</label>
                                    <input type="password" name="password" class="form-control" id="password" required>
                                </div>
                                <div class="form-group last mb-4">
                                    <label for="password-confirm">Repetir contraseña</label>
                                    <input type="password" name="password-confirm" class="form-control"
                                        id="password-confirm" required>
                                </div>
                                <div class="d-flex mb-4 align-items-center">
                                    <input type="submit" value="Registrar" class="btn btn-primary">
                                </div>
                            </form>
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
