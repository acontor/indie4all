@extends('layouts.usuario.base')
@section('styles')
<link href="{{ asset('css/login_signup.css') }}" rel="stylesheet">   
@endsection
@section('content')


<div class="container">
    <div class="row justify-content-center ">
          <div class="user_options-container ">
             <div class="user_options-text">
                <div class="user_options-unregistered">
                   <h2 class="user_unregistered-title">¿No tienes cuenta?</h2>
                   <p class="user_unregistered-text">Registrate ahora para para ver todo el contenido de la web.</p>
                   <button class="user_unregistered-signup" id="signup-button">Registrarse</button>
                </div>
                <div class="user_options-registered">
                   <h2 class="user_registered-title">¿Tienes ya una cuenta?</h2>
                   <p class="user_registered-text">Identifícate para poder disfrutar de todo el contenido de la web.</p>
                   <button class="user_registered-login" id="login-button">Identificarse</button>
                </div>
             </div>
             <div class="user_options-forms  mt-5" id="user_options-forms">
                <div class="user_forms-login">
                   <h2 class="forms_title">Identificación</h2>
                   <form method="POST" action="{{ route('login') }}">
                      @csrf
                      <fieldset class="forms_fieldset">
                         <div class="forms_field">
                            <input id="email" type="email" class="forms_field-input @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                         </div>
                         <div class="forms_field">
                            <input id="password" type="password" class="forms_field-input" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                         </div>
                         <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                               <div class="form-check">
                                  <input class="form-check-input forms_buttons-forgot" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                  <label class="form-check-label forms_buttons-forgot" for="remember">
                                  {{ __('Remember Me') }}
                                  </label>
                               </div>
                            </div>
                         </div>
                      </fieldset>
                      <div class="forms_buttons">
                         @if (Route::has('password.request'))
                            <a class="forms_buttons-forgot" href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                        @endif                        
                        <button type="submit" class="forms_buttons-action">
                            {{ __('Login') }}
                        </button>
                      </div>
                   </form>
                </div>
                <div class="user_forms-signup">
                   <h2 class="forms_title">Registro</h2>
                   <form class="forms_form" method="POST" action="{{ route('register') }}">
                      @csrf
                      <fieldset class="forms_fieldset">
                         <div class="forms_field">
                            <input id="name" type="text" placeholder="Nombre" class="forms_field-input @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                         </div>
                         <div class="forms_field">
                            <input id="username" type="text" placeholder="Nick" class="forms_field-input @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>
                         </div>
                         <div class="forms_field">
                            <input id="email" type="email" placeholder="Email" class="forms_field-input @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                         </div>
                         <div class="forms_field">
                            <input id="password" type="password" placeholder="Password" class= "forms_field-input @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                         </div>
                         <div class="forms_field">
                            <input id="password-confirm" type="password" placeholder="password-confirm" class= "forms_field-input @error('password') is-invalid @enderror" name="password_confirmation" required autocomplete="new-password">
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                         </div>
                      </fieldset>
                      <div class="forms_buttons">
                         <input type="submit" value="Sign up" class="forms_buttons-action">
                      </div>
                   </form>
                </div>
             </div>
          </div>
       </div>
    </div>
</div>

<script>
    /**
 * Variables
 */
const signupButton = document.getElementById('signup-button'),
    loginButton = document.getElementById('login-button'),
    userForms = document.getElementById('user_options-forms')

/**
 * Add event listener to the "Sign Up" button
 */
signupButton.addEventListener('click', () => {
  userForms.classList.remove('bounceRight')
  userForms.classList.add('bounceLeft')
}, false)

/**
 * Add event listener to the "Login" button
 */
loginButton.addEventListener('click', () => {
  userForms.classList.remove('bounceLeft')
  userForms.classList.add('bounceRight')
}, false)
    </script>
@endsection