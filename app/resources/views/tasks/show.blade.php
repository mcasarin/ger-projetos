@extends('layouts.admin')
@section('content')
    <h2>Detalhe da Tarefa</h2>

    <a href="{{ route('tasks.index') }}">Voltar para a lista</a><br><br>
    <x-alert />

        <p>
            <strong>ID:</strong> {{ $task->id }}<br>
            <strong>Título:</strong> {{ $task->title }}<br>
            <strong>Descrição:</strong> {{ $task->description }}<br>
            <strong>Projeto:</strong> {{ $task->Project->name }}<br>
            <strong>Data de Início:</strong> {{ \Carbon\Carbon::parse($task->start_date)->format('d/m/Y') }}<br>
            <strong>Data de Término:</strong> {{ \Carbon\Carbon::parse($task->due_date)->format('d/m/Y') }}<br>
            <strong>Responsável:</strong> {{ $task->owner->name }}<br>
            <strong>Status:</strong> {{ $task->statusRelTask->status }}<br>
            <strong>Criado em:</strong> {{ \Carbon\Carbon::parse($task->created_at)->format('d/m/Y H:i:s') }}<br>
            <strong>Atualizado em:</strong> {{ \Carbon\Carbon::parse($task->updated_at)->format('d/m/Y H:i:s') }}<br>
        </p>
@endsection

