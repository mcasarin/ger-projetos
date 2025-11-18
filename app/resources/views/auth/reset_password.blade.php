@extends('layouts.login')
@section('content')
<h3>Área restrita</h3>
<x-alert />
<form method="POST" action="{{ route('password.update') }}">
    @csrf
    @method('POST')
    <input type="hidden" name="token" value="{{ $token }}">

    <label for="email">E-mail:</label><br>
    <!-- request para pegar o email da url, enviada -->
    <input type="email" name="email" id="email" value="{{ old('email', request()->query('email')) }}" ><br><br>
    <div>
            <label for="password">Digite a nova senha:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <div>
            <label for="password_confirmation">Confirmar senha:</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required>
        </div>
    <button type="submit">Salvar</button>
</form>
<br><br>
<a href="{{ route('login') }}">Login</a><br>

@endsection