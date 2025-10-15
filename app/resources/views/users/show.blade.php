@extends('layouts.admin')
@section('content')
    <h2>Lista de usuários</h2>
    <x-alert />
    
        <p>
            <strong>ID:</strong> {{ $user->id }}<br>
            <strong>Nome:</strong> {{ $user->name }}<br>
            <strong>Email:</strong> {{ $user->email }}<br>
            <strong>Criado em:</strong> {{ \Carbon\Carbon::parse($user->created_at)->format('d/m/Y H:i:s') }}<br>
            <strong>Atualizado em:</strong> {{ \Carbon\Carbon::parse($user->updated_at)->format('d/m/Y H:i:s') }}<br><br>
            <a href="{{ route('users.edit_password', ['user' => $user->id]) }}">Mudar Senha</a><br>
        </p>
    
@endsection
