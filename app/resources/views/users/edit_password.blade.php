@extends('layouts.admin')
@section('content')
    <h1>Mudar senha do usuário</h1>
    <form action="{{ route('users.update_password', ['user' => $user->id]) }}" method="POST">
        @csrf
        @method('PUT')
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div>
            <label for="password">Senha:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <div>
            <label for="password_confirmation">Confirmar senha:</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required>
        </div>
        <br>
        <button type="submit">Salvar</button>
    </form>
        
@endsection
