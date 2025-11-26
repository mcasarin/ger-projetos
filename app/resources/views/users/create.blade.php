@extends('layouts.admin')
@section('content')
    <h1>Cadastrar usuário</h1>
    <x-alert />
    <form action="{{ route('users.store') }}" method="POST">
        @csrf
        @method('POST')
        <div>
            <label for="name">Nome do Usuário:</label>
            <input type="text" id="name" name="name">
        </div>
        <div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email">
        </div>
        <div>
            <label for="role">Papel:</label>
            @forelse ($roles as $role)
                @if ($role != 'Super Admin' || Auth::user()->hasRole('Super Admin'))
                    <input type="checkbox" id="role_{{Str::slug($role)}}" name="roles[]" value="{{ $role }}" {{ collect(old('roles'))->contains($role) ? 'checked' : '' }}>
                <label for="role_{{Str::slug($role)}}">{{ $role }}</label>
                @endif
            @empty
                <p>Nenhum papel disponível</p>
            @endforelse
        </div>
        <div>
            <label for="password">Senha:</label>
            <input type="password" id="password" name="password">
        </div>
        <button type="submit">Cadastrar</button>
@endsection
