@extends('layouts.front')
@section('title', 'Agencia de Publicidad en Bogotá')

@section('content')
    <form method="POST" class="LoginForm row middle center" action="/auth/facebook/register">

        <div class="col-16 medium-16 small-16">
            {{ csrf_field() }}
            <h1>Finaliza tu registro</h1>
            <figure>
                <img src="{{$user->avatar}}" alt="">
            </figure>
            <div>
                <label for="name">Nombre</label>
                <input id="name" type="text" name="email" value="{{ $user->name }}" readonly>
            </div>
            <div>
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ $user->email }}" readonly>
            </div>
            <div>
                <label for="username">Nombre de usuario</label>
                <input type="text" id="username" name="username" value="{{old('username')}}">
                @if ($errors->has('username'))
                    <span class="Error"> {{ first('username') }}</span>
                @endif
            </div>
                <div class="row between">
                    <label>

                    </label>
                    <button type="submit">Registrarse</button>
                </div>
        </div>
    </form>
@endsection
@section('scripts')
@endsection