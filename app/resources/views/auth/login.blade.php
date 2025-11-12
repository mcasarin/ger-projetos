@extends('layouts.login')
@section('content')
<h3>Área restrita</h3>
<x-alert />
<form method="POST" action="{{ route('login.process') }}">
    @csrf
    @method('POST')
    <label for="email">E-mail:</label><br>
    <input type="email" name="email" id="email" value="{{ old('email') }}"><br><br>
    <label for="password">Senha:</label><br>
    <input type="password" name="password" id="password" value="{{ old('password') }}"><br><br>
    <button type="submit">Acessar</button>
</form>
<br><br>
<a href="#">Esqueceu a senha?</a><br>
<a href="#">Criar uma conta</a>
@endsection