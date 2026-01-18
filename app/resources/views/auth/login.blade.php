@extends('layouts.login')
@section('content')
<h1 class="title-login">Área restrita</h1>
<x-alert />
<form class="mt-4" method="POST" action="{{ route('login.process') }}">
    @csrf
    @method('POST')
    <div class="form-group-login">
        <label for="email" class="form-label-login">E-mail:</label>
        <input type="email" class="form-input-login" name="email" id="email" value="{{ old('email') }}">
    </div>
    <div class="form-group-login">
        <label for="password" class="form-label-login">Senha:</label>
        <input type="password" class="form-input-login" name="password" id="password" value="{{ old('password') }}">
    </div>
    <div class="btn-group-login">
        <a href="{{ route('password.request') }}">Esqueceu a senha?</a>
        <button type="submit" class="btn-primary-md">Acessar</button>
    </div>
    
</form>


@endsection