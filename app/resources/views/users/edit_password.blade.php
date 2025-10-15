@extends('layouts.admin')
@section('content')
    <h1>Mudar senha do usuário</h1>
    <form action="{{ route('users.update_password', ['user' => $user->id]) }}" method="POST">
        @csrf
        @method('PUT')
        <div>
            <label for="password">Senha:</label>
            <input type="password" id="password" name="password">
        </div>
        <br>
        <button type="submit">Salvar</button>
@endsection
