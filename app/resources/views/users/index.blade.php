@extends('layouts.admin')
@section('content')
    <h2>Lista de usuários</h2>
    <x-alert />
    @forelse ($users as $user)
        <p>
            <strong>ID:</strong> {{ $user->id }}<br>
            <strong>Nome:</strong> {{ $user->name }}<br>
            <strong>Email:</strong> {{ $user->email }}<br>
        </p>
    @empty
        <p>Nenhum usuário encontrado.</p>
    @endforelse
@endsection
