@extends('layouts.admin')
@section('content')
    <h2>Cadastrar Status de Tarefas</h2>
    <form action="{{ route('status_tasks.store') }}" method="POST">
        @csrf
        @method('POST')
        <div>
            <label for="status">Nome do Status:</label>
            <input type="text" id="status" name="status" required>
        </div>
        <button type="submit">Cadastrar</button>
    </form>
@endsection
