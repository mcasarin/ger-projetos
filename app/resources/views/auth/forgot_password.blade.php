@extends('layouts.login')
@section('content')
<h1 class="title-login">Recuperar a senha</h1>
<x-alert />
<form method="POST" action="{{ route('password.email')}}">
    @csrf
    @method('POST')
    <div class="form-group-login">
        <label for="email" class="form-label-login">E-mail:</label>
        <input type="email" class="form-input-login" name="email" id="email" value="{{ old('email') }}" placeholder="Digite o e-mail cadastrado" required>
    </div>
    <div class="btn-group-login">
        <a href="{{ route('login') }}">Login</a>
        <button class="btn-primary-md" type="submit">Recuperar</button>
    </div>
    
</form>



@endsection