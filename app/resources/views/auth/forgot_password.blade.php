@extends('layouts.login')
@section('content')
<h3>Recuperar a senha</h3>
<x-alert />
<form method="POST" action="{{ route('password.email')}}">
    @csrf
    @method('POST')
    <label for="email">E-mail:</label><br>
    <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="Digite o e-mail cadastrado" required><br><br>
    <br>
    <button type="submit">Recuperar</button>
</form>
<br><br>
<a href="{{ route('login') }}">Login</a><br>

@endsection