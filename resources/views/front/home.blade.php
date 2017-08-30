@extends('layouts.front')
@section('title', 'Agencia de Publicidad en Bogotá')

@section('content')
    <form method="POST" class="LoginForm row middle center" action="{{ route('login') }}">

        <div class="col-16 medium-16 small-16">
            {{ csrf_field() }}
            <h1>Iniciar sesión</h1>
            <div>
                <label for="email">Introduce tu e-mail</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
                @if ($errors->has('email'))
                    <span  class="Error">¡{{ $errors->first('email') }}</span>
                @endif
            </div>

            <div>
                <label for="password">Contraseña</label>
                <input id="password" type="password" name="password" required>
                @if ($errors->has('password'))
                    <span class="Error"> {{ first('password') }}</span>
                @endif

                <div class="row between">
                    <label>
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Recuerdame
                    </label>
                    <button type="submit">Iniciar sesión</button>
                </div>
                <div class="LoginForm-links">
                    <a href="{{ route('password.request') }}">¿Olvidaste la contraseña?</a>
                    <a href="/registro">¿No tienes una cuenta?</a>
                    <a href="/auth/facebook">
                        <svg width="18px" height="18px" viewBox="0 0 18 18" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <g id="iPad-Pro-Landscape" transform="translate(-357.000000, -1144.000000)">
                                    <g id="noun_467225_cc" transform="translate(357.000000, 1144.000000)">
                                        <g id="Group">
                                            <path d="M12.06,5.22 L12.06,3.825 L10.17,3.825 C9.18,3.825 8.37,4.68 8.37,5.715 L8.37,7.515 L6.525,7.515 L6.525,8.82 L8.37,8.82 L8.37,14.04 L9.945,14.04 L9.945,8.82 L12.06,8.82 L12.06,7.515 L9.945,7.515 L9.945,5.985 C9.945,5.58 10.26,5.22 10.62,5.22 L12.06,5.22 Z" id="Shape"></path>
                                            <path d="M14.58,0.09 L3.78,0.09 C1.935,0.09 0.405,1.62 0.405,3.465 L0.405,14.265 C0.405,16.11 1.935,17.64 3.78,17.64 L14.58,17.64 C16.425,17.64 17.955,16.11 17.955,14.265 L17.955,3.465 C17.955,1.62 16.47,0.09 14.58,0.09 Z M9.945,5.985 L9.945,7.515 L12.06,7.515 L12.06,8.82 L9.945,8.82 L9.945,14.04 L8.37,14.04 L8.37,8.82 L6.525,8.82 L6.525,7.515 L8.37,7.515 L8.37,5.715 C8.37,4.68 9.18,3.825 10.17,3.825 L12.06,3.825 L12.06,5.22 L10.62,5.22 C10.26,5.22 9.945,5.58 9.945,5.985 Z" id="Shape" fill="#5E89E0" fill-rule="nonzero"></path>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </svg>
                        Inicia sesión con Facebook
                    </a>
                </div>
            </div>
            <div>

            </div>

        </div>
    </form>
@endsection
@section('scripts')
@endsection