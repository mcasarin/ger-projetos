@extends('layouts.admin')
@section('content')
    <h2>Detalhe do usuário</h2>
    <a href="{{ route('users.index') }}">Lista de Usuários</a><br>
    <x-alert />
    
        <p>
            <strong>ID:</strong> {{ $user->id }}<br>
            <strong>Nome:</strong> {{ $user->name }}<br>
            <strong>Email:</strong> {{ $user->email }}<br>
            <strong>Status:</strong> {{ $user->statusUser ? $user->statusUser->status : 'N/A' }}<br>
            <strong>Criado em:</strong> {{ \Carbon\Carbon::parse($user->created_at)->format('d/m/Y H:i:s') }}<br>
            <strong>Atualizado em:</strong> {{ \Carbon\Carbon::parse($user->updated_at)->format('d/m/Y H:i:s') }}<br><br>
            <a href="{{ route('users.edit_password', ['user' => $user->id]) }}">Mudar Senha</a><br>
        </p>
    
@endsection
