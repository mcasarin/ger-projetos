@extends('layouts.admin')
@section('content')
    <h3>Mudar senha</h3>
    <form action="{{ route('profiles.update_password', ['user' => $user->id]) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div>
            <label for="password">Senha:</label>
            <input type="password" id="password" name="password" required>
            {{-- BLOCO DE ERRO POR CAMPO --}}
            @error('password')
                <span style="color: red; font-size: 0.8em;">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="password_confirmation">Confirmar senha:</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required>
            {{-- BLOCO DE ERRO POR CAMPO --}}
            @error('password_confirmation')
                <span style="color: red; font-size: 0.8em;">{{ $message }}</span>
            @enderror
        </div>
        <br>
        <button type="submit">Salvar</button>
    </form>
        
@endsection
