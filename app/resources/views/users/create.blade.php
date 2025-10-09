@extends('layouts.admin')
@section('content')
    <h1>Cadastrar usuário</h1>
    <form action="{{ route('users.store') }}" method="POST">
        @csrf
        @method('POST')
        <div>
            <label for="name">Nome do Usuário:</label>
            <input type="text" id="name" name="name" required>
        </div>
        <div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div>
            <label for="password">Senha:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit">Cadastrar</button>
@endsection
