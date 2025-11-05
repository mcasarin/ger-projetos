@extends('layouts.admin')
@section('content')
    <h2>Listagem de Status das tarefas</h2>
    <x-alert />
    
    @forelse ($status_task as $status)
        <p>
            <strong>ID:</strong> {{ $status->id }}<br>
            <strong>Nome:</strong> {{ $status->status }}<br>
        </p>
    @empty
        <p>Nenhum status de tarefa encontrado.</p>
    @endforelse
@endsection
