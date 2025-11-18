@extends('layouts.admin')
@section('content')
    <h1>Editar usuário</h1>
    <form action="{{ route('profiles.update', ['user' => $user->id]) }}" method="POST">
        @csrf
        @method('PUT')
        <div>
            <label for="name">Nome:</label>
            <input type="text" id="name" name="name" value="{{
            old('name', $user->name) }}" >
        </div>
        <div>
            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required>
        </div>
        <button type="submit">Atualizar</button>
@endsection
