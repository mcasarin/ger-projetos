@extends('layouts.admin')
@section('content')
    <h1>Editar usuário</h1>
    <form action="{{ route('users.update', ['user' => $user->id]) }}" method="POST">
        @csrf
        @method('PUT')
        <div>
            <label for="name">Nome do Usuário:</label>
            <input type="text" id="name" name="name" value="{{
            old('name', $user->name) }}" >
        </div>
        <div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required>
        </div>
        <div>
            <label for="role">Papel:</label>
            @forelse ($roles as $role)
                @if ($role != 'Super Admin' || Auth::user()->hasRole('Super Admin'))
                    <input type="checkbox" id="role_{{Str::slug($role)}}" name="roles[]" value="{{ $role }}" {{ in_array($role, old('roles', $userRole ?? [])) ? 'checked' : '' }}>
                    <label for="role_{{Str::slug($role)}}">{{ $role }}</label>
                @endif
            @empty
                <p>Nenhum papel disponível</p>
            @endforelse
        </div>
        <button type="submit">Atualizar</button>
@endsection
