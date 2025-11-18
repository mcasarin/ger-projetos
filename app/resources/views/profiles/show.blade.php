@extends('layouts.admin')
@section('content')
    <h2>Perfil</h2>
    <a href="{{ route('profiles.edit_password', ['user' => $user->id]) }}">Mudar Senha</a><br>
    <a href="{{ route('profiles.edit', ['user' => $user->id]) }}">Editar perfil</a><br>
    <x-alert />
    
        <p>
            <strong>ID:</strong> {{ $user->id }}<br>
            <strong>Nome:</strong> {{ $user->name }}<br>
            <strong>Email:</strong> {{ $user->email }}<br>
            <strong>Status:</strong> {{ $user->statusUser ? $user->statusUser->status : 'N/A' }}<br><br>
            
        </p>
    
@endsection
