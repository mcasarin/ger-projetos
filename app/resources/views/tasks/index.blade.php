@extends('layouts.admin')
@section('content')
    <h2>Lista de Tarefas</h2>
    <x-alert />

    <a href="{{ route('tasks.create') }}">Cadastrar Tarefa</a>
    <a href="{{ route('status_tasks.index') }}">Listar Status de Tarefas</a>
    <a href="{{ route('tasks.index') }}">Listar Tarefas</a>
    

    @forelse ($tasks as $task)
        <p>
            <strong>ID:</strong> {{ $task->id }}<br>
            <strong>Nome:</strong> {{ $task->title }}<br>
            <strong>Descrição:</strong> {{ $task->description }}<br>
            <strong>Data de Início:</strong> {{ \Carbon\Carbon::parse($task->start_date)->format('d/m/Y H:i:s') }}<br>
            <strong>Data de Término:</strong> {{ \Carbon\Carbon::parse($task->due_date)->format('d/m/Y H:i:s') }}<br>
            <strong>Responsável:</strong> {{ $task->owner->name }}<br>
            <strong>Projeto:</strong> {{ $task->Project->name }}<br>
            <strong>Status:</strong> {{ $task->statusRelTask->status ?? 'Não definido' }}<br>
            <a href="{{ route('tasks.show', ['task' => $task->id]) }}">Detalhes</a><br>
            <a href="{{ route('tasks.edit', ['task' => $task->id]) }}">Editar</a><br>
            <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('Tem certeza que deseja excluir esta tarefa?')">Excluir</button>
            </form>
        </p>
        <hr>
    @empty
        <p>Nenhuma tarefa encontrada.</p>
    @endforelse

    {{ $tasks->links() }}
@endsection
