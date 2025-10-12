@extends('layouts.admin')
@section('content')
    <h1>Editar usuário</h1>
    <form action="{{ route('users.update', ['user' => $user->id]) }}" method="POST">
        @csrf
        @method('PUT')
        <div>
            <label for="name">Nome do Usuário:</label>
            <input type="text" id="name" name="name" value="{{
            old('name', $user->name) }}" required>
        </div>
        <div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required>
        </div>
        <div>
            <label for="password">Senha:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit">Atualizar</button>
@endsection
