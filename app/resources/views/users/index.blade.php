@extends('layouts.admin')
@section('content')
    <h2>Lista de usuários</h2>
    <x-alert />
    <a href="{{ route('users.create') }}">Cadastrar Usuário</a>
    @forelse ($users as $user)
        <p>
            <strong>ID:</strong> {{ $user->id }}<br>
            <strong>Nome:</strong> {{ $user->name }}<br>
            <strong>Email:</strong> {{ $user->email }}<br>
            <strong>Status:</strong> {{ $user->statusUser ? $user->statusUser->status : 'N/A' }}<br>
            <a href="{{ route('users.show', ['user' => $user->id]) }}">Detalhes</a><br>
            <a href="{{ route('users.edit', ['user' => $user->id]) }}">Editar</a><br>
        </p>
    @empty
        <p>Nenhum usuário encontrado.</p>
    @endforelse

    {{ $users->links() }}
@endsection
